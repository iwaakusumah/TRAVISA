<div class="accordion">
    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-matriks-evaluasi" aria-expanded="true">
        <h4>Matriks Evaluasi</h4>
    </div>
    <div class="accordion-body collapse show" id="panel-matriks-evaluasi" data-parent="#accordion-group">
        <ul class="nav nav-tabs" id="eval-tabs" role="tablist">
            @foreach(collect($allResults)->sortBy('group_name') as $group)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                    data-toggle="tab"
                    href="#eval-{{ $group['group_slug'] }}">
                    {{ $group['group_name'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3">
            @foreach($allResults as $group)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                id="eval-{{ $group['group_slug'] }}">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Siswa</th>
                                @foreach($criteriaNames as $name)
                                <th class="text-center">{{ $name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group['results'] as $result)
                            <tr>
                                <td>{{ $result['student']->name }}</td>
                                @foreach($criteriaNames as $id => $name)
                                <td class="text-center">
                                    {{ number_format($evaluationMatrices[$group['group_name']][$result['student']->id][$id] ?? 0, 2) }}
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
