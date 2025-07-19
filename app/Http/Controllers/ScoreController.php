<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Period;
use App\Models\SchoolClass;
use App\Models\Score;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ScoreController extends Controller
{
    // Menampilkan daftar nilai
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->class_id || $user->role === 'administration') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $students = Student::where('class_id', $user->class_id)->pluck('id');

        $scores = Score::with(['student', 'criteria', 'period'])
            ->whereIn('student_id', $students)
            ->get();

        $class = SchoolClass::find($user->class_id);
        $criteria = Criteria::all();

        return view('scores.index', compact('scores', 'class', 'criteria'));
    }

    // Menampilkan detail nilai siswa (via JSON)
    public function show($student_id)
    {
        $user = Auth::user();

        if ($user->role === 'administration') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $scores = Score::with(['criteria', 'period', 'student'])
            ->where('student_id', $student_id)
            ->whereHas('student', function ($q) use ($user) {
                $q->where('class_id', $user->class_id);
            })
            ->get();

        if ($scores->isEmpty()) {
            return response()->json(['error' => 'Data tidak ditemukan atau akses ditolak'], 404);
        }

        $student = $scores->first()->student;
        $period = $scores->first()->period;

        return response()->json([
            'period' => $period->name,
            'student' => $student->name,
            'scores' => $scores->map(function ($s) {
                return [
                    'criteria' => $s->criteria->name,
                    'value' => $s->value,
                ];
            }),
        ]);
    }

    // Menampilkan form input nilai baru
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'administration') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $students = Student::where('class_id', $user->class_id)->get();
        $periods = Period::all();
        $criterias = Criteria::all();

        return view('scores.create', compact('students', 'periods', 'criterias'));
    }

    // Menyimpan nilai siswa baru
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'administration') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $teacherClassId = $user->class_id;

        $validated = $request->validate([
            'student_id' => [
                'required',
                Rule::exists('students', 'id')->where(function ($query) use ($teacherClassId) {
                    $query->where('class_id', $teacherClassId);
                }),
            ],
            'period_id' => 'required|exists:periods,id',
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:0|max:100',
        ]);

        // Validasi apakah student_id sudah memiliki nilai pada period_id yang sama
        $existingScore = Score::where('student_id', $validated['student_id'])
            ->where('period_id', $validated['period_id'])
            ->exists();  // Menggunakan exists() untuk memeriksa apakah data sudah ada

        if ($existingScore) {
            return back()->withErrors(['period_id' => 'Siswa ini sudah memiliki nilai pada periode yang sama.']);
        }

        foreach ($validated['scores'] as $criteriaId => $value) {
            Score::create([
                'student_id' => $validated['student_id'],
                'criteria_id' => $criteriaId,
                'period_id' => $validated['period_id'],
                'value' => $value,
            ]);
        }

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    // Menampilkan form edit nilai
    public function edit(Student $student, Period $period)
    {
        $user = Auth::user();

        if ($user->role === 'administration' || $student->class_id !== $user->class_id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $criteria = Criteria::all();
        $existingScores = Score::where('student_id', $student->id)
            ->where('period_id', $period->id)
            ->get()
            ->keyBy('criteria_id');

        return view('scores.edit', compact('student', 'period', 'criteria', 'existingScores'));
    }

    // Menyimpan perubahan nilai
    public function update(Request $request, Score $score)
    {
        $user = Auth::user();

        if ($user->role === 'administration') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validated = $request->validate([
            'student_id' => [
                'required',
                Rule::exists('students', 'id')->where(function ($query) use ($user) {
                    $query->where('class_id', $user->class_id);
                }),
            ],
            'period_id' => 'required|exists:periods,id',
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:0|max:100',
        ]);

        // Validasi apakah student_id sudah memiliki nilai pada period_id yang sama (untuk update)
        $existingScore = Score::where('student_id', $validated['student_id'])
            ->where('period_id', $validated['period_id'])
            ->where('id', '!=', $score->id) // Mengecualikan skor yang sedang diupdate
            ->exists();  // Menggunakan exists() untuk cek data yang sudah ada

        if ($existingScore) {
            return redirect()->route('homeroom-teacher.scores.index')
                ->withErrors(['period_id' => 'Siswa ini sudah memiliki nilai pada periode yang sama.']);
        }

        foreach ($validated['scores'] as $criteriaId => $value) {
            Score::updateOrCreate(
                [
                    'student_id' => $validated['student_id'],
                    'criteria_id' => $criteriaId,
                    'period_id' => $validated['period_id'],
                ],
                ['value' => $value]
            );
        }

        return redirect()->route('homeroom-teacher.scores.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    // Menghapus nilai
    public function destroy(Score $score)
    {
        $user = Auth::user();

        if ($user->role === 'administration') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Pastikan hanya wali kelas dari siswa terkait yang bisa hapus
        if ($score->student->class_id !== $user->class_id) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $score->delete();

        return back()->with('success', 'Nilai berhasil dihapus.');
    }
}
