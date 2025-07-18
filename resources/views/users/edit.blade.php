@extends('partials.app')

@section('title', 'Edit Data Pengguna | TRAVISA')

@section('content')
@php
// Tidak perlu memeriksa role user login, cukup menggunakan $user yang diteruskan dari controller
@endphp
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Pengguna</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('administration.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('administration.users.index') }}">Data Pengguna</a></div>
                <div class="breadcrumb-item">Edit Data Pengguna</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('administration.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                {{-- Nama --}}
                                <div class="form-group col-md-6">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- Password --}}
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password (Kosongkan jika tidak diubah)">
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password">
                                    @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- Kelas --}}
                                <div class="form-group col-md-6">
                                    <label for="school_class_id">Kelas</label>
                                    <select class="form-control" id="school_class_id" name="school_class_id" 
                                        @if($user->role !== 'homeroom_teacher') disabled @endif 
                                        required>
                                        <option value="" disabled selected>Pilih Kelas</option>
                                        @foreach($schoolClasses as $class)
                                            <option value="{{ $class->id }}" 
                                                {{ old('school_class_id', $user->school_class_id) == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('school_class_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

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
