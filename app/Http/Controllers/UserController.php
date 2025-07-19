<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua user beserta relasi kelas
        $users = User::with('schoolClass')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolClasses = SchoolClass::all();
        return view('users.create', compact('schoolClasses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Aturan validasi dasar
        $rules = [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administration,homeroom_teacher,staff_student,headmaster',
        ];

        // Jika role homeroom_teacher wajib ada class_id dari tabel school_classes
        if ($request->input('role') === 'homeroom_teacher') {
            $rules['class_id'] = 'required|exists:school_classes,id';
        }

        $validated = $request->validate($rules);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'class_id' => $validated['class_id'] ?? null,
            'role' => $validated['role'],
        ]);

        return redirect()->route('administration.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $schoolClasses = SchoolClass::all();

        return view('users.edit', compact('user', 'schoolClasses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        // Aturan validasi
        $rules = [
            'name' => 'required|string|max:255|unique:users,name,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:administration,homeroom_teacher,staff_student,headmaster',
        ];

        if ($request->input('role') === 'homeroom_teacher') {
            $rules['class_id'] = 'required|exists:school_classes,id';
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'class_id' => $validated['class_id'] ?? null,
        ];

        // Jika password diisi, hash dan simpan
        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }

        $user->update($data);

        return redirect()->route('administration.users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('administration.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
