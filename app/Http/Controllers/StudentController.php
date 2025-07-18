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

        if ($user->role === 'administration') {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:students,name',
                'gender' => 'required|in:F,M',
                'class_id' => 'required|exists:classes,id',
            ]);

            $class = SchoolClass::findOrFail($validated['class_id']);
            $className = strtoupper($class->name); // Contoh: "X TKJ 3"

            // Level: ambil X, XI, atau XII dari awal nama kelas
            $level = null;
            if (str_starts_with($className, 'XII')) {
                $level = 'XII';
            } elseif (str_starts_with($className, 'XI')) {
                $level = 'XI';
            } elseif (str_starts_with($className, 'X')) {
                $level = 'X';
            }

            // Jurusan dari nama kelas
            $major = match (true) {
                str_contains($className, 'TKJ') => 'Teknik Komputer dan Jaringan',
                str_contains($className, 'TKR') => 'Teknik Kendaraan Ringan',
                str_contains($className, 'AK')  => 'Akuntansi',
                str_contains($className, 'AP')  => 'Administrasi Perkantoran',
                default => null,
            };

            if (!$major || !$level) {
                return back()->withErrors(['class_id' => 'Tidak dapat menentukan jurusan atau level dari nama kelas.']);
            }

            Student::create([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'class_id' => $class->id,
                'major' => $major,
                'level' => $level,
            ]);

            return redirect()->route($rolePrefix . '.students.index')->with('success', 'Siswa berhasil ditambahkan.');
        }

        // Bagi wali kelas
        $class = SchoolClass::findOrFail($user->class_id);
        $className = strtoupper($class->name);

        $major = match (true) {
            str_contains($className, 'TKJ') => 'Teknik Komputer dan Jaringan',
            str_contains($className, 'TKR') => 'Teknik Kendaraan Ringan',
            str_contains($className, 'AK')  => 'Akuntansi',
            str_contains($className, 'AP')  => 'Administrasi Perkantoran',
            default => null,
        };

        $level = null;
        if (str_starts_with($className, 'XII')) {
            $level = 'XII';
        } elseif (str_starts_with($className, 'XI')) {
            $level = 'XI';
        } elseif (str_starts_with($className, 'X')) {
            $level = 'X';
        }

        if (!$major || !$level) {
            return back()->withErrors(['class_id' => 'Jurusan atau level tidak dikenali dari nama kelas.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:students,name',
            'gender' => 'required|in:F,M',
        ]);

        Student::create([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'class_id' => $class->id,
            'major' => $major,
            'level' => $level,
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

        if ($user->role !== 'administration' && $student->class_id !== $user->class_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit siswa ini.');
        }

        if ($user->role === 'administration') {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:students,name,' . $student->id,
                'gender' => 'required|in:F,M',
                'class_id' => 'required|exists:classes,id',
            ]);

            $class = SchoolClass::findOrFail($validated['class_id']);
            $className = strtoupper($class->name);

            $level = null;
            if (str_starts_with($className, 'XII')) {
                $level = 'XII';
            } elseif (str_starts_with($className, 'XI')) {
                $level = 'XI';
            } elseif (str_starts_with($className, 'X')) {
                $level = 'X';
            }

            $major = match (true) {
                str_contains($className, 'TKJ') => 'Teknik Komputer dan Jaringan',
                str_contains($className, 'TKR') => 'Teknik Kendaraan Ringan',
                str_contains($className, 'AK')  => 'Akuntansi',
                str_contains($className, 'AP')  => 'Administrasi Perkantoran',
                default => null,
            };

            if (!$major || !$level) {
                return back()->withErrors(['class_id' => 'Tidak dapat menentukan jurusan atau level dari nama kelas.']);
            }

            $student->update([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'class_id' => $validated['class_id'],
                'major' => $major,
                'level' => $level,
            ]);
        } else {
            $class = SchoolClass::findOrFail($user->class_id);
            $className = strtoupper($class->name);

            $major = match (true) {
                str_contains($className, 'TKJ') => 'Teknik Komputer dan Jaringan',
                str_contains($className, 'TKR') => 'Teknik Kendaraan Ringan',
                str_contains($className, 'AK')  => 'Akuntansi',
                str_contains($className, 'AP')  => 'Administrasi Perkantoran',
                default => null,
            };

            $level = null;
            if (str_starts_with($className, 'XII')) {
                $level = 'XII';
            } elseif (str_starts_with($className, 'XI')) {
                $level = 'XI';
            } elseif (str_starts_with($className, 'X')) {
                $level = 'X';
            }

            if (!$major || !$level) {
                return back()->withErrors(['class_id' => 'Jurusan atau level tidak dikenali dari nama kelas.']);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:students,name,' . $student->id,
                'gender' => 'required|in:F,M',
            ]);

            $student->update([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'class_id' => $class->id,
                'major' => $major,
                'level' => $level,
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
