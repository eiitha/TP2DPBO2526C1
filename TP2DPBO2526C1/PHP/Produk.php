<?php

class Produk {
    protected $idProduk;
    protected $namaProduk;
    protected $harga;

    public function __construct($idProduk = "", $namaProduk = "", $harga = 0) {
        $this->idProduk = $idProduk;
        $this->namaProduk = $namaProduk;
        $this->harga = $harga;
    }

    public function getIdProduk() {
        return $this->idProduk;
    }

    public function setIdProduk($idProduk) {
        $this->idProduk = $idProduk;
    }

    public function getNamaProduk() {
        return $this->namaProduk;
    }

    public function setNamaProduk($namaProduk) {
        $this->namaProduk = $namaProduk;
    }

    public function getHarga() {
        return $this->harga;
    }

    public function setHarga($harga) {
        $this->harga = $harga;
    }
}