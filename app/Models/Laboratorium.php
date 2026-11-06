<?php

namespace App\Models;

use InvalidArgumentException;

class Laboratorium extends RuangKelas
{
    private int $jumlahKomputer;

    public function __construct(
        string $kodeRuang,
        string $gedung,
        int $kapasitas,
        int $jumlahKomputer,
        bool $status = true
    ) {
        parent::__construct($kodeRuang, $gedung, $kapasitas, $status);

        $this->validasiJumlahKomputer($jumlahKomputer, $kapasitas);
        $this->jumlahKomputer = $jumlahKomputer;
    }

    public function getJumlahKomputer(): int
    {
        return $this->jumlahKomputer;
    }

    public function getJenisRuang(): string
    {
        return 'Laboratorium Komputer';
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " | Lab dengan {$this->jumlahKomputer} komputer";
    }

    public function bisaMenampung(int $jumlahPeserta): bool
    {
        return $jumlahPeserta > 0 && $jumlahPeserta <= $this->jumlahKomputer;
    }

    public function siapPraktikum(): bool
    {
        return $this->getStatus() && $this->jumlahKomputer > 0;
    }

    private function validasiJumlahKomputer(int $jumlahKomputer, int $kapasitas): void
    {
        if ($jumlahKomputer < 0) {
            throw new InvalidArgumentException("Jumlah komputer tidak boleh negatif: {$jumlahKomputer}");
        }
        if ($jumlahKomputer > $kapasitas) {
            throw new InvalidArgumentException("Jumlah komputer ({$jumlahKomputer}) melebihi kapasitas ruang ({$kapasitas})");
        }
    }
}
?>