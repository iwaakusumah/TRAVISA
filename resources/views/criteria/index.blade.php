@extends('partials.app')

@section('title', 'Kriteria Beasiswa | TRAVISA')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Kriteria Beasiswa</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('staff-student.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Data Kriteria Beasiswa</div>
      </div>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-center justify-content-md-end gap-2">
              <div>
                <a href="{{ route('staff-student.criterias.create') }}" class="btn btn-icon icon-left btn-primary mr-1">
                  <i class="far fa-plus-square"></i> Tambah Data
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-6">
                  <thead>
                    <tr>
                      <th class="text-center">
                        No.
                      </th>
                      <th class="text-center">Nama Kriteria</th>
                      <th class="text-center">Tipe Kriteria</th>
                      <th class="text-center">Prioritas</th>
                      <th class="text-center">Batas Toleransi</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($criterias as $index => $criteria)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td>{{ $criteria->name }}</td>
                      <td class="text-center">{{ $criteria->type }}</td>
                      <td class="text-center">
                        @if($criteria->priority_value == 5)
                        Tinggi
                        @elseif($criteria->priority_value == 3)
                        Sedang
                        @elseif($criteria->priority_value == 2)
                        Rendah
                        @else
                        Tidak diketahui
                        @endif
                      </td>
                      <td class="text-center">{{ $criteria->p_threshold }}</td>
                      <td class="text-center">
                        <a href="{{ route('staff-student.criterias.edit', $criteria->id) }}" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Edit">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form id="delete-form-{{ $criteria->id }}" action="{{ route('staff-student.criterias.destroy', $criteria->id) }}" method="POST" style="display:inline-block;">
                          @csrf
                          @method('DELETE')
                        </form>
                        <a href="#" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"
                          data-confirm="Apakah kamu yakin?|Tindakan ini tidak dapat dibatalkan. Apakah kamu ingin lanjut?"
                          data-confirm-yes="document.getElementById('delete-form-{{ $criteria->id }}').submit();">
                          <i class="fas fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada data kriteria</td>
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