<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    // Menampilkan daftar periode
    public function index()
    {
        $periods = Period::all();
        return view('period.index', compact('periods'));
    }

    // Menampilkan form untuk menambahkan periode
    public function create()
    {
        return view('period.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^\d{4}\/\d{4}$/',
                'unique:periods,name',
            ],
        ]);

        Period::create($validated);
        return redirect()->route('administration.periods.index')->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit(Period $period)
    {
        return view('period.edit', compact('period'));
    }

    public function update(Request $request, Period $period)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^\d{4}\/\d{4}$/',
                'unique:periods,name',
                function ($attribute, $value, $fail) {
                    // Tambahan: pastikan tahun kedua = tahun pertama + 1
                    [$year1, $year2] = explode('/', $value);
                    if ((int)$year2 !== (int)$year1 + 1) {
                        $fail('Tahun kedua harus satu tahun setelah tahun pertama.');
                    }
                }
            ],
        ]);

        $period->update($validated);
        return redirect()->route('administration.periods.index')->with('success', 'Periode berhasil diperbarui.');
    }
}
