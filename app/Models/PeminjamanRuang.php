<?php

namespace App\Models;

class PeminjamanRuang implements BisaDipesan
{
    private RuangKelas $ruang;
    private string $peminjam;
    private string $nim;
    private string $tanggal;
    private string $jamMulai;
    private string $jamSelesai;
    private string $keperluan;
    private string $statusPengajuan;

    public function __construct(
        RuangKelas $ruang,
        string $peminjam,
        string $nim,
        string $tanggal,
        string $jamMulai,
        string $jamSelesai,
        string $keperluan,
        string $statusPengajuan = 'diajukan'
    ) {
        $this->ruang = $ruang;
        $this->peminjam = trim($peminjam);
        $this->nim = trim($nim);
        $this->tanggal = trim($tanggal);
        $this->jamMulai = trim($jamMulai);
        $this->jamSelesai = trim($jamSelesai);
        $this->keperluan = trim($keperluan);
        $this->statusPengajuan = $statusPengajuan;
    }

    public function getRuang(): RuangKelas
    {
        return $this->ruang;
    }

    public function getPeminjam(): string
    {
        return $this->peminjam;
    }

    public function getNim(): string
    {
        return $this->nim;
    }

    public function getTanggal(): string
    {
        return $this->tanggal;
    }

    public function getJamMulai(): string
    {
        return $this->jamMulai;
    }

    public function getJamSelesai(): string
    {
        return $this->jamSelesai;
    }

    public function getKeperluan(): string
    {
        return $this->keperluan;
    }

    public function getStatusPengajuan(): string
    {
        return $this->statusPengajuan;
    }

    public function prosesPeminjaman(): string
    {
        if (!$this->ruang->getStatus()) {
            $this->statusPengajuan = 'ditolak';
            return "Peminjaman {$this->ruang->getKodeRuang()} ditolak karena ruang sedang tidak dapat dipinjam.";
        }

        $infoKetersediaan = $this->ruang->cekKetersediaan($this->tanggal, $this->jamMulai, $this->jamSelesai);

        return "Peminjaman {$this->ruang->getKodeRuang()} berhasil dicatat ({$infoKetersediaan}).";
    }
}

?>