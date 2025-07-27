<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Penerima Beasiswa - {{ $period->name }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 40px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .mt-2 {
            margin-top: 20px;
        }

        .mt-4 {
            margin-top: 40px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .table th {
            background-color: #eee;
        }

        .info-table td {
            padding: 4px;
        }

        .signature {
            float: right;
            text-align: left;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    {{-- Header Kota dan Tanggal --}}
    <div class="text-right">
        {{ ucfirst($city) }}, {{ $today }}
    </div>

    {{-- Info Surat --}}
    <table class="info-table mt-2">
        <tr>
            <td style="width: 15%;">Nomor</td>
            <td style="width: 2%;">:</td>
            <td>{{ $letterNumber ?? 'SMK-XYZ/' . date('Y') . '/BEA-01' }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>1 bundel</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>Pemberitahuan Penerima Beasiswa</td>
        </tr>
    </table>

    {{-- Pembuka --}}
    <div class="mt-2">
        <p>Assalamu'alaikum Warrahmatullahi Wabarakatuh.</p>
        <p style="text-align: justify;">
            Sehubungan dengan surat dari Ketua Yayasan nomor <strong>{{ $letterNumber ?? 'SMK-XYZ/' . date('Y') . '/BEA-01' }}</strong> tentang Beasiswa bantuan SPP Semester Genap
            tahun <strong>{{ $period->name }}</strong>, maka kami informasikan hasil evaluasi dan seleksi akademik yang telah dilakukan, berikut adalah daftar siswa yang dinyatakan berhak menerima beasiswa:
        </p>

    </div>

    {{-- Tabel Data --}}
    <table class="table">
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
                <td>{{ number_format($result->leaving_flow, 2) }}</td>
                <td>{{ number_format($result->entering_flow, 2) }}</td>
                <td>{{ number_format($result->net_flow, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Penutup --}}
    <div class="mt-1">
        <p>Demikian kami sampaikan, atas perhatian dan kerjasama yang baik ini kami ucapkan terima kasih.</p>
        <p>Wassalamu'alaikum Warrahmatullahi Wabarakatuh.</p>
    </div>

    {{-- Tanda Tangan --}}
    <div class="signature">
        <p>{{ ucfirst($city) }}, {{ $today }}<br>Kepala Sekolah SMK Travina Prima</p><br><br><br>
        <p><strong><u>({{ $principalName ?? '' }})</u></strong></p>
    </div>

</body>

</html>