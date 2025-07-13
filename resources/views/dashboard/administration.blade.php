@extends('partials.app')

@section('title', 'Dashboard Tata Usaha | TRAVISA')

@section('content')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      {{-- Total Students --}}
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Jumlah Siswa</h4>
            </div>
            <div class="card-body">
              {{ $totalStudent }}
            </div>
          </div>
        </div>
      </div>

      {{-- Criteria Completion --}}
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Rata-Rata Nilai Pengetahuan</h4>
            </div>
            <div class="card-body">
              {{ number_format($averageScoreKnowledge, 2) }}
            </div>
          </div>
        </div>
      </div>

      {{-- Average Score --}}
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Rata-Rata Nilai Keterampilan</h4>
            </div>
            <div class="card-body">
              {{ number_format($averageScoreSkill, 2) }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Apa itu TRAVISA?</h4>
            <div class="card-header-action">
              <a data-collapse="#mycard-collapse" class="btn btn-icon btn-primary" href="#"><i class="fas fa-minus"></i></a>
            </div>
          </div>
          <div class="collapse show" id="mycard-collapse">
            <div class="card-body" style="text-align: justify;">
              TRAVISA (Travina Scholarship Assistance System) merupakan solusi digital pintar yang memudahkan SMK Travina Prima dalam proses seleksi penerima beasiswa. Dengan TRAVISA, keputusan diambil berdasarkan data lengkap dan analisis yang akurat, sehingga proses menjadi lebih cepat, objektif, dan transparan. TRAVISA memastikan setiap beasiswa diberikan kepada calon siswa yang paling berhak, membuka jalan bagi masa depan yang lebih cerah dan berprestasi.
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>

@section('dashboard')
<script src="{{ asset('assets/js/page/index-0.js') }}"></script>
@endsection

@endsection