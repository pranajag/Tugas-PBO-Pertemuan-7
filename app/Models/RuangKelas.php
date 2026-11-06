<?php
namespace App\Models;

use InvalidArgumentException;

class RuangKelas
{
    private string $kodeRuang;
    private string $gedung;
    private int $kapasitas;
    private bool $status = true;

    public function __construct(string $kodeRuang, string $gedung, int $kapasitas, bool $status = true)
    {
        $this->validasiKodeRuang($kodeRuang);
        $this->validasiGedung($gedung);
        $this->validasiKapasitas($kapasitas);

        $this->kodeRuang = strtoupper(trim($kodeRuang));
        $this->gedung = trim($gedung);
        $this->kapasitas = $kapasitas;
        $this->status = $status;
    }

    public function getKodeRuang(): string
    {
        return $this->kodeRuang;
    }

    public function getGedung(): string
    {
        return $this->gedung;
    }

    public function getKapasitas(): int
    {
        return $this->kapasitas;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getJenisRuang(): string
    {
        return 'Ruang Kelas Reguler';
    }

    public function setKapasitas(int $kapasitas): void
    {
        $this->validasiKapasitas($kapasitas);
        $this->kapasitas = $kapasitas;
    }

    public function getInfo(): string
    {
        return "Ruang {$this->kodeRuang} | {$this->gedung} | Kapasitas {$this->kapasitas} orang";
    }

    public function bisaMenampung(int $jumlahPeserta): bool
    {
        return $jumlahPeserta > 0 && $jumlahPeserta <= $this->kapasitas;
    }

    public function cekKetersediaan(string $tanggal, string $jamMulai, string $jamSelesai): string
    {
        $this->validasiJam($jamMulai, $jamSelesai);

        if ($this->status) {
            return "{$this->kodeRuang} TERSEDIA pada {$tanggal}, {$jamMulai} - {$jamSelesai}";
        }

        return "{$this->kodeRuang} TIDAK TERSEDIA pada {$tanggal}, {$jamMulai} - {$jamSelesai}";
    }

    public function ubahStatus(bool $statusBaru): void
    {
        $this->status = $statusBaru;
    }

    private function validasiKodeRuang(string $kodeRuang): void
    {
        if (trim($kodeRuang) === '' || !preg_match('/^[A-Za-z0-9\-]+$/', trim($kodeRuang))) {
            throw new InvalidArgumentException("Kode ruang tidak valid atau kosong.");
        }
    }

    private function validasiGedung(string $gedung): void
    {
        if (trim($gedung) === '') {
            throw new InvalidArgumentException("Nama gedung tidak boleh kosong.");
        }
    }

    private function validasiKapasitas(int $kapasitas): void
    {
        if ($kapasitas <= 0) {
            throw new InvalidArgumentException("Kapasitas harus lebih dari 0, yang dikirim: {$kapasitas}");
        }
    }

    private function validasiJam(string $jamMulai, string $jamSelesai): void
    {
        $menitMulai = $this->konversiJamKeMenit($jamMulai);
        $menitSelesai = $this->konversiJamKeMenit($jamSelesai);

        if ($menitSelesai <= $menitMulai) {
            throw new InvalidArgumentException("Jam selesai ({$jamSelesai}) harus setelah jam mulai ({$jamMulai})");
        }
    }

    private function konversiJamKeMenit(string $jam): int
    {
        $jamBersih = str_replace(':', '.', trim($jam));
        if (!preg_match('/^([01]?[0-9]|2[0-3])\.([0-5][0-9])$/', $jamBersih, $matches)) {
            throw new InvalidArgumentException("Format jam tidak valid: {$jam}");
        }

        return ((int) $matches[1] * 60) + (int) $matches[2];
    }
}

?>