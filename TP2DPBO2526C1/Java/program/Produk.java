public class Produk {
    protected String idProduk;
    protected String namaProduk;
    protected int harga;

    public Produk() {
    }

    public Produk(String idProduk, String namaProduk, int harga) {
        this.idProduk = idProduk;
        this.namaProduk = namaProduk;
        this.harga = harga;
    }

    public String getIdProduk() {
        return idProduk;
    }

    public void setIdProduk(String idProduk) {
        this.idProduk = idProduk;
    }

    public String getNamaProduk() {
        return namaProduk;
    }

    public void setNamaProduk(String namaProduk) {
        this.namaProduk = namaProduk;
    }

    public int getHarga() {
        return harga;
    }

    public void setHarga(int harga) {
        this.harga = harga;
    }
}