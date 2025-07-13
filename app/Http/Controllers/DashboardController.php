<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Score;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function homeroomTeacherDashboard()
    {
        $user = Auth::user();

        if (!$user || !$user->class_id) {
            abort(403, 'User tidak memiliki class_id');
        }

        $totalStudents = Student::where('class_id', $user->class_id)->count();

        $averageScoreKnowledge = Student::with('scores.criteria')
            ->where('class_id', $user->class_id)
            ->get()
            ->map(function ($student) {
                $filteredScores = $student->scores->filter(function ($score) {
                    return $score->criteria && $score->criteria->name === 'Rata-Rata Nilai Pengetahuan';
                });
                return $filteredScores->avg('value');
            })
            ->filter()
            ->avg();

        $averageScoreSkill = Student::with('scores.criteria')
            ->where('class_id', $user->class_id)
            ->get()
            ->map(function ($student) {
                $filteredScores = $student->scores->filter(function ($score) {
                    return $score->criteria && $score->criteria->name === 'Rata-Rata Nilai Keterampilan';
                });
                return $filteredScores->avg('value');
            })
            ->filter()
            ->avg();

        return view('dashboard.homeroom-teacher', compact(
            'totalStudents',
            'averageScoreKnowledge',
            'averageScoreSkill'
        ));
    }

    public function staffStudentDashboard()
    {
        $totalStudent = Student::count();
        $totalCriteria = Criteria::count();
        $criteriaWithWeights = Criteria::has('weights')->count();
        $criteriaCompletion = $totalCriteria > 0 ? round(($criteriaWithWeights / $totalCriteria) * 100, 2) : 0;
        $averageScore = Student::with('scores.criteria')->get()->map(function ($student) {
            // Ambil hanya skor dengan nama kriteria yang sesuai
            $filteredScores = $student->scores->filter(function ($score) {
                return in_array($score->criteria->name, [
                    'Rata-Rata Nilai Pengetahuan',
                    'Rata-Rata Nilai Keterampilan'
                ]);
            });
            return $filteredScores->avg('value');
        })->filter()->avg();
        return view('dashboard.staff-student', compact('totalStudent', 'criteriaCompletion', 'averageScore'));
    }

    public function headmasterDashboard()
    {
        $totalStudent = Student::count();

        $averageScoreKnowledge = Student::with('scores.criteria')->get()->map(function ($student) {
            // Ambil hanya skor dengan nama kriteria yang sesuai
            $filteredScores = $student->scores->filter(function ($score) {
                return in_array($score->criteria->name, [
                    'Rata-Rata Nilai Pengetahuan'
                ]);
            });
            return $filteredScores->avg('value');
        })->filter()->avg();

        $averageScoreSkill = Student::with('scores.criteria')->get()->map(function ($student) {
            // Ambil hanya skor dengan nama kriteria yang sesuai
            $filteredScores = $student->scores->filter(function ($score) {
                return in_array($score->criteria->name, [
                    'Rata-Rata Nilai Keterampilan'
                ]);
            });
            return $filteredScores->avg('value');
        })->filter()->avg();
        return view('dashboard.headmaster', compact('totalStudent', 'averageScoreKnowledge', 'averageScoreSkill'));
    }

    public function administrationDashboard()
    {

        $totalUser = User::count();
        $totalStudent = Student::count();

        $averageScoreKnowledge = Student::with('scores.criteria')->get()->map(function ($student) {
            // Ambil hanya skor dengan nama kriteria yang sesuai
            $filteredScores = $student->scores->filter(function ($score) {
                return in_array($score->criteria->name, [
                    'Rata-Rata Nilai Pengetahuan'
                ]);
            });
            return $filteredScores->avg('value');
        })->filter()->avg();

        $averageScoreSkill = Student::with('scores.criteria')->get()->map(function ($student) {
            // Ambil hanya skor dengan nama kriteria yang sesuai
            $filteredScores = $student->scores->filter(function ($score) {
                return in_array($score->criteria->name, [
                    'Rata-Rata Nilai Keterampilan'
                ]);
            });
            return $filteredScores->avg('value');
        })->filter()->avg();
        return view('dashboard.administration', compact('totalUser', 'totalStudent', 'averageScoreKnowledge', 'averageScoreSkill'));
    }
}
