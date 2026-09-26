<?php
require_once 'RilisanFisik.php';

class Vinyl extends RilisanFisik {
    private $ukuran;
    private $warna;
    private $kondisi;
    private $foto;

    public function __construct($idProduk = "", $namaProduk = "", $harga = 0, $artis = "", $genre = "", $tahunRilis = 0, $ukuran = "", $warna = "", $kondisi = "", $foto = "") {
        parent::__construct($idProduk, $namaProduk, $harga, $artis, $genre, $tahunRilis);
        $this->ukuran = $ukuran;
        $this->warna = $warna;
        $this->kondisi = $kondisi;
        $this->foto = $foto;
    }

    public function getUkuran() {
        return $this->ukuran;
    }

    public function setUkuran($ukuran) {
        $this->ukuran = $ukuran;
    }

    public function getWarna() {
        return $this->warna;
    }

    public function setWarna($warna) {
        $this->warna = $warna;
    }

    public function getKondisi() {
        return $this->kondisi;
    }

    public function setKondisi($kondisi) {
        $this->kondisi = $kondisi;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }
}