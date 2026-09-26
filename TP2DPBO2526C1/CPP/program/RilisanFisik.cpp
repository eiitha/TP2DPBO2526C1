#include <string>
#include "Produk.cpp"

using namespace std;

class RilisanFisik : public Produk {
    protected:
        string artis;
        string genre;
        int tahunRilis;

    public:
        RilisanFisik() : Produk() {
        }

        RilisanFisik(string idProduk, string namaProduk, int harga, string artis, string genre, int tahunRilis) 
            : Produk(idProduk, namaProduk, harga) {
            this->artis = artis;
            this->genre = genre;
            this->tahunRilis = tahunRilis;
        }

        string getArtis() {
            return artis;
        }

        void setArtis(string artis) {
            this->artis = artis;
        }

        string getGenre() {
            return genre;
        }

        void setGenre(string genre) {
            this->genre = genre;
        }

        int getTahunRilis() {
            return tahunRilis;
        }

        void setTahunRilis(int tahunRilis) {
            this->tahunRilis = tahunRilis;
        }

        ~RilisanFisik() {
        }
};