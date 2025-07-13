@extends('partials.app')

@section('title', 'Nilai Siswa | TRAVISA')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Nilai Siswa</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('homeroom-teacher.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Data Nilai Siswa</div>
      </div>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-end">
              @php
              $user = Auth::user();
              $rolePrefix = $user->role === 'administration' ? 'administration' : 'homeroom-teacher';
              @endphp
              <div>
                <a href="{{ route($rolePrefix . '.scores.create') }}" class="btn btn-icon icon-left btn-primary mr-1"><i class="far fa-plus-square"></i> Tambah Data</a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="table-5">
                  <thead>
                    <tr>
                      <th class="text-center">
                        No.
                      </th>
                      <th class="text-center">Tahun Ajaran</th>
                      <th class="text-center">Nama Siswa</th>
                      <th class="text-center">Jenis Kelamin</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $studentsGrouped = $scores->groupBy('student_id'); @endphp
                    @foreach ($studentsGrouped as $studentScores)
                    @php
                    $student = $studentScores->first()->student;
                    $period = $studentScores->first()->period;
                    @endphp
                    <tr>
                      <td class="text-center">{{ $loop->iteration }}</td>
                      <td class="text-center">{{ $period->name }}</td>
                      <td>{{ $student->name }}</td>
                      <td class="text-center">{{ $student->gender }}</td>

                      {{-- Tampilkan nilai setiap kriteria --}}
                      @foreach ($criteria as $c)
                      @php
                      $score = $studentScores->where('criteria_id', $c->id)->first();
                      @endphp
                      @endforeach

                      <td class="text-center">
                        @php
                        $user = Auth::user();
                        $rolePrefix = $user->role === 'administration' ? 'administration' : 'homeroom-teacher';
                        @endphp

                        <a href="#"
                          class="btn btn-primary btn-action mr-1 btn-read"
                          title="Read"
                          data-url="{{ route($rolePrefix . '.scores.show', $score->student_id) }}">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route($rolePrefix . '.scores.edit', [$student->id, $period->id]) }}"
                          class="btn btn-warning btn-action mr-1"
                          data-toggle="tooltip" title="Edit">
                          <i class="fas fa-pen-to-square"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
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

@section('modal')
<script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
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