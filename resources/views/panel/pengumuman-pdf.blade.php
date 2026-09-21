<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $pengumuman->judul }}</title>
    <style>
        @page { margin: 2cm 2cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        .kop {
            text-align: center;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 12pt;
            margin-bottom: 20pt;
        }
        .kop .nama-sekolah {
            font-size: 18pt;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 1pt;
        }
        .kop .alamat {
            font-size: 9pt;
            color: #555;
            margin-top: 4pt;
        }
        .judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 4pt;
            text-decoration: underline;
        }
        .tgl {
            text-align: center;
            font-size: 10pt;
            color: #555;
            margin-bottom: 16pt;
        }
        .pembuka {
            margin-bottom: 12pt;
            text-align: justify;
        }
        .kategori-section {
            margin-top: 20pt;
            page-break-inside: avoid;
        }
        .page-break { page-break-before: always; }
        .kategori-label {
            font-size: 12pt;
            font-weight: bold;
            background: #e5e7eb;
            padding: 5pt 8pt;
            border: 1px solid #333;
            border-bottom: none;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
            font-size: 11pt;
        }
        th, td {
            border: 1px solid #333;
            padding: 5pt 8pt;
            text-align: left;
        }
        th {
            background: #e5e7eb;
            font-weight: bold;
        }
        .text-right { text-align: right; }
        table.detail { font-size: 9pt; margin-top: 6pt; }
        table.detail th, table.detail td { padding: 3pt 6pt; }
        table.detail th { background: #f3f4f6; }
        .detail-title { font-size: 10pt; font-style: italic; margin-top: 8pt; }
        .detail-block { page-break-inside: avoid; margin-bottom: 8pt; }
        .penutup {
            margin-top: 24pt;
            text-align: right;
            font-size: 11pt;
        }
        .penutup .ttd {
            margin-top: 40pt;
        }
    </style>
</head>
<body>
    <div class="kop">
        <div class="nama-sekolah">SD Muhammadiyah Metro Pusat</div>
        <div class="alamat">Jl. A. Yani No. 1, Metro Pusat, Kota Metro, Lampung</div>
    </div>

    <div class="judul">{{ $pengumuman->judul }}</div>
    <div class="tgl">{{ $pengumuman->tanggal->format('d F Y') }}{{ isset($kategoriAktif) && $kategoriAktif ? ' — Kategori: '.$kategoriAktif : '' }}</div>

    <div class="pembuka">
        Assalamu'alaikum Wr. Wb.<br>
        Berikut adalah hasil penilaian SDM Award {{ isset($kategoriAktif) && $kategoriAktif ? 'pada kategori '.strtoupper($kategoriAktif) : '' }}:
    </div>

    @forelse($perKategori as $namaKategori => $rows)
        <div class="{{ !$loop->first || ($kategoriList->count() > 1 && !isset($kategoriAktif)) ? 'page-break' : '' }}">
            <div class="kategori-section">
                <div class="kategori-label">KATEGORI: {{ strtoupper($namaKategori) }}</div>
                <table>
                    <thead>
                        <tr>
                            <th style="width:8%">No</th>
                            <th style="width:14%">Peringkat</th>
                            <th style="width:38%">Nama</th>
                            <th style="width:18%">Kelas</th>
                            <th style="width:22%" class="text-right">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row['peringkat'] }}</td>
                                <td>{{ $row['nama'] }}</td>
                                <td>{{ $row['kelas'] ?? '-' }}</td>
                                <td class="text-right">{{ $row['nilai_akhir'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php
                $adaDetail = $rows->contains(fn ($r) => !empty($r['detail']));
                $kodes = $rows->flatMap(fn ($r) => collect($r['detail'] ?? [])->keys())->unique()->sort()->values();
            @endphp

            @if($adaDetail && $kodes->isNotEmpty())
                <div class="detail-title">Detail Penilaian (metode SAW):</div>
                @foreach($rows as $row)
                    @if(!empty($row['detail']))
                        <div class="detail-block">
                            <table class="detail">
                                <thead>
                                    <tr>
                                        <th colspan="{{ $kodes->count() * 3 + 3 }}">{{ $row['peringkat'] }}. {{ $row['nama'] }} — Kelas {{ $row['kelas'] ?? '-' }} (Nilai Akhir: {{ $row['nilai_akhir'] }})</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" style="width:22%">Kriteria</th>
                                        <th colspan="3" class="text-center">{{ implode(' / ', $kodes->all()) }}</th>
                                        <th rowspan="2" style="width:20%" class="text-right">Total Nilai Akhir</th>
                                    </tr>
                                    <tr>
                                        @foreach(range(1,3) as $i)
                                            <th>{{ ['Nilai (X)', 'Normalisasi', 'Kontribusi'][$i-1] }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kodes as $kode)
                                        @php $d = $row['detail'][$kode] ?? null; @endphp
                                        <tr>
                                            <td>{{ $kode }}</td>
                                            <td class="text-right">{{ $d ? $d['x'] : '-' }}</td>
                                            <td class="text-right">{{ $d ? $d['rnorm'].' × w='.$d['w'] : '-' }}</td>
                                            <td class="text-right">{{ $d ? $d['kontrib'] : '-' }}</td>
                                            @if($loop->first)
                                                <td rowspan="{{ $kodes->count() }}" class="text-right" style="font-weight:bold; vertical-align:middle;">{{ $row['nilai_akhir'] }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    @empty
        <div class="pembuka">{{ $pengumuman->isi }}</div>
    @endforelse

    <div class="penutup">
        Wassalamu'alaikum Wr. Wb.<br><br>
        Metro, {{ $pengumuman->tanggal->format('d F Y') }}<br>
        Panitia SDM Award<br><br><br>
        <div class="ttd">( _______________________ )</div>
    </div>
</body>
</html>
