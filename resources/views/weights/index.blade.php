@extends('partials.app')

@section('title', 'Data Kriteria Beasiswa | TRAVISA')

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
            <div class="card-header d-flex justify-content-center justify-content-md-end gap-3">
              <div>
                <form id="generate-form" action="{{ route('staff-student.weights.store') }}" method="POST" class="d-inline me-5">
                  @csrf
                  <input type="hidden" name="force" value="false">
                  <button type="submit" class="btn btn-icon icon-left btn-danger" onclick="return confirmGenerate()">
                    <i class="fas fa-sync"></i> Generate Bobot
                  </button>
                </form>
                <a href="{{ route('staff-student.weights.editAll') }}" class="btn btn-warning">
                  <i class="fas fa-edit"></i>
                </a>
              </div>
            </div>
            <div class="card-body">
              @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              @if(session('bobot_terbaik'))
              <div class="alert alert-success">
                <strong>Fitness:</strong> {{ session('bobot_terbaik.fitness') }} <br>
                <strong>Generation Ke-:</strong> {{ session('bobot_terbaik.generation') }} <br>
              </div>
              @endif

              <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped datatable">
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th class="text-center">Nama Kriteria</th>
                      <th class="text-center">Bobot Kriteria</th>
                      <th class="text-center">Tipe</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($saveWeights as $index => $saveWeight)
                    <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td>{{ $saveWeight->criteria->name }}</td>
                      <td class="text-center">{{ number_format($saveWeight->weight, 2) }}</td>
                      <td class="text-center">{{ ucfirst($saveWeight->criteria->type) }}</td>
                    </tr>
                    @endforeach
                    @if($saveWeights->isEmpty())
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada data kriteria.</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
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
<script>
  function confirmGenerate() {
    const confirmed = confirm('Data bobot sudah ada dan akan diubah. Yakin ingin melanjutkan?');
    if (confirmed) {
      document.querySelector('input[name="force"]').value = 'true';
      return true; // submit form
    }
    return false; // batalkan submit
  }
</script>
@endsection