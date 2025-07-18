@extends('partials.app')

@section('title', 'Tambah Data Pengguna | TRAVISA')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('administration.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('administration.users.index') }}">Data Pengguna</a>
                </div>
                <div class="breadcrumb-item">Tambah Data Pengguna</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('administration.users.store') }}" method="POST">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="{{ old('name') }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                                    @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="role">Role</label>
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Role --</option>
                                        <option value="administration" {{ old('role') == 'administration' ? 'selected' : '' }}>Administration</option>
                                        <option value="homeroom_teacher" {{ old('role') == 'homeroom_teacher' ? 'selected' : '' }}>Homeroom Teacher</option>
                                        <option value="staff_student" {{ old('role') == 'staff_student' ? 'selected' : '' }}>Staff Student</option>
                                        <option value="headmaster" {{ old('role') == 'headmaster' ? 'selected' : '' }}>Headmaster</option>
                                    </select>
                                    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="school_class_id">Kelas</label>
                                    <select id="school_class_id" name="school_class_id" class="form-control" {{ old('role') != 'homeroom_teacher' ? 'disabled' : '' }}>
                                        <option value="" disabled selected>-- Pilih Kelas --</option>
                                        @foreach($schoolClasses as $class)
                                        <option value="{{ $class->id }}" {{ old('school_class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('school_class_id') <small class="text-danger">{{ $message }}</small> @enderror
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var roleSelect = document.getElementById('role');
        var schoolClassSelect = document.getElementById('school_class_id');

        // Function to toggle school class field based on role
        function toggleSchoolClassField() {
            if (roleSelect.value === 'homeroom_teacher') {
                schoolClassSelect.disabled = false; // Enable class selection
            } else {
                schoolClassSelect.disabled = true; // Disable class selection
                schoolClassSelect.value = ''; // Reset value when disabled
            }
        }

        // Call toggle function on page load to set initial state
        toggleSchoolClassField();

        // Add event listener to handle change in role selection
        roleSelect.addEventListener('change', function() {
            toggleSchoolClassField();
        });
    });
</script>
@endpush