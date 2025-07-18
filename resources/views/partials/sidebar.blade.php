<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">TRAVISA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">TS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            @php
            $user = Auth::user();
            @endphp

            @if ($user->role === 'homeroom_teacher')
            <li class="{{ Route::is('homeroom-teacher.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('homeroom-teacher.dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            @elseif ($user->role === 'administration')
            <li class="{{ Route::is('administration.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('administration.dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            @elseif ($user->role === 'staff_student')
            <li class="{{ Route::is('staff-student.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('staff-student.dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            @elseif ($user->role === 'headmaster')
            <li class="{{ Route::is('headmaster.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('headmaster.dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            @endif

            @if (in_array(auth()->user()->role, ['homeroom_teacher', 'administration']))
            <li class="menu-header">Data Siswa</li>

            @if (auth()->user()->role == 'homeroom_teacher')
            <li class="{{ Route::is('homeroom-teacher.students.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('homeroom-teacher.students.index') }}">
                    <i class="far fa-id-card"></i> <span>Data Siswa</span>
                </a>
            </li>
            <li class="{{ Route::is('homeroom-teacher.scores.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('homeroom-teacher.scores.index') }}">
                    <i class="far fa-file-alt"></i> <span>Nilai Siswa</span>
                </a>
            </li>

            @elseif (auth()->user()->role == 'administration')
            <li class="{{ Route::is('administration.students.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('administration.students.index') }}">
                    <i class="far fa-id-card"></i> <span>Data Siswa</span>
                </a>
            </li>
            @endif
            @endif
            
            @if (auth()->user()->role === 'administration')
            <li class="menu-header">Data Pengguna</li>
            <li class="{{ Route::is('administration.users.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('administration.users.index') }}"><i class="fas fa-users"></i> <span>Data Pengguna</span></a></li>
            @endif

            @if (auth()->user()->role === 'staff_student')
            <li class="menu-header">Data Kriteria dan Bobot</li>
            <li class="{{ Route::is('staff-student.criterias.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff-student.criterias.index') }}"><i class="far fa-list-alt"></i> <span>Data Kriteria</span></a></li>
            <li class="{{ Route::is('staff-student.weights.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff-student.weights.index') }}"><i class="fas fa-balance-scale"></i> <span>Bobot Kriteria</span></a></li>
            @endif

            @if (in_array(auth()->user()->role, ['staff_student', 'headmaster']))
            <li class="menu-header">Proses dan Hasil</li>

            @if (auth()->user()->role == 'staff_student')
            <li class="{{ Route::is('staff-student.calculations.form') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff-student.calculations.form') }}"><i class="far fa-list-alt"></i> <span>Proses Perhitungan</span></a></li>
            <li class="{{ Route::is('staff-student.results.form') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff-student.results.form') }}"><i class="fas fa-trophy"></i> <span>Penerima Beasiswa</span></a></li>

            @elseif (auth()->user()->role == 'headmaster')
            <li class="{{ Route::is('headmaster.calculations.form') ? 'active' : '' }}"><a class="nav-link" href="{{ route('headmaster.calculations.form') }}"><i class="far fa-list-alt"></i> <span>Proses Perhitungan</span></a></li>
            <li class="{{ Route::is('headmaster.results.form') ? 'active' : '' }}"><a class="nav-link" href="{{ route('headmaster.results.form') }}"><i class="fas fa-trophy"></i> <span>Penerima Beasiswa</span></a></li>
        </ul>
        @endif
        @endif

    </aside>
</div>