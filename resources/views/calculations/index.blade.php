@extends('partials.app')

@section('title', 'Seleksi Penerima Beasiswa | TRAVISA')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Seleksi Penerima Beasiswa</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Hasil Perhitungan PROMETHEE</h4>

                    @if (Auth::user()->role !== 'headmaster')
                    <form id="save-form" method="POST" action="{{ route('staff-student.calculations.save') }}">
                        @csrf
                        <input type="hidden" name="period_id" value="{{ $period->id }}">

                        <a href="#"
                            class="btn btn-icon icon-left btn-primary mr-1"
                            data-toggle="tooltip"
                            title="Simpan Data"
                            data-confirm="Apakah Anda yakin?|Data siswa yang lolos akan disimpan?"
                            data-confirm-yes="document.getElementById('save-form').submit();">
                            <i class="far fa-plus-square"></i> Simpan Data
                        </a>
                    </form>
                    @endif
                </div>

                <div class="card-body">
                    <div id="accordion-group">
                        {{-- Include matriks dan hasil lainnya --}}
                        @include('calculations.components.evaluation', ['allResults' => $allResults, 'evaluationMatrices' => $evaluationMatrices, 'criteriaNames' => $criteriaNames])
                        @include('calculations.components.difference', ['allResults' => $allResults, 'differenceMatrices' => $differenceMatrices, 'criteriaNames' => $criteriaNames])
                        @include('calculations.components.h', ['allResults' => $allResults, 'allHMatrix' => $allHMatrix, 'criteriaNames' => $criteriaNames])
                        @include('calculations.components.preference', ['allResults' => $allResults, 'preferenceMatrices' => $preferenceMatrices])
                        @include('calculations.components.ranking', ['allResults' => $allResults])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('table')
<script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
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