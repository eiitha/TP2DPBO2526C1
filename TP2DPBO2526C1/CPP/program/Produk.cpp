#include <string>

using namespace std;

class Produk {
    protected:
        string idProduk;
        string namaProduk;
        int harga;

    public:
        Produk() {
        }

        Produk(string idProduk, string namaProduk, int harga) {
            this->idProduk = idProduk;
            this->namaProduk = namaProduk;
            this->harga = harga;
        }

        string getIdProduk() {
            return idProduk;
        }

        void setIdProduk(string idProduk) {
            this->idProduk = idProduk;
        }

        string getNamaProduk() {
            return namaProduk;
        }

        void setNamaProduk(string namaProduk) {
            this->namaProduk = namaProduk;
        }

        int getHarga() {
            return harga;
        }

        void setHarga(int harga) {
            this->harga = harga;
        }

        ~Produk() {
        }
};