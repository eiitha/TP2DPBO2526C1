from rilisan_fisik import RilisanFisik

class Vinyl(RilisanFisik):
    def __init__(self, id_produk="", nama_produk="", harga=0, artis="", genre="", tahun_rilis=0, ukuran="", warna="", kondisi=""):
        super().__init__(id_produk, nama_produk, harga, artis, genre, tahun_rilis)
        self._ukuran = ukuran
        self._warna = warna
        self._kondisi = kondisi

    def get_ukuran(self):
        return self._ukuran

    def set_ukuran(self, ukuran):
        self._ukuran = ukuran

    def get_warna(self):
        return self._warna

    def set_warna(self, warna):
        self._warna = warna

    def get_kondisi(self):
        return self._kondisi

    def set_kondisi(self, kondisi):
        self._kondisi = kondisi