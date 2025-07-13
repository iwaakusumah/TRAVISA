<div class="accordion">
    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-hasil-akhir">
        <h4>Hasil Seleksi Beasiswa</h4>
    </div>
    <div class="accordion-body collapse" id="panel-hasil-akhir" data-parent="#accordion-group">
        <ul class="nav nav-tabs" id="result-tabs" role="tablist">
            @foreach(collect($allResults)->sortBy('group_name') as $group)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                    data-toggle="tab"
                    href="#result-{{ $group['group_slug'] }}">
                    {{ $group['group_name'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3">
            @foreach($allResults as $group)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                id="result-{{ $group['group_slug'] }}">
                <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Rank</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">Leaving Flow</th>
                                <th class="text-center">Entering Flow</th>
                                <th class="text-center">Net Flow</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group['results'] as $result)
                            <tr>
                                <td class="text-center">{{ $result['rank'] }}</td>
                                <td>{{ $result['student']->name }}</td>
                                <td class="text-center">{{ number_format($result['leaving_flow'], 2) }}</td>
                                <td class="text-center">{{ number_format($result['entering_flow'], 2) }}</td>
                                <td class="text-center">{{ number_format($result['net_flow'], 2) }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $result['rank'] <= 1 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $result['rank'] <= 1 ? 'Lolos' : 'Tidak Lolos' }}
                                    </span>
                                </td>
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
