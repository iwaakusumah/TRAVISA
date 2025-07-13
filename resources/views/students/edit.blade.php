@extends('partials.app')

@section('title', 'Edit Data Siswa | TRAVISA')

@section('content')
@php
$user = Auth::user();
$rolePrefix = $user->role === 'administration' ? 'administration' : 'homeroom-teacher';
@endphp
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Siswa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route($rolePrefix . '.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route($rolePrefix . '.students.index') }}">Data Siswa</a></div>
                <div class="breadcrumb-item">Edit Data Siswa</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route($rolePrefix . '.students.update', $student->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                {{-- Nama --}}
                                <div class="form-group col-md-6">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="{{ old('name', $student->name) }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div class="form-group col-md-6">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="" disabled {{ old('gender', $student->gender) ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                        <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>Perempuan</option>
                                        <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>Laki-laki</option>
                                    </select>
                                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            @php
                            $user = Auth::user();
                            @endphp

                            @if ($user->role === 'administration')
                            <div class="form-row">
                                {{-- Kelas --}}
                                <div class="form-group col-md-6">
                                    <label for="class_id">Kelas</label>
                                    <select id="class_id" name="class_id" class="form-control" required>
                                        <option value="" disabled {{ old('class_id', $student->class_id) ? '' : 'selected' }}>Pilih Kelas</option>
                                        @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Jurusan --}}
                                <div class="form-group col-md-6">
                                    <label for="major">Jurusan</label>
                                    <select id="major" name="major" class="form-control" required>
                                        <option value="" disabled {{ old('major', $student->major) ? '' : 'selected' }}>Pilih Jurusan</option>
                                        <option value="TKJ" {{ old('major', $student->major) == 'TKJ' ? 'selected' : '' }}>Teknik Komputer dan Jaringan</option>
                                        <option value="TKR" {{ old('major', $student->major) == 'TKR' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                                        <option value="AK" {{ old('major', $student->major) == 'AK' ? 'selected' : '' }}>Akuntansi</option>
                                        <option value="AP" {{ old('major', $student->major) == 'AP' ? 'selected' : '' }}>Administrasi Perkantoran</option>
                                    </select>
                                </div>
                            </div>
                            @endif

                            <div class="card-footer text-right">
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
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