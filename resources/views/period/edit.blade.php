@extends('partials.app')

@section('title', 'Edit Data Periode | TRAVISA')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Data Periode</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('administration.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('administration.periods.index') }}">Data Periode</a></div>
                <div class="breadcrumb-item">Edit Data Periode</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('administration.periods.update', $period->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Tahun Periode</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: 2025/2026" pattern="^\d{4}/\d{4}$" title="Gunakan format tahun seperti 2025/2026" value="{{ old('name', $period->name ?? '') }}" required>
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
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