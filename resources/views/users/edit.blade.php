@extends('partials.app')

@section('title', 'Edit Data Pengguna | TRAVISA')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('administration.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('administration.users.index') }}">Data Pengguna</a>
                </div>
                <div class="breadcrumb-item">Edit Data Pengguna</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        {{-- Tampilkan error validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('administration.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                {{-- Nama --}}
                                <div class="form-group col-md-6">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- Password --}}
                                <div class="form-group col-md-6">
                                    <label for="password">Password (Kosongkan jika tidak diubah)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- Role --}}
                                <div class="form-group col-md-6">
                                    <label for="role">Peran</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="administration" {{ old('role', $user->role) == 'administration' ? 'selected' : '' }}>Administration</option>
                                        <option value="homeroom_teacher" {{ old('role', $user->role) == 'homeroom_teacher' ? 'selected' : '' }}>Wali Kelas</option>
                                        <option value="staff_student" {{ old('role', $user->role) == 'staff_student' ? 'selected' : '' }}>Staff Kesiswaan</option>
                                        <option value="headmaster" {{ old('role', $user->role) == 'headmaster' ? 'selected' : '' }}>Kepala Sekolah</option>
                                    </select>
                                    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Kelas --}}
                                <div class="form-group col-md-6">
                                    <label for="class_id">Kelas (khusus wali kelas)</label>

                                    {{-- Jika bukan homeroom_teacher, tetap kirim nilai class_id --}}
                                    @if (old('role', $user->role) !== 'homeroom_teacher')
                                        <input type="hidden" name="class_id" value="{{ old('class_id', $user->class_id) }}">
                                    @endif

                                    <select name="class_id" id="class_id" class="form-control"
                                        @if (old('role', $user->role) !== 'homeroom_teacher') 
                                            style="pointer-events: none; background-color: #e9ecef;" 
                                        @endif>
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($schoolClasses as $class)
                                            <option value="{{ $class->id }}"
                                                {{ old('class_id', $user->class_id) == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <a href="{{ route('administration.users.index') }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
