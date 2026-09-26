#include <string>
#include "RilisanFisik.cpp"

using namespace std;

class Vinyl : public RilisanFisik {
    private:
        string ukuran;
        string warna;
        string kondisi;

    public:
        Vinyl() : RilisanFisik() {
        }

        Vinyl(string idProduk, string namaProduk, int harga, string artis, string genre, int tahunRilis, string ukuran, string warna, string kondisi) 
            : RilisanFisik(idProduk, namaProduk, harga, artis, genre, tahunRilis) {
            this->ukuran = ukuran;
            this->warna = warna;
            this->kondisi = kondisi;
        }

        string getUkuran() {
            return ukuran;
        }

        void setUkuran(string ukuran) {
            this->ukuran = ukuran;
        }

        string getWarna() {
            return warna;
        }

        void setWarna(string warna) {
            this->warna = warna;
        }

        string getKondisi() {
            return kondisi;
        }

        void setKondisi(string kondisi) {
            this->kondisi = kondisi;
        }

        ~Vinyl() {
        }
};