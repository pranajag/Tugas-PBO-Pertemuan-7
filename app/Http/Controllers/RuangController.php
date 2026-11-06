<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use App\Models\Laboratorium;
use App\Models\PeminjamanRuang;
use App\Models\RuangKelas;
use Illuminate\View\View;

class RuangController extends Controller
{
    private function ambilKoleksiRuang(): array
    {
        $ruangA01 = new RuangKelas('A01', 'Gedung A', 60, true);
        $ruangB01 = new RuangKelas('B01', 'Gedung B', 45, true);
        $ruangC01 = new RuangKelas('C01', 'Gedung C', 35, false);
        $lab01    = new Laboratorium('LAB01', 'Gedung C', 40, 30, true);
        $lab03    = new Laboratorium('LAB03', 'Gedung C', 30, 25, true);
        $audit01  = new Auditorium('AUD01', 'Gedung D', 300, true, true);
        $audit02  = new Auditorium('AUD02', 'Gedung D', 200, false, true);

        return [
            'A01'   => $ruangA01,
            'B01'   => $ruangB01,
            'C01'   => $ruangC01,
            'LAB01' => $lab01,
            'LAB03' => $lab03,
            'AUD01' => $audit01,
            'AUD02' => $audit02,
        ];
    }

    private function ambilDaftarPeminjaman(array $koleksiRuang): array
    {
        return [
            new PeminjamanRuang(
                $koleksiRuang['A01'],
                'Pranaja Gathan Aqila',
                '20251020012',
                '17 Oktober 2026',
                '09.00',
                '12.00',
                'Praktikum Mandiri & Diskusi Kelompok PBO',
                'disetujui'
            ),
            new PeminjamanRuang(
                $koleksiRuang['LAB01'],
                'Pranaja Gathan Aqila',
                '20251020012',
                '20 Oktober 2026',
                '13.00',
                '15.30',
                'Workshop Laravel 13 MVC & Clean Code',
                'diajukan'
            ),
            new PeminjamanRuang(
                $koleksiRuang['C01'],
                'Budi Santoso',
                '20251020099',
                '25 Oktober 2026',
                '13.00',
                '15.00',
                'Rapat Koordinasi Himpunan',
                'ditolak'
            ),
            new PeminjamanRuang(
                $koleksiRuang['AUD01'],
                'Siti Aminah',
                '20251020045',
                '28 Oktober 2026',
                '08.00',
                '12.00',
                'Seminar Nasional Keamanan Siber Kampus',
                'disetujui'
            ),
        ];
    }

    public function index(): View
    {
        $koleksiRuang = $this->ambilKoleksiRuang();
        $totalRuang = count($koleksiRuang);
        $totalTersedia = count(array_filter($koleksiRuang, fn (RuangKelas $r) => $r->getStatus()));

        return view('ruang.index', [
            'judulHalaman'  => 'Daftar Ruang Kampus (OOP Polymorphism)',
            'daftarRuang'   => $koleksiRuang,
            'totalRuang'    => $totalRuang,
            'totalTersedia' => $totalTersedia,
        ]);
    }

    public function show(string $kode): View
    {
        $kodeBersih = strtoupper(trim($kode));
        $koleksiRuang = $this->ambilKoleksiRuang();

        if (!isset($koleksiRuang[$kodeBersih])) {
            abort(404, "Data ruang dengan kode {$kodeBersih} tidak ditemukan.");
        }

        $ruang = $koleksiRuang[$kodeBersih];

        $riwayatRuang = array_filter(
            $this->ambilDaftarPeminjaman($koleksiRuang),
            fn (PeminjamanRuang $p) => $p->getRuang()->getKodeRuang() === $kodeBersih
        );

        $simulasiPeserta = 35;

        return view('ruang.show', [
            'judulHalaman'    => "Detail Ruang {$ruang->getKodeRuang()}",
            'ruang'           => $ruang,
            'riwayatRuang'    => $riwayatRuang,
            'simulasiPeserta' => $simulasiPeserta,
            'cukupUntuk35'    => $ruang->bisaMenampung($simulasiPeserta),
            'infoCekJadwal'   => $ruang->cekKetersediaan('25 Oktober 2026', '10.00', '12.00'),
        ]);
    }

    public function peminjaman(?string $status = null): View
    {
        $koleksiRuang = $this->ambilKoleksiRuang();
        $semuaPeminjaman = $this->ambilDaftarPeminjaman($koleksiRuang);

        $statusValid = ['diajukan', 'disetujui', 'ditolak'];
        $statusFilter = $status !== null ? strtolower(trim($status)) : null;

        if ($statusFilter !== null && in_array($statusFilter, $statusValid, true)) {
            $daftarPeminjaman = array_filter(
                $semuaPeminjaman,
                fn (PeminjamanRuang $p) => $p->getStatusPengajuan() === $statusFilter
            );
        } else {
            $statusFilter = null;
            $daftarPeminjaman = $semuaPeminjaman;
        }

        return view('ruang.peminjaman', [
            'judulHalaman'     => 'Daftar & Simulasi Peminjaman Ruang Kampus',
            'daftarPeminjaman' => $daftarPeminjaman,
            'statusFilter'     => $statusFilter,
        ]);
    }
}

?>