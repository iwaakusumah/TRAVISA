<div class="accordion">
    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-selisih-nilai">
        <h4>Selisih Nilai Kriteria <i>(d)</i></h4>
    </div>
    <div class="accordion-body collapse" id="panel-selisih-nilai" data-parent="#accordion-group">

        <!-- Tabs per Group -->
        <ul class="nav nav-tabs">
            @foreach(collect($allResults)->sortBy('group_name') as $group)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                    data-toggle="tab"
                    href="#diff-{{ $group['group_slug'] }}">
                    {{ $group['group_name'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3">
            @foreach($allResults as $group)
            @php
            $groupName = $group['group_name'];
            $students = collect($group['results'])->sortBy('student.id')->values();
            @endphp

            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                id="diff-{{ $group['group_slug'] }}">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped datatable" id="diff-table-{{ $group['group_slug'] }}">
                            <thead>
                                <tr>
                                    <th class="text-center">Siswa A</th>
                                    <th class="text-center">Siswa B</th>
                                    @foreach($criteriaNames as $criteriaName)
                                    <th class="text-center">{{ $criteriaName }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < $students->count(); $i++)
                                    @for($j = 0; $j < $students->count(); $j++)
                                        @if($i !== $j) <!-- Pastikan siswa yang sama tidak dibandingkan -->
                                        @php
                                        $studentA = $students[$i]['student'];
                                        $studentB = $students[$j]['student'];
                                        @endphp
                                        <tr>
                                            <td>{{ $studentA->name }}</td>
                                            <td>{{ $studentB->name }}</td>
                                            @foreach($criteriaNames as $criteriaId => $criteriaName)
                                            @php
                                            $value = $differenceMatrices[$groupName][$studentA->id][$studentB->id][$criteriaId]
                                            ?? $differenceMatrices[$groupName][$studentB->id][$studentA->id][$criteriaId]
                                            ?? 0;
                                            @endphp
                                            <td class="text-center">{{ number_format($value, 2) }}</td>
                                            @endforeach
                                        </tr>
                                        @endif
                                        @endfor
                                        @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>