@extends('partials.app')

@section('title', 'Edit Data Kriteria | TRAVISA')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Kriteria</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('staff-student.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('staff-student.criterias.index') }}">Data Kriteria</a></div>
                <div class="breadcrumb-item">Edit Data Siswa</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('staff-student.criterias.update', $criteria->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nama Kriteria</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Kriteria"
                                        value="{{ old('name', $criteria->name ?? '') }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="type">Tipe Kriteria</label>
                                    <select id="type" name="type" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Tipe Kriteria --</option>
                                        <option value="benefit" {{ old('type', $criteria->type ?? '') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                        <option value="cost" {{ old('type', $criteria->type ?? '') == 'cost' ? 'selected' : '' }}>Cost</option>
                                    </select>
                                    @error('type') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="p_threshold">Batas Toleransi</label>
                                    <input type="number" step="any" class="form-control" id="p_threshold" name="p_threshold" placeholder="Masukkan p_threshold"
                                        value="{{ old('p_threshold', $criteria->p_threshold ?? '') }}" required>
                                    @error('p_threshold') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="priority_value">Prioritas</label>
                                    <select id="priority_value" name="priority_value" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Prioritas --</option>
                                        <option value="5" {{ old('priority_value', $criteria->priority_value ?? '') == '5' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="3" {{ old('priority_value', $criteria->priority_value ?? '') == '3' ? 'selected' : '' }}>Sedang</option>
                                        <option value="2" {{ old('priority_value', $criteria->priority_value ?? '') == '2' ? 'selected' : '' }}>Rendah</option>
                                    </select>
                                    @error('priority_value') <small class="text-danger">{{ $message }}</small> @enderror
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