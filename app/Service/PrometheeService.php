<?php

namespace App\Service;

use App\Models\Result;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Criteria;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PrometheeService
{
    protected array $evaluationMatrix = [];
    protected array $preferenceMatrix = [];
    protected array $differenceMatrix = [];
    protected array $hMatrix = [];

    public function calculateByPeriod(int $periodId): array
    {
        $classGroups = SchoolClass::whereHas('students.scores', fn($q) => $q->where('period_id', $periodId))
            ->get()
            ->groupBy(fn($class) => preg_replace('/\s\d+$/', '', $class->name));

        $allResults = [];
        $allEvaluationMatrices = [];
        $allPreferenceMatrices = [];
        $allDifferenceMatrices = [];
        $allHMatrix = [];

        foreach ($classGroups as $groupName => $classes) {
            $students = $this->getStudentsFromClasses($classes, $periodId);

            if ($students->isEmpty()) {
                continue;
            }

            $calculation = $this->calculateForStudentGroup($students);
            // Jangan save di sini, simpan nanti di controller supaya lebih fleksibel
            //$this->savePassingStudents($calculation['results'], $periodId);

            $allEvaluationMatrices[$groupName] = $this->evaluationMatrix;
            $allPreferenceMatrices[$groupName] = $this->preferenceMatrix;
            $allDifferenceMatrices[$groupName] = $this->differenceMatrix;
            $allHMatrix[$groupName] = $this->hMatrix;

            $allResults[] = [
                'group_name' => $groupName,
                'group_slug' => Str::slug($groupName),
                'classes' => $classes->pluck('name')->sort()->values(),
                'results' => $calculation['results'],
            ];
        }

        return [
            'results' => collect($allResults)->sortBy('group_name')->values()->all(),
            'evaluationMatrices' => $allEvaluationMatrices,
            'preferenceMatrices' => $allPreferenceMatrices,
            'differenceMatrices' => $allDifferenceMatrices,
            'allHMatrix' => $allHMatrix,
        ];
    }

    private function getStudentsFromClasses(Collection $classes, int $periodId): Collection
    {
        return Student::whereIn('class_id', $classes->pluck('id'))
            ->whereHas('scores', fn($q) => $q->where('period_id', $periodId))
            ->with(['scores' => fn($q) => $q->where('period_id', $periodId)->with('criteria')])
            ->get();
    }

    private function calculateForStudentGroup(Collection $students): array
    {
        $criteria = Criteria::with('weights')->get();

        $weights = $criteria->mapWithKeys(fn($c) => [$c->id => $c->weights->first()->weight ?? 0]);
        $prefTypes = $criteria->mapWithKeys(fn($c) => [$c->id => $c->preference_function ?? 'v-shape']);
        $thresholdQs = $criteria->mapWithKeys(fn($c) => [$c->id => $c->q ?? 0]);
        $thresholdPs = $criteria->mapWithKeys(fn($c) => [$c->id => $c->p_threshold ?? 0]);

        $this->evaluationMatrix = $students->mapWithKeys(fn($s) => [
            $s->id => $s->scores->mapWithKeys(fn($sc) => [
                $sc->criteria_id => $sc->value
            ])->toArray()
        ])->toArray();

        $this->differenceMatrix = $this->buildDifferenceMatrix($students, $this->evaluationMatrix, $criteria);

        $this->hMatrix = $this->buildHMatrix(
            $students,
            $this->evaluationMatrix,
            $criteria,
            $prefTypes,
            $thresholdQs,
            $thresholdPs
        );

        $this->preferenceMatrix = $this->buildQMatrix(
            $students,
            $this->hMatrix,
            $criteria,
            $weights
        );

        $flows = $this->calculateFlows($students, $this->preferenceMatrix);

        $ranked = $this->rankStudents($flows);

        return [
            'results' => $ranked,
        ];
    }

    private function buildDifferenceMatrix(Collection $students, array $evaluationMatrix, Collection $criteria): array
    {
        $differenceMatrix = [];

        foreach ($students as $studentA) {
            foreach ($students as $studentB) {
                foreach ($criteria as $criterion) {
                    $valueA = $evaluationMatrix[$studentA->id][$criterion->id] ?? 0;
                    $valueB = $evaluationMatrix[$studentB->id][$criterion->id] ?? 0;

                    $differenceMatrix[$studentA->id][$studentB->id][$criterion->id] =
                        $this->calculateDifference($valueA, $valueB, $criterion->type);
                }
            }
        }

        return $differenceMatrix;
    }

    private function buildHMatrix(
        Collection $students,
        array $evaluationMatrix,
        Collection $criteria,
        Collection $prefTypes,
        Collection $thresholdQs,
        Collection $thresholdPs
    ): array {
        $hMatrix = [];

        foreach ($students as $studentA) {
            foreach ($students as $studentB) {
                foreach ($criteria as $criterion) {
                    $valueA = $evaluationMatrix[$studentA->id][$criterion->id] ?? 0;
                    $valueB = $evaluationMatrix[$studentB->id][$criterion->id] ?? 0;

                    $d = $this->calculateDifference($valueA, $valueB, $criterion->type);

                    $hMatrix[$studentA->id][$studentB->id][$criterion->id] = $this->preferenceFunction(
                        $d,
                        $prefTypes[$criterion->id],
                        $thresholdQs[$criterion->id],
                        $thresholdPs[$criterion->id]
                    );
                }
            }
        }

        return $hMatrix;
    }

    private function buildQMatrix(
        Collection $students,
        array $hMatrix,
        Collection $criteria,
        Collection $weights
    ): array {
        $qMatrix = [];

        foreach ($students as $studentA) {
            foreach ($students as $studentB) {
                if ($studentA->id === $studentB->id) {
                    $qMatrix[$studentA->id][$studentB->id] = 0;
                    continue;
                }

                $total = 0;

                foreach ($criteria as $criterion) {
                    $h = $hMatrix[$studentA->id][$studentB->id][$criterion->id] ?? 0;
                    $total += $h * $weights[$criterion->id];
                }

                $qMatrix[$studentA->id][$studentB->id] = $total;
            }
        }

        return $qMatrix;
    }

    private function calculateDifference(float $valueA, float $valueB, string $criterionType): float
    {
        return $criterionType === 'benefit' ? $valueA - $valueB : $valueB - $valueA;
    }

    private function preferenceFunction(float $d, string $type, float $q = 0, float $p = 0): float
    {
        if ($d <= 0) {
            return 0;
        }

        return match ($type) {
            'usual' => 1,
            'u-shape' => ($d > $q) ? 1 : 0,
            'v-shape' => ($d <= $p && $p > 0) ? $d / $p : 1,
            'level' => ($d <= $q) ? 0 : (($d <= $p) ? 0.5 : 1),
            'linear' => ($d <= $q) ? 0 : (($d >= $p) ? 1 : ($d - $q) / ($p - $q)),
            'gaussian' => ($p <= 0) ? 0 : 1 - exp(- ($d * $d) / (2 * $p * $p)),
            default => 1,
        };
    }

    private function calculateFlows(Collection $students, array $preferenceMatrix): Collection
    {
        return $students->map(function ($student) use ($students, $preferenceMatrix) {
            $count = $students->count() - 1;
            $leaving = $entering = 0;

            foreach ($preferenceMatrix[$student->id] as $otherId => $pref) {
                if ($student->id !== $otherId) {
                    $leaving += $pref;
                    $entering += $preferenceMatrix[$otherId][$student->id];
                }
            }

            return [
                'student' => $student,
                'leaving_flow' => $count > 0 ? $leaving / $count : 0,
                'entering_flow' => $count > 0 ? $entering / $count : 0,
                'net_flow' => $count > 0 ? ($leaving - $entering) / $count : 0,
            ];
        });
    }

    private function rankStudents(Collection $flows): array
    {
        return $flows->sortByDesc('net_flow')
            ->values()
            ->map(fn($item, $index) => array_merge($item, ['rank' => $index + 1]))
            ->all();
    }

    public function savePassingStudents(array $groupedResults, int $periodId): void
{
    foreach ($groupedResults as $group) {
        // Ambil rank 1 saja dari tiap grup
        $rank1 = collect($group['results'])->firstWhere('rank', 1);

        if ($rank1 && isset($rank1['net_flow']) && $rank1['net_flow'] > 0) {
            Result::updateOrCreate(
                [
                    'student_id' => $rank1['student']->id,
                    'period_id' => $periodId,
                ],
                [
                    'class_id' => $rank1['student']->class_id,
                    'leaving_flow' => $rank1['leaving_flow'],
                    'entering_flow' => $rank1['entering_flow'],
                    'net_flow' => $rank1['net_flow'],
                    'rank' => $rank1['rank'],
                ]
            );
        }
    }
}
}
