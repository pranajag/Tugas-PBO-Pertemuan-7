@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2>{{ $judulHalaman }}</h2>
                <p style="color: #64748b; margin-top: 0.25rem;">
                    Implementasi <strong>Interface BisaDipesan</strong> &amp; <strong>Composition PeminjamanRuang</strong> dari <code>app/Models/</code>.
                </p>
            </div>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <a class="btn {{ $statusFilter === null ? '' : 'btn-outline' }}" href="{{ route('ruang.peminjaman') }}">Semua</a>
                <a class="btn {{ $statusFilter === 'disetujui' ? '' : 'btn-outline' }}" href="{{ route('ruang.peminjaman', 'disetujui') }}">Disetujui</a>
                <a class="btn {{ $statusFilter === 'diajukan' ? '' : 'btn-outline' }}" href="{{ route('ruang.peminjaman', 'diajukan') }}">Diajukan</a>
                <a class="btn {{ $statusFilter === 'ditolak' ? '' : 'btn-outline' }}" href="{{ route('ruang.peminjaman', 'ditolak') }}">Ditolak</a>
            </div>
        </div>

        <div style="margin-top: 1rem;">
            @if ($statusFilter !== null)
                <span class="badge badge-info">Filter Parameter Aktif: Status = {{ strtoupper($statusFilter) }}</span>
            @else
                <span class="badge badge-success">Menampilkan Seluruh Transaksi Peminjaman ({{ count($daftarPeminjaman) }} data)</span>
            @endif
        </div>

        @if (count($daftarPeminjaman) === 0)
            <p style="margin-top: 1rem;">Tidak ada data peminjaman dengan status tersebut.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Ruang</th>
                        <th>Mahasiswa Peminjam</th>
                        <th>Jadwal Peminjaman</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Output Kontrak <code>prosesPeminjaman()</code></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarPeminjaman as $pinjam)
                        <tr>
                            <td>
                                <a href="{{ route('ruang.show', $pinjam->getRuang()->getKodeRuang()) }}">
                                    <strong>{{ $pinjam->getRuang()->getKodeRuang() }}</strong>
                                </a>
                                <br>
                                <small style="color: #64748b;">{{ $pinjam->getRuang()->getGedung() }}</small>
                            </td>
                            <td>
                                <strong>{{ $pinjam->getPeminjam() }}</strong><br>
                                <small style="color: #64748b;">NIM: {{ $pinjam->getNim() }}</small>
                            </td>
                            <td>
                                {{ $pinjam->getTanggal() }}<br>
                                <small>{{ $pinjam->getJamMulai() }} - {{ $pinjam->getJamSelesai() }} WIB</small>
                            </td>
                            <td>{{ $pinjam->getKeperluan() }}</td>
                            <td>
                                @if ($pinjam->getStatusPengajuan() === 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif ($pinjam->getStatusPengajuan() === 'diajukan')
                                    <span class="badge badge-warning">Diajukan</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $pinjam->prosesPeminjaman() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection