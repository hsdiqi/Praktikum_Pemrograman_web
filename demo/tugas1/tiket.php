<?php

namespace PemesananTiket;

trait Pesan {
    public function cetakTiket($nama) {
        echo "<div class='output-item'>Tiket untuk $nama telah dicetak.</div>";
    }
}

abstract class Tiket {
    protected $nama;
    protected $harga;

    public function __construct($nama, $harga) {
        $this->nama = $nama;
        $this->harga = $harga;
    }

    abstract public function hitungTotal($jumlah);
}

class TiketWisata extends Tiket {
    use Pesan;

    public function hitungTotal($jumlah) {
        return $this->harga * $jumlah;
    }

    public function infoTiket($jumlah) {
        echo "<div class='output-item'>Nama Wisata: $this->nama</div>";
        echo "<div class='output-item'>Harga per Tiket: Rp" . number_format($this->harga, 0, ',', '.') . "</div>";
        echo "<div class='output-item'>Jumlah Tiket: $jumlah</div>";
        echo "<div class='output-item'>Total Harga: Rp" . number_format($this->hitungTotal($jumlah), 0, ',', '.') . "</div>";
    }
}