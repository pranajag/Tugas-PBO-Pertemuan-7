<?php

namespace App\Models;

class Auditorium extends RuangKelas
{
    private bool $punyaPanggung;

    public function __construct(
        string $kodeRuang,
        string $gedung,
        int $kapasitas,
        bool $punyaPanggung,
        bool $status = true
    ) {
        parent::__construct($kodeRuang, $gedung, $kapasitas, $status);
        $this->punyaPanggung = $punyaPanggung;
    }

    public function getPunyaPanggung(): bool
    {
        return $this->punyaPanggung;
    }

    public function getJenisRuang(): string
    {
        return 'Auditorium';
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " | Auditorium " . ($this->punyaPanggung ? "dengan panggung" : "tanpa panggung");
    }
}

?>