@extends('partials.app')

@section('title', 'Data Kelas | TRAVISA')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Kelas</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('administration.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Data Kelas</div>
      </div>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-center justify-content-md-end gap-2">
              <div>
                <a href="{{ route('administration.classes.create') }}" class="btn btn-icon icon-left btn-primary mr-1">
                  <i class="far fa-plus-square"></i> Tambah Data
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-3">
                  <thead>
                    <tr>
                      <th class="text-center">
                        No.
                      </th>
                      <th class="text-center">Nama Kelas</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($classes as $index => $class)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="text-center">{{ $class->name }}</td>
                      <td class="text-center">
                        <a href="{{ route('administration.classes.edit', $class->id) }}" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Edit">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada data kelas</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@section('table')
<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
@endsection

@endsection

@section('toast')
@if(session('success'))
<script>
    iziToast.success({
        title: 'Sukses',
        message: "{{ session('success') }}",
        position: 'topRight'
    });
</script>
@endif

@if(session('error'))
<script>
    iziToast.error({
        title: 'Gagal',
        message: "{{ session('error') }}",
        position: 'topRight'
    });
</script>
@endif
@endsection