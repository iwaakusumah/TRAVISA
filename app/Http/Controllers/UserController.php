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
        // Menampilkan semua user beserta kelasnya
        $users = User::with('schoolClass')->get(); // Mengambil relasi schoolClass
        // Menambahkan jabatan sesuai dengan role pengguna
        foreach ($users as $user) {
            switch ($user->role) {
                case 'homeroom_teacher':
                    $user->role = 'Wali Kelas';
                    break;
                case 'administration':
                    $user->role = 'Staff Tata Usaha';
                    break;
                case 'headmaster':
                    $user->role = 'Kepala Sekolah';
                    break;
                case 'staff_student':
                    $user->role = 'Wakil Kesiswaan';
                    break;
                default:
                    $user->role = 'Jabatan Tidak Diketahui';
            }
        }
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolClasses = SchoolClass::all(); // Ambil semua kelas dari database
        return view('users.create', compact('schoolClasses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $rules = [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administration,homeroom_teacher,staff_student,headmaster',
        ];

        // Jika role adalah homeroom_teacher, maka school_class_id wajib ada
        if ($request->role == 'homeroom_teacher') {
            $rules['school_class_id'] = 'required|exists:school_classes,id';
        }

        // Validasi input dengan aturan yang sudah ditentukan
        $validated = $request->validate($rules);

        // Menyimpan data user baru
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'school_class_id' => $validated['school_class_id'] ?? null,  // Menyimpan ID kelas jika ada
            'role' => $validated['role'],  // Menyimpan role
        ]);

        return redirect()->route('administration.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Ambil semua data kelas
        $schoolClasses = SchoolClass::all();

        // Tampilkan form edit untuk user yang dipilih
        return view('users.edit', compact('user', 'schoolClasses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        // Update data user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
            'school_class_id' => $validated['school_class_id'],
        ]);

        return redirect()->route('administration.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Menghapus data user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
