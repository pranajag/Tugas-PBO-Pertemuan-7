@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="badge badge-info">{{ $ruang->getJenisRuang() }}</span>
                <h2 style="margin-top: 0.35rem;">{{ $judulHalaman }}</h2>
            </div>
            <a class="btn btn-outline" href="{{ route('ruang.index') }}">&larr; Kembali ke Daftar Ruang</a>
        </div>

        <table style="margin-top: 1.25rem;">
            <tbody>
                <tr>
                    <th style="width: 260px;">Kode Ruang</th>
                    <td><strong>{{ $ruang->getKodeRuang() }}</strong></td>
                </tr>
                <tr>
                    <th>Lokasi Gedung</th>
                    <td>{{ $ruang->getGedung() }}</td>
                </tr>
                <tr>
                    <th>Kapasitas Kursi</th>
                    <td>{{ $ruang->getKapasitas() }} orang</td>
                </tr>
                <tr>
                    <th>Output Polymorphism <code>getInfo()</code></th>
                    <td>{{ $ruang->getInfo() }}</td>
                </tr>
                <tr>
                    <th>Status Saat Ini</th>
                    <td>
                        @if ($ruang->getStatus())
                            <span class="badge badge-success">Dapat Dipinjam (Tersedia)</span>
                        @else
                            <span class="badge badge-danger">Tidak Dapat Dipinjam (Ditutup)</span>
                        @endif
                    </td>
                </tr>

                {{-- Cek apakah objek ini turunan Laboratorium atau Auditorium --}}
                @if ($ruang instanceof \App\Models\Laboratorium)
                    <tr>
                        <th>Jumlah Komputer (Khusus Lab)</th>
                        <td>{{ $ruang->getJumlahKomputer() }} unit komputer</td>
                    </tr>
                    <tr>
                        <th>Kesiapan Praktikum (<code>siapPraktikum()</code>)</th>
                        <td>
                            @if ($ruang->siapPraktikum())
                                <span class="badge badge-success">Siap Dipakai Praktikum</span>
                            @else
                                <span class="badge badge-danger">Belum Siap Praktikum</span>
                            @endif
                        </td>
                    </tr>
                @elseif ($ruang instanceof \App\Models\Auditorium)
                    <tr>
                        <th>Fasilitas Panggung (Khusus Auditorium)</th>
                        <td>
                            @if ($ruang->getPunyaPanggung())
                                <span class="badge badge-success">Memiliki Panggung Utama</span>
                            @else
                                <span class="badge badge-warning">Tanpa Panggung</span>
                            @endif
                        </td>
                    </tr>
                @endif

                <tr>
                    <th>Uji Method <code>bisaMenampung({{ $simulasiPeserta }})</code></th>
                    <td>
                        @if ($cukupUntuk35)
                            <span class="badge badge-success">Muat untuk {{ $simulasiPeserta }} peserta</span>
                        @else
                            <span class="badge badge-danger">Tidak Muat untuk {{ $simulasiPeserta }} peserta</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Simulasi <code>cekKetersediaan()</code></th>
                    <td><code>{{ $infoCekJadwal }}</code></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3>Riwayat Pengajuan Peminjaman di Ruang {{ $ruang->getKodeRuang() }}</h3>
        @if (count($riwayatRuang) === 0)
            <p style="color: #64748b; margin-top: 0.5rem;">Belum ada pengajuan peminjaman untuk ruang ini.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Peminjam (NIM)</th>
                        <th>Tanggal &amp; Jam</th>
                        <th>Keperluan</th>
                        <th>Status Pengajuan</th>
                        <th>Hasil Method <code>prosesPeminjaman()</code></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatRuang as $item)
                        <tr>
                            <td><strong>{{ $item->getPeminjam() }}</strong> ({{ $item->getNim() }})</td>
                            <td>{{ $item->getTanggal() }} | {{ $item->getJamMulai() }} - {{ $item->getJamSelesai() }}</td>
                            <td>{{ $item->getKeperluan() }}</td>
                            <td>
                                @if ($item->getStatusPengajuan() === 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif ($item->getStatusPengajuan() === 'diajukan')
                                    <span class="badge badge-warning">Menunggu BAAK</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $item->prosesPeminjaman() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection