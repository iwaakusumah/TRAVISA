@extends('partials.app')

@section('title', 'Edit Bobot Kriteria | TRAVISA')

@section('content')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Edit Bobot Kriteria</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('staff-student.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item active"><a href="{{ route('staff-student.weights.index') }}">Bobot Kriteria</a></div>
        <div class="breadcrumb-item">Edit Bobot Kriteria</div>
      </div>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="card col-12">
          <div class="card-body">
            <form method="POST" action="{{ route('staff-student.weights.updateAll') }}">
              @csrf

              <!-- Student Selector -->
              @foreach ($weights as $weight)
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">{{ $weight->criteria->name }}</label>
                <div class="col-sm-4">
                  <input type="number" step="0.01" min="0" max="1" name="weights[{{ $weight->id }}]" value="{{ old('weights.' . $weight->id, $weight->weight) }}" class="form-control" required>
                </div>
              </div>
              @endforeach
              <div class="card-footer text-right">
                <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

</div>
</section>
</div>

@endsection