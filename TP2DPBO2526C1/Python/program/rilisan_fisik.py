from produk import Produk

class RilisanFisik(Produk):
    def __init__(self, id_produk="", nama_produk="", harga=0, artis="", genre="", tahun_rilis=0):
        super().__init__(id_produk, nama_produk, harga)
        self._artis = artis
        self._genre = genre
        self._tahun_rilis = tahun_rilis

    def get_artis(self):
        return self._artis

    def set_artis(self, artis):
        self._artis = artis

    def get_genre(self):
        return self._genre

    def set_genre(self, genre):
        self._genre = genre

    def get_tahun_rilis(self):
        return self._tahun_rilis

    def set_tahun_rilis(self, tahun_rilis):
        self._tahun_rilis = tahun_rilis