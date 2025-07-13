@extends('partials.app')

@section('title', 'Data Penerima Beasiswa | TRAVISA')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Data Penerima Beasiswa</h1>
      <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active">
            @if (Auth::user()->role === 'staff_student')
            <a href="{{ route('staff-student.dashboard') }}">Dashboard</a>
            @elseif (Auth::user()->role === 'headmaster')
            <a href="{{ route('headmaster.dashboard') }}">Dashboard</a>
            @else
            <a href="#">Dashboard</a>
            @endif
          </div>
        <div class="breadcrumb-item">Data Penerima Beasiswa</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="card col-12">
          <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
            @endif
            @php
            $role = Auth::user()->role;
            $actionRoute = match($role) {
            'staff_student' => route('staff-student.results.index'),
            'headmaster' => route('headmaster.results.index'),
            default => '#', // fallback jika role tidak dikenal
            };
            @endphp

            <form action="{{ $actionRoute }}" method="GET">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="period_id">Periode:</label>
                  <select id="period_id" name="period_id" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Periode --</option>
                    @foreach($periods as $period)
                    <option value="{{ $period->id }}" {{ (isset($periodId) && $periodId == $period->id) ? 'selected' : '' }}>
                      {{ $period->name }}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Tampilkan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection