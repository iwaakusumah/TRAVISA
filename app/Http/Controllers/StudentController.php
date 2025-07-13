<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Menampilkan daftar siswa
    public function index()
    {
        $user = Auth::user();

        if (!$user || (!$user->class_id && $user->role !== 'administration')) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $students = $user->role === 'administration'
            ? Student::all()
            : Student::where('class_id', $user->class_id)->get();

        $class = $user->class_id ? SchoolClass::find($user->class_id) : null;

        if ($user->role !== 'administration' && !$class) {
            abort(404, 'Kelas tidak ditemukan');
        }

        return view('students.index', compact('students', 'class'));
    }

    // Menampilkan form untuk menambahkan siswa
    public function create()
    {
        $user = Auth::user();

        $classes = $user->role === 'administration'
            ? SchoolClass::all()
            : SchoolClass::where('id', $user->class_id)->get();

        $majors = [
            'Teknik Komputer dan Jaringan' => 'TKJ',
            'Teknik Kendaraan Ringan' => 'TKR',
            'Akuntansi' => 'AK',
            'Administrasi Perkantoran' => 'AP',
        ];

        return view('students.create', compact('classes', 'majors'));
    }

    // Menyimpan siswa baru
    public function store(Request $request)
    {
        $user = Auth::user();
        $rolePrefix = $user->role === 'administration' ? 'administration' : 'homeroom-teacher';

        $majorsMap = [
            'TKJ' => 'Teknik Komputer dan Jaringan',
            'TKR' => 'Teknik Kendaraan Ringan',
            'AK'  => 'Akuntansi',
            'AP'  => 'Administrasi Perkantoran',
        ];

        if ($user->role === 'administration') {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|in:F,M',
                'class_id' => 'required|exists:classes,id',
                'major' => 'required|in:' . implode(',', array_keys($majorsMap)),
            ]);

            // Konversi singkatan ke nama lengkap
            $majorFullName = $majorsMap[$validated['major']];

            Student::create([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'class_id' => $validated['class_id'],
                'major' => $majorFullName, // Simpan nama lengkap di DB
            ]);

            return redirect()->route($rolePrefix . '.students.index')->with('success', 'Siswa berhasil ditambahkan.');
        }

        $class = SchoolClass::findOrFail($user->class_id);

        $major = match (true) {
            str_contains(strtoupper($class->name), 'TKJ') => 'Teknik Komputer dan Jaringan',
            str_contains(strtoupper($class->name), 'TKR') => 'Teknik Kendaraan Ringan',
            str_contains(strtoupper($class->name), 'AK')  => 'Akuntansi',
            str_contains(strtoupper($class->name), 'AP')  => 'Administrasi Perkantoran',
            default => null,
        };

        if (!$major) {
            return back()->withErrors(['major' => 'Jurusan tidak dikenali dari nama kelas.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:F,M',
        ]);

        Student::create([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'class_id' => $class->id,
            'major' => $major,
        ]);

        return redirect()->route($rolePrefix . '.students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit(Student $student)
    {
        $user = Auth::user();

        if ($user->role !== 'administration' && $student->class_id !== $user->class_id) {
            abort(403);
        }

        $classes = $user->role === 'administration'
            ? SchoolClass::all()
            : SchoolClass::where('id', $user->class_id)->get();

        $majors = [
            'Teknik Komputer dan Jaringan' => 'TKJ',
            'Teknik Kendaraan Ringan' => 'TKR',
            'Akuntansi' => 'AK',
            'Administrasi Perkantoran' => 'AP',
        ];

        return view('students.edit', compact('student', 'classes', 'majors'));
    }


    // Update data siswa
    public function update(Request $request, Student $student)
    {
        $user = Auth::user();
        $rolePrefix = $user->role === 'administration' ? 'administration' : 'homeroom-teacher';

        // Cek akses homeroom teacher hanya boleh edit siswa dari kelasnya
        if ($user->role !== 'administration' && $student->class_id !== $user->class_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit siswa ini.');
        }

        // Jika admin, izinkan edit nama, gender, major, dan class_id
        if ($user->role === 'administration') {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|in:F,M',
                'major' => 'required|in:TKJ,TKR,AK,AP',
                'class_id' => 'required|exists:classes,id',
            ]);

            // Mapping singkatan jurusan ke nama lengkap (seperti create)
            $majorsMap = [
                'TKJ' => 'Teknik Komputer dan Jaringan',
                'TKR' => 'Teknik Kendaraan Ringan',
                'AK'  => 'Akuntansi',
                'AP'  => 'Administrasi Perkantoran',
            ];

            $majorFull = $majorsMap[$validated['major']] ?? null;

            if (!$majorFull) {
                return back()->withErrors(['major' => 'Jurusan tidak valid.']);
            }

            $student->update([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'major' => $majorFull,
                'class_id' => $validated['class_id'],
            ]);
        } else {
            // Untuk homeroom teacher, ambil data kelas dari user
            $class = SchoolClass::findOrFail($user->class_id);

            $major = match (true) {
                str_contains(strtoupper($class->name), 'TKJ') => 'Teknik Komputer dan Jaringan',
                str_contains(strtoupper($class->name), 'TKR') => 'Teknik Kendaraan Ringan',
                str_contains(strtoupper($class->name), 'AK')  => 'Akuntansi',
                str_contains(strtoupper($class->name), 'AP')  => 'Administrasi Perkantoran',
                default => null,
            };

            if (!$major) {
                return back()->withErrors(['major' => 'Jurusan tidak dikenali dari nama kelas.']);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'gender' => 'required|in:F,M',
            ]);

            $student->update([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'major' => $major,
                'class_id' => $class->id, // pastikan class_id tidak berubah
            ]);
        }

        return redirect()->route($rolePrefix . '.students.index')->with('success', 'Siswa berhasil diperbarui.');
    }



    // Hapus data siswa
    public function destroy(Student $student)
    {
        $user = Auth::user();
        $rolePrefix = $user->role === 'administration' ? 'administration' : 'homeroom-teacher';

        if ($user->role !== 'administration' && $student->class_id !== $user->class_id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus siswa ini.');
        }

        $student->delete();

        return redirect()->route($rolePrefix . '.students.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
