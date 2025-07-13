@extends('partials.app')

@section('title', 'Penerima Beasiswa | TRAVISA')

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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-center justify-content-md-end gap-2">
                            <div>
                                @if(isset($periodId) && Auth::user()->role === 'staff_student')
                                <a href="{{ route('staff-student.results.export-pdf', ['period_id' => $periodId]) }}"
                                    class="btn btn-icon icon-left btn-danger mr-1" target="_blank">
                                    <i class="far fa-file-pdf"></i> Export PDF
                                </a>
                                @elseif(isset($periodId) && Auth::user()->role === 'headmaster')
                                <a href="{{ route('headmaster.results.export-pdf', ['period_id' => $periodId]) }}"
                                    class="btn btn-icon icon-left btn-danger mr-1" target="_blank">
                                    <i class="far fa-file-pdf"></i> Export PDF
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-8">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No.
                                            </th>
                                            <th class="text-center">Periode</th>
                                            <th class="text-center">Nama Siswa</th>
                                            <th class="text-center">Jurusan</th>
                                            <th class="text-center">Kelas</th>
                                            <th class="text-center">Leaving Flow</th>
                                            <th class="text-center">Entering Flow</th>
                                            <th class="text-center">Net Flow</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($results as $index => $result)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $result->period->name }}</td>
                                            <td class="text-center">{{ $result->student->name }}</td>
                                            <td class="text-center">{{ $result->student->major }}</td>
                                            <td class="text-center">{{ $result->class->name }}</td>
                                            <td class="text-center">{{ $result->leaving_flow }}</td>
                                            <td class="text-center">{{ $result->entering_flow }}</td>
                                            <td class="text-center">{{ $result->net_flow }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data penerima</td>
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