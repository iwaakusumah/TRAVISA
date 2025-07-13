@extends('partials.app')

@section('title', 'Edit Nilai Siswa | TRAVISA')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Nilai Siswa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('homeroom-teacher.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('homeroom-teacher.scores.index') }}">Nilai Siswa</a></div>
                <div class="breadcrumb-item">Edit Nilai Siswa</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form method="POST" action="{{ route('homeroom-teacher.scores.update', [$student->id, $period->id]) }}">
                            @csrf
                            @method('PUT')

                            <!-- Info Siswa -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="student_id">Nama Siswa</label>
                                    <select class="form-control" disabled>
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    </select>
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="period_id">Periode</label>
                                    <select class="form-control" disabled>
                                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                                    </select>
                                    <input type="hidden" name="period_id" value="{{ $period->id }}">
                                </div>
                            </div>

                            <!-- Form Nilai -->
                            <div class="form-row">
                                @foreach($criteria as $criterion)
                                @php
                                $isAverage = in_array($criterion->name, ['Rata-Rata Nilai Pengetahuan', 'Rata-Rata Nilai Keterampilan']);
                                $isKeaktifan = $criterion->name === 'Keaktifan Organisasi';
                                $value = old('scores.' . $criterion->id, $existingScores[$criterion->id]->value ?? '');
                                @endphp

                                <div class="form-group col-md-6">
                                    <label for="criteria_{{ $criterion->id }}">{{ $criterion->name }}</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        name="scores[{{ $criterion->id }}]"
                                        id="criteria_{{ $criterion->id }}"
                                        step="{{ $isAverage ? '0.01' : '1' }}"
                                        min="{{ $isKeaktifan ? 1 : 0 }}"
                                        max="{{ $isKeaktifan ? 3 : 100 }}"
                                        value="{{ $value }}"
                                        required
                                        {{ $isAverage ? '' : 'oninput=this.value=this.value.replace(/[^0-9]/g,\'\')' }}>
                                </div>
                                @endforeach
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="card-footer text-right">
                                <a href="{{ route('homeroom-teacher.scores.index') }}" class="btn btn-danger">Batal</a>
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