<div class="accordion">
    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-matriks-preferensi">
        <h4>Matriks Indeks Preferensi Multi-Kriteria <i>(Q)</i></h4>
    </div>
    <div class="accordion-body collapse" id="panel-matriks-preferensi" data-parent="#accordion-group">
        <ul class="nav nav-tabs" id="pref-tabs" role="tablist">
            @foreach(collect($allResults)->sortBy('group_name') as $group)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                    data-toggle="tab"
                    href="#pref-{{ $group['group_slug'] }}">
                    {{ $group['group_name'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3">
            @foreach($allResults as $group)
            @php
            $groupName = $group['group_name'];
            $students = collect($group['results'])->sortBy('student.id');
            $studentIds = $students->pluck('student.id');
            $studentNames = $students->pluck('student.name', 'student.id');
            $preferenceMatrix = $preferenceMatrices[$groupName] ?? [];
            @endphp
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                id="pref-{{ $group['group_slug'] }}">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped datatable" id="pref-table-{{ $group['group_slug'] }}">
                            <thead>
                                <tr>
                                    <th class="text-center">Siswa</th>
                                    @foreach($students as $student)
                                    <th class="text-center">{{ $student['student']->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $studentA)
                                <tr>
                                    <td><strong>{{ $studentA['student']->name }}</strong></td>
                                    @foreach($students as $studentB)
                                    <td class="text-center">
                                        {{ number_format($preferenceMatrix[$studentA['student']->id][$studentB['student']->id] ?? 0, 2) }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>