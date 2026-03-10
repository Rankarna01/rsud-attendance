<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi {{ $bulan }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #1F2937; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; color: #1F2937; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; font-size: 12px; color: #555; }
        
        .info { margin-bottom: 20px; }
        .info table { width: 100%; border: none; }
        .info td { border: none; padding: 2px; text-align: left; }

        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.data-table th, table.data-table td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        table.data-table th { background-color: #1F2937; color: #F4C430; text-transform: uppercase; font-size: 11px; }
        table.data-table tbody tr:nth-child(even) { background-color: #f9f9f9; }
        
        .text-left { text-align: left !important; }
        .text-red { color: #EF4444; font-weight: bold; }
        
        .footer { width: 100%; margin-top: 40px; }
        .ttd { float: right; width: 250px; text-align: center; }
        .ttd p { margin: 0 0 70px 0; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SISTEM ABSENSI RSUD GUSTI ABDUL GANI</h1>
        <p>Laporan Rekapitulasi Kehadiran Pegawai</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="15%"><strong>Periode</strong></td>
                <td width="5%">:</td>
                <td>{{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Dicetak Pada</strong></td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th class="text-left" width="30%">Nama Pegawai</th>
                <th width="20%">NIP</th>
                <th width="10%">Hadir</th>
                <th width="10%">Telat</th>
                <th width="10%">Izin</th>
                <th width="10%">Sakit</th>
                <th width="5%">Cuti</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap as $index => $r)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left"><strong>{{ $r['nama'] }}</strong></td>
                <td>{{ $r['nip'] }}</td>
                <td>{{ $r['hadir'] }}</td>
                <td class="{{ $r['telat'] > 0 ? 'text-red' : '' }}">{{ $r['telat'] }}</td>
                <td>{{ $r['izin'] }}</td>
                <td>{{ $r['sakit'] }}</td>
                <td>{{ $r['cuti'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Tidak ada data pegawai untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Kepala Bagian Kepegawaian,</p>
            <strong>_________________________</strong><br>
            NIP. 
        </div>
    </div>

</body>
</html>