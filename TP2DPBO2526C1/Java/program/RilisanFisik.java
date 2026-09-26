public class RilisanFisik extends Produk {
    protected String artis;
    protected String genre;
    protected int tahunRilis;

    public RilisanFisik() {
        super();
    }

    public RilisanFisik(String idProduk, String namaProduk, int harga, String artis, String genre, int tahunRilis) {
        super(idProduk, namaProduk, harga);
        this.artis = artis;
        this.genre = genre;
        this.tahunRilis = tahunRilis;
    }

    public String getArtis() {
        return artis;
    }

    public void setArtis(String artis) {
        this.artis = artis;
    }

    public String getGenre() {
        return genre;
    }

    public void setGenre(String genre) {
        this.genre = genre;
    }

    public int getTahunRilis() {
        return tahunRilis;
    }

    public void setTahunRilis(int tahunRilis) {
        this.tahunRilis = tahunRilis;
    }
}