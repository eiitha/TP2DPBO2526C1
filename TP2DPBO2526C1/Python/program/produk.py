class Produk:
    def __init__(self, id_produk="", nama_produk="", harga=0):
        self._id_produk = id_produk
        self._nama_produk = nama_produk
        self._harga = harga

    def get_id_produk(self):
        return self._id_produk

    def set_id_produk(self, id_produk):
        self._id_produk = id_produk

    def get_nama_produk(self):
        return self._nama_produk

    def set_nama_produk(self, nama_produk):
        self._nama_produk = nama_produk

    def get_harga(self):
        return self._harga

    def set_harga(self, harga):
        self._harga = harga