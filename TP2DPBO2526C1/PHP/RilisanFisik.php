<?php
require_once 'Produk.php';

class RilisanFisik extends Produk {
    protected $artis;
    protected $genre;
    protected $tahunRilis;

    public function __construct($idProduk = "", $namaProduk = "", $harga = 0, $artis = "", $genre = "", $tahunRilis = 0) {
        parent::__construct($idProduk, $namaProduk, $harga);
        $this->artis = $artis;
        $this->genre = $genre;
        $this->tahunRilis = $tahunRilis;
    }

    public function getArtis() {
        return $this->artis;
    }

    public function setArtis($artis) {
        $this->artis = $artis;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function setGenre($genre) {
        $this->genre = $genre;
    }

    public function getTahunRilis() {
        return $this->tahunRilis;
    }

    public function setTahunRilis($tahunRilis) {
        $this->tahunRilis = $tahunRilis;
    }
}