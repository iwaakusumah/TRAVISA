@extends('partials.app')

@section('title', 'Tambah Data Kelas | TRAVISA')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Kelas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('administration.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="{{ route('administration.classes.index') }}">Data Kelas</a></div>
                <div class="breadcrumb-item">Tambah Data Kelas</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="card col-12">
                    <div class="card-body">
                        <form action="{{ route('administration.classes.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Nama Kelas</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nama Kelas" value="{{ old('name') }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
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