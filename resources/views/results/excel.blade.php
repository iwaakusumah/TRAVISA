<!DOCTYPE html>
<html>
<head>
    <title>Hasil Periode {{ $period->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Data Hasil Periode: {{ $period->name }}</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Siswa</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Leaving Flow</th>
                <th>Entering Flow</th>
                <th>Net Flow</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ optional($result->student)->name }}</td>
                    <td>{{ optional($result->student)->major }}</td>
                    <td>{{ optional($result->class)->name }}</td>
                    <td>{{ $result->leaving_flow }}</td>
                    <td>{{ $result->entering_flow }}</td>
                    <td>{{ $result->net_flow }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
