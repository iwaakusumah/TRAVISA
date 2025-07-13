<?php

namespace App\Service;

use App\Models\Criteria;

class GeneticAlgorithmService
{
    protected $populationSize = 10;
    protected $maxGeneration = 300;
    protected $targetFitness = 1;
    protected $mutationProbability = 0.1;

    public function run()
    {
        $criteria = Criteria::orderBy('id')->get();
        $priorityValues = $criteria->pluck('priority_value')->toArray();
        $numCriteria = count($priorityValues);

        $population = $this->initializePopulation($numCriteria);

        for ($generation = 0; $generation < $this->maxGeneration; $generation++) {
            $fitnessValues = array_map(
                fn($chromosome) => $this->evaluateFitness($chromosome, $priorityValues),
                $population
            );

            $bestFitness = max($fitnessValues);

            if ($bestFitness >= $this->targetFitness) break;

            $selected = $this->tournamentSelection($population, $fitnessValues, 3);
            $offspring = $this->wholeArithmeticCrossover($selected);
            $this->applyNonUniformMutation($offspring);

            $population = $offspring;
        }

        $best = collect($population)
            ->sortByDesc(fn($c) => $this->evaluateFitness($c, $priorityValues))
            ->first();

        return [
            'chromosome' => $best,
            'fitness' => $this->evaluateFitness($best, $priorityValues),
            'generation' => $generation + 1
        ];
    }

    /**
     * Summary of initializePopulation
     * @param mixed $numCriteria
     * @return array
     */
    protected function initializePopulation($numCriteria)
    {
        return collect(range(1, $this->populationSize))->map(function () use ($numCriteria) {
            $weights = [];
            for ($i = 0; $i < $numCriteria; $i++) {
                $weights[] = mt_rand(1, 100) / 100;
            }
            return $this->normalizeChromosome($weights);
        })->toArray();
    }

    /**
     * Summary of evaluateFitness
     * @param array $chromosome
     * @param array $priorityValues
     * @return float
     */
    protected function evaluateFitness(array $chromosome, array $priorityValues)
    {
        $penalty = 0;
        $high = [];
        $medium = [];
        $low = [];

        // Kelompokkan indeks berdasarkan prioritas
        foreach ($priorityValues as $i => $value) {
            if ($value == 5) $high[] = $i;
            elseif ($value == 3) $medium[] = $i;
            elseif ($value == 2) $low[] = $i;
        }

        // Ambil nilai bobot sesuai kelompok
        $highWeights = array_map(fn($i) => $chromosome[$i], $high);
        $mediumWeights = array_map(fn($i) => $chromosome[$i], $medium);
        $lowWeights = array_map(fn($i) => $chromosome[$i], $low);

        // Validasi minimum dan maksimum
        $minHigh = min($highWeights);
        $maxMedium = max($mediumWeights);
        $minMedium = min($mediumWeights);
        $maxLow = max($lowWeights);

        // Rata-rata
        $avgHigh = array_sum($highWeights) / count($highWeights);
        $avgMedium = array_sum($mediumWeights) / count($mediumWeights);
        $avgLow = array_sum($lowWeights) / count($lowWeights);

        // Penalti untuk pelanggaran hierarki prioritas
        if ($minHigh <= $maxMedium) $penalty += 100;
        if ($minMedium <= $maxLow) $penalty += 100;

        if ($avgHigh <= $avgMedium) $penalty += 50;
        if ($avgMedium <= $avgLow) $penalty += 50;

        // Tambahan penalti jika selisih terlalu kecil
        if (($avgHigh - $avgMedium) < 0.02) $penalty += 25;
        if (($avgMedium - $avgLow) < 0.02) $penalty += 25;

        // Bonus jika memenuhi seluruh aturan
        if (
            $minHigh > $maxMedium &&
            $minMedium > $maxLow &&
            $avgHigh > $avgMedium &&
            $avgMedium > $avgLow
        ) {
            $penalty -= 20; // reward
        }

        // Pastikan fitness tetap positif
        $penalty = max(0, $penalty);

        // Fitness = 1 / (1 + penalty)
        return round(1 / (1 + $penalty), 6);
    }


    /**
     * Summary of tournamentSelection
     * @param array $population
     * @param array $fitnessValues
     * @param int $k
     * @return array
     */
    protected function tournamentSelection(array $population, array $fitnessValues, int $k = 3)
    {
        $selected = [];

        for ($i = 0; $i < count($population); $i++) {
            $candidates = [];
            for ($j = 0; $j < $k; $j++) {
                $index = rand(0, count($population) - 1);
                $candidates[] = [
                    'chromosome' => $population[$index],
                    'fitness' => $fitnessValues[$index]
                ];
            }

            usort($candidates, fn($a, $b) => $b['fitness'] <=> $a['fitness']);
            $selected[] = $candidates[0]['chromosome'];
        }

        return $selected;
    }

    /**
     * Summary of wholeArithmeticCrossover
     * @param array $parents
     * @param float $alpha
     * @return array<array<float|int>>
     */
    protected function wholeArithmeticCrossover(array $parents, float $alpha = 0.5)
    {
        $offspring = [];

        for ($i = 0; $i < count($parents); $i += 2) {
            if (!isset($parents[$i + 1])) break;

            $p1 = $parents[$i];
            $p2 = $parents[$i + 1];

            $child1 = [];
            $child2 = [];

            foreach ($p1 as $j => $_) {
                $c1 = $alpha * $p1[$j] + (1 - $alpha) * $p2[$j];
                $c2 = $alpha * $p2[$j] + (1 - $alpha) * $p1[$j];
                $child1[] = $c1;
                $child2[] = $c2;
            }

            $offspring[] = $this->normalizeChromosome($child1);
            $offspring[] = $this->normalizeChromosome($child2);
        }

        return $offspring;
    }

    /**
     * Summary of applyNonUniformMutation
     * @param array $population
     * @return void
     */
    protected function applyNonUniformMutation(array &$population)
    {
        $totalMutations = round(count($population) * $this->mutationProbability);

        for ($m = 0; $m < $totalMutations; $m++) {
            $i = rand(0, count($population) - 1);
            $chrom = $population[$i];

            $index = rand(0, count($chrom) - 1);
            $delta = ((rand(0, 1) ? 1 : -1) * mt_rand(1, 5) / 100); // ±0.01 - 0.05
            $chrom[$index] = max(0, min(1, $chrom[$index] + $delta));

            $population[$i] = $this->normalizeChromosome($chrom);
        }
    }

    /**
     * Summary of normalizeChromosome
     * @param array $chromosome
     * @return array<float|int>
     */
    protected function normalizeChromosome(array $chromosome)
    {
        $sum = array_sum($chromosome);
        if ($sum == 0) {
            return array_fill(0, count($chromosome), 1 / count($chromosome));
        }

        return array_map(fn($val) => $val / $sum, $chromosome);
    }
}
