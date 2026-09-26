public class Vinyl extends RilisanFisik {
    private String ukuran;
    private String warna;
    private String kondisi;

    public Vinyl() {
        super();
    }

    public Vinyl(String idProduk, String namaProduk, int harga, String artis, String genre, int tahunRilis, String ukuran, String warna, String kondisi) {
        super(idProduk, namaProduk, harga, artis, genre, tahunRilis);
        this.ukuran = ukuran;
        this.warna = warna;
        this.kondisi = kondisi;
    }

    public String getUkuran() {
        return ukuran;
    }

    public void setUkuran(String ukuran) {
        this.ukuran = ukuran;
    }

    public String getWarna() {
        return warna;
    }

    public void setWarna(String warna) {
        this.warna = warna;
    }

    public String getKondisi() {
        return kondisi;
    }

    public void setKondisi(String kondisi) {
        this.kondisi = kondisi;
    }
}