@extends('partials.app')

@section('title', 'Tambah Data Siswa | TRAVISA')

@section('content')
@php
$user = Auth::user();
$rolePrefix = $user->role === 'administration' ? 'administration' : 'homeroom-teacher';
@endphp

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Siswa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route($rolePrefix . '.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route($rolePrefix . '.students.index') }}">Data Siswa</a>
                </div>
                <div class="breadcrumb-item">Tambah Data Siswa</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route($rolePrefix . '.students.store') }}" method="POST">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="{{ old('name') }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Perempuan</option>
                                        <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Laki-laki</option>
                                    </select>
                                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            @if($user->role === 'administration')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="class_id">Kelas</label>
                                    <select name="class_id" id="class_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Kelas --</option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="major">Jurusan</label>
                                    <select name="major" id="major" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Jurusan --</option>
                                        @foreach ($majors as $fullName => $abbr)
                                        <option value="{{ $abbr }}" {{ old('major') == $abbr ? 'selected' : '' }}>{{ $fullName }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            @endif

                            <div class="card-footer text-right">
                                <a href="{{ route($rolePrefix . '.students.index') }}" class="btn btn-danger">Batal</a>
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