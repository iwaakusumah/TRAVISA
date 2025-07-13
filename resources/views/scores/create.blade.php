@extends('partials.app')

@section('title', 'Tambah Nilai Siswa | TRAVISA')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Nilai Siswa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('homeroom-teacher.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('homeroom-teacher.scores.index') }}">Nilai Siswa</a></div>
                <div class="breadcrumb-item">Tambah Nilai Siswa</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('homeroom-teacher.scores.store') }}" method="POST">
                            @csrf
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="period_id">Tahun Ajaran</label>
                                    <select id="period_id" name="period_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Tahun --</option>
                                        @foreach ($periods as $period )
                                        <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>{{ $period->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('period_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="student_id">Nama Siswa</label>
                                    <select id="student_id" name="student_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Siswa --</option>
                                        @foreach ($students as $student )
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('student_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                @foreach ($criterias as $criteria)
                                <div class="form-group col-md-6">
                                    <label for="criteria_{{ $criteria->id }}">{{ $criteria->name }}</label>
                                    @php
                                    $isAverage = in_array($criteria->name, ['Rata-Rata Nilai Pengetahuan', 'Rata-Rata Nilai Keterampilan']);
                                    $isKeaktifan = $criteria->name === 'Keaktifan Organisasi';
                                    @endphp

                                    <input
                                        type="number"
                                        name="scores[{{ $criteria->id }}]"
                                        id="criteria_{{ $criteria->id }}"
                                        class="form-control"
                                        step="{{ $isAverage ? '0.01' : '1' }}"
                                        max="{{ $isKeaktifan ? '3' : ($isAverage ? '100.00' : null) }}"
                                        min="{{ $isKeaktifan ? '1' : '0' }}"
                                        value="{{ old('scores.' . $criteria->id) }}"
                                        required
                                        {{ $isAverage ? '' : 'oninput=this.value=this.value.replace(/[^0-9]/g,\'\')' }}>

                                    @error('scores.' . $criteria->id)
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                @endforeach
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