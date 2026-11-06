@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>{{ $judulHalaman }}</h2>
        <p style="color: #64748b; margin-top: 0.25rem;">
            Menampilkan objek <strong>RuangKelas</strong>, <strong>Laboratorium</strong>, dan <strong>Auditorium</strong> dari <code>app/Models/</code>.
        </p>

        <div style="margin-top: 1rem;">
            @if ($totalTersedia > 0)
                <span class="badge badge-success">
                    Tersedia {{ $totalTersedia }} dari {{ $totalRuang }} ruang siap dipinjam hari ini
                </span>
            @else
                <span class="badge badge-danger">
                    Maaf, seluruh ruang sedang penuh atau tidak dapat dipinjam
                </span>
            @endif
        </div>

        @if (count($daftarRuang) === 0)
            <p style="margin-top: 1rem;">Belum ada data ruang yang terdaftar.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Jenis Ruang</th>
                        <th>Gedung</th>
                        <th>Kapasitas</th>
                        <th>Informasi Polymorphism (getInfo)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarRuang as $ruang)
                        <tr>
                            <td><strong>{{ $ruang->getKodeRuang() }}</strong></td>
                            <td><span class="badge badge-info">{{ $ruang->getJenisRuang() }}</span></td>
                            <td>{{ $ruang->getGedung() }}</td>
                            <td>{{ $ruang->getKapasitas() }} orang</td>
                            <td>{{ $ruang->getInfo() }}</td>
                            <td>
                                @if ($ruang->getStatus())
                                    <span class="badge badge-success">Dapat Dipinjam</span>
                                @else
                                    <span class="badge badge-danger">Tidak Tersedia</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn" href="{{ route('ruang.show', $ruang->getKodeRuang()) }}">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection