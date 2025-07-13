<div class="accordion">
    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-matriks-h">
        <h4>Matriks Preferensi per Kriteria <i>H(d)</i></h4>
    </div>
    <div class="accordion-body collapse" id="panel-matriks-h" data-parent="#accordion-group">

        <!-- Tab Navigation per Group -->
        <ul class="nav nav-tabs" id="h-tabs" role="tablist">
            @foreach(collect($allResults)->sortBy('group_name') as $group)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                    data-toggle="tab"
                    href="#h-{{ $group['group_slug'] }}">
                    {{ $group['group_name'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3">
            @foreach($allResults as $group)
            @php
            $groupName = $group['group_name'];
            $students = collect($group['results'])->sortBy('student.id');
            $studentIds = $students->pluck('student.id');
            $studentNames = $students->pluck('student.name', 'student.id');
            $hMatrix = $allHMatrix[$groupName] ?? [];
            @endphp

            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                id="h-{{ $group['group_slug'] }}">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center align-middle">Siswa A</th>
                                    <th class="text-center align-middle">Siswa B</th>
                                    @foreach($criteriaNames as $criterionName)
                                    <th class="text-center">{{ $criterionName }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentIds as $idA)
                                @foreach($studentIds as $idB)
                                @if($idA < $idB)
                                    <tr>
                                    <td>{{ $studentNames[$idA] }}</td>
                                    <td>{{ $studentNames[$idB] }}</td>
                                    @foreach($criteriaNames as $criterionId => $criterionName)
                                    <td class="text-center">
                                        {{ number_format($hMatrix[$idA][$idB][$criterionId] ?? 0, 2) }}
                                    </td>
                                    @endforeach
                                    </tr>
                                    @endif
                                    @endforeach
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