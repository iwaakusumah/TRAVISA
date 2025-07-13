<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    // Menampilkan daftar kriteria
    public function index()
    {
        $criterias = Criteria::all();
        return view('criteria.index', compact('criterias'));
    }

    // Menampilkan form untuk menambahkan kriteria baru
    public function create()
    {
        return view('criteria.create');
    }

    // Menyimpan kriteria baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:benefit,cost',
            'p_threshold' => 'required|numeric',
            'priority_value' => 'required|in:5,3,2',
        ]);

        Criteria::create($validated);
        return redirect()->route('staff-student.criterias.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit kriteria
    public function edit(Criteria $criteria)
    {
        return view('criteria.edit', compact('criteria'));
    }

    // Memperbarui data kriteria
    public function update(Request $request, Criteria $criteria)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:benefit,cost',
            'p_threshold' => 'required|numeric',
            'priority_value' => 'required|in:5,3,2',
        ]);

        $criteria->update($validated);
        return redirect()->route('staff-student.criterias.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    // Menghapus data kriteria
    public function destroy(Criteria $criteria)
    {
       $criteria->delete();
        return redirect()->route('staff-student.criterias.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
