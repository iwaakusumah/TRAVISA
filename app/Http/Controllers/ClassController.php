<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::all();
        return view('class.index', compact('classes'));
    }

    public function create()
    {
        return view('class.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:classes,name',
                'regex:/^(X|XI|XII)\sTKJ\s[1-9]$/'
            ],
        ]);

        SchoolClass::create($validated);
        return redirect()->route('administration.classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $class)
    {
        return view('class.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:classes,name',
                'regex:/^(X|XI|XII)\sTKJ\s[1-9]$/'
            ],
        ]);

        $class->update($validated);
        return redirect()->route('administration.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }
}
