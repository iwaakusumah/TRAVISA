@extends('partials.app')

@section('title', 'Data Siswa | TRAVISA')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Siswa</h1>
      <div class="section-header-breadcrumb">
        @php
        $user = Auth::user();
        $rolePrefix = $user->role === 'administration' ? 'administration' : 'homeroom-teacher';
        @endphp
        <div class="breadcrumb-item active">
          <a href="{{ route($rolePrefix . '.dashboard') }}">Dashboard</a>
        </div>
        <div class="breadcrumb-item">Data Siswa</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-center justify-content-md-end gap-2">
              <div>

                <a href="{{ route($rolePrefix . '.students.create') }}" class="btn btn-icon icon-left btn-primary mr-1">
                  <i class="far fa-plus-square"></i> Tambah Data
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-6">
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th class="text-center">Nama Siswa</th>
                      <th class="text-center">Jenis Kelamin</th>
                      <th class="text-center">Jurusan</th>
                      <th class="text-center">Kelas</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($students as $index => $student)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td>{{ $student->name }}</td>
                      <td class="text-center">
                        {{ $student->gender }}
                      </td>
                      <td>{{ $student->major }}</td>
                      <td class="text-center">{{ $student->schoolClass->name ?? '-' }}</td>
                      <td class="text-center">
                        <a href="{{ route($rolePrefix . '.students.edit', $student->id) }}" class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Edit">
                          <i class="fas fa-pen-to-square"></i>
                        </a>
                        <form id="delete-form-{{ $student->id }}" action="{{ route($rolePrefix . '.students.destroy', $student->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger btn-action" onclick="return confirm('Apakah kamu yakin ingin menghapus siswa ini?')">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada data siswa</td>
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