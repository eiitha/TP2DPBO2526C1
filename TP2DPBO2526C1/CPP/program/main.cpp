#include <iostream>
#include <string>
#include <vector>
#include <regex>
#include <algorithm>
#include <stdexcept>
#include <iomanip>
#include <sstream>
#include "Vinyl.cpp"

using namespace std;

void displayVinyls(vector<Vinyl>& listVinyl);
void addVinyl(vector<Vinyl>& listVinyl, const vector<string>& genres);
vector<size_t> calculateColumnWidths(const vector<vector<string>>& rows);
void printTableBorder(const vector<size_t>& columnWidths);
void printTableHeader(const vector<size_t>& columnWidths);
void printTableRow(const vector<string>& row, const vector<size_t>& columnWidths);

int main() {
    const vector<string> genres = {
        "Rock", "Electronic", "Hip_Hop", "Pop", "Jazz", "Classical", "R&B", "Psychedelic",
        "Soul", "Blues", "Country", "Reggae", "Metal", "Folk", "Punk", "Disco", "Alternative"
    };

    vector<Vinyl> listVinyl = {
        Vinyl("V01", "The_Ballad_of_Darren", 550000, "Blur", "Indie_Rock", 2023, "12_inch", "Hitam", "Mint"),
        Vinyl("V02", "Kid_A_Mnesia", 750000, "Radiohead", "Experimental_Rock", 2021, "12_inch", "Hitam", "Mint"),
        Vinyl("V03", "Different_Class", 550000, "Pulp", "Britpop", 1995, "12_inch", "Hitam", "VG+"),
        Vinyl("V04", "Urban_Hymns", 600000, "The_Verve", "Alternative_Rock", 1997, "12_inch", "Hitam", "Mint"),
        Vinyl("V05", "Siamese_Dream", 700000, "The_Smashing_Pumpkins", "Alternative_Rock", 1993, "12_inch", "Hitam", "Mint")
    };
    
    cout << "====================================================\n";
    cout << "Vinyl Store Management System\n";
    cout << "====================================================\n\n";

    cout << "1. /add (ADD NEW VINYL)\n";
    cout << "2. /display (DISPLAY ALL VINYL)\n";
    cout << "3. /exit (EXIT)\n";

    cout << "\nEnter your command:\n";

    while (true) {
        cout << ">> ";
        string command;
        getline(cin, command);

        if (command == "1" || command == "/add") {
            addVinyl(listVinyl, genres);
        } 
        else if (command == "2" || command == "/display") {
            displayVinyls(listVinyl);
        } 
        else if (command == "3" || command == "/exit") {
            cout << "Exiting program...\n";
            exit(0);
        } 
        else {
            cout << "\nInvalid command, try again!\n";
        }
    }

    return 0;
}

vector<size_t> calculateColumnWidths(const vector<vector<string>>& rows) {
    vector<size_t> columnWidths(rows.front().size(), 0); 

    for (const vector<string>& row : rows) { 
        for (size_t column = 0; column < row.size(); ++column) { 
            columnWidths[column] = max(columnWidths[column], row[column].length()); 
        }
    }

    return columnWidths;
}

void printTableBorder(const vector<size_t>& columnWidths) {
    cout << "+";

    for (size_t width : columnWidths) { 
        cout << string(width + 2, '-') << "+"; 
    }

    cout << '\n';
}

void printTableHeader(const vector<size_t>& columnWidths) {
    const vector<string> headers = {
        "No.", "ID Produk", "Nama Album", "Artis", "Genre", "Tahun Rilis", "Ukuran", "Warna Plat", "Kondisi", "Harga" 
    };

    printTableRow(headers, columnWidths);
}

void printTableRow(const vector<string>& row, const vector<size_t>& columnWidths) {
    cout << "|";

    for (size_t column = 0; column < row.size(); ++column) {
        cout << ' ' << left << setw(static_cast<int>(columnWidths[column] + 1)) << row[column] << "|" ;
    }

    cout << '\n';
}

void displayVinyls(vector<Vinyl>& listVinyl) {
    if (listVinyl.empty()) {
        cout << "Katalog kosong.\n\n";
        return;
    }

    vector<vector<string>> rows = {
        {"No.", "ID Produk", "Nama Album", "Artis", "Genre", "Tahun Rilis", "Ukuran", "Warna Plat", "Kondisi", "Harga"} 
    };
    
    int vinylNumber = 1;

    for (Vinyl& v : listVinyl) {
        rows.push_back({ 
            to_string(vinylNumber++), 
            v.getIdProduk(), 
            v.getNamaProduk(), 
            v.getArtis(),
            v.getGenre(), 
            to_string(v.getTahunRilis()), 
            v.getUkuran(), 
            v.getWarna(), 
            v.getKondisi(),
            "Rp" + to_string(v.getHarga())
        });
    }

    const vector<size_t> columnWidths = calculateColumnWidths(rows);

    cout << "\nKatalog Toko Vinyl:\n";

    printTableBorder(columnWidths);
    printTableHeader(columnWidths);
    printTableBorder(columnWidths);
    
    for (size_t row = 1; row < rows.size(); ++row) {
        printTableRow(rows[row], columnWidths);
    }
    
    printTableBorder(columnWidths);

    cout << "Total koleksi vinyl: " << listVinyl.size() << "\n\n";
}

void addVinyl(vector<Vinyl>& listVinyl, const vector<string>& genres) {
    cout << "\nID Produk: ";
    string id;
    getline(cin, id);
    
    while (true) {
        if (!regex_match(id, regex("^V\\d{2,}$"))) {
            cout << "Format ID tidak valid. Harus diawali 'V' diikuti angka (contoh: V06).\n\n";
        }
        else {
            bool idExists = false;
            for (Vinyl& v : listVinyl) {
                if (v.getIdProduk() == id) {
                    idExists = true;
                    break;
                }
            }

            if (!idExists) {
                break;
            }

            cout << "ID Produk sudah ada. Silakan masukkan ID yang berbeda.\n\n";
        }

        cout << "ID Produk: ";
        getline(cin, id);
    }

    cout << "Nama Album: ";
    string nama;
    getline(cin, nama);

    cout << "Artis: ";
    string artis;
    getline(cin, artis);

    cout << "Genre: ";
    string genre;
    getline(cin, genre);
    
    while (find(genres.begin(), genres.end(), genre) == genres.end()) {
        cout << "Genre tidak valid. Silakan pilih dari daftar berikut: [";
        for (size_t i = 0; i < genres.size(); ++i) {
            if (i > 0) {
                cout << ", ";
            }
            cout << genres[i];
        }
        cout << "]\n\n";
        cout << "Genre: ";
        getline(cin, genre);
    }

    cout << "Tahun Rilis: ";
    int tahun;
    while (true) {
        string tahunInput;
        getline(cin, tahunInput);
        tahunInput = tahunInput.substr(0, tahunInput.find_last_not_of(" \t\r\n") + 1);
        
        if (!regex_match(tahunInput, regex("^\\d+$"))) {
            cout << "Input tidak valid. Harap masukkan angka bulat positif.\n";
        }
        else {
            try {
                tahun = stoi(tahunInput);
                if (tahun < 1900 || tahun > 2026) {
                    cout << "Tahun rilis tidak logis. Harap masukkan tahun antara 1900 - 2026.";
                }
                else {
                    break;
                }
            }
            catch (const invalid_argument&) {
                cout << "Input tidak valid. Bukan angka.";
            }
            catch (const out_of_range&) {
                cout << "Input tidak valid. Angka terlalu besar.";
            }
            cout << '\n';
        }
        cout << "\nTahun Rilis: ";
    }

    cout << "Ukuran (contoh: 12_inch): ";
    string ukuran;
    getline(cin, ukuran);

    cout << "Warna Plat: ";
    string warna;
    getline(cin, warna);

    cout << "Kondisi (contoh: Mint, VG+): ";
    string kondisi;
    getline(cin, kondisi);

    cout << "Harga (Rp): ";
    int harga;
    while (true) {
        string hargaInput;
        getline(cin, hargaInput);
        hargaInput = hargaInput.substr(0, hargaInput.find_last_not_of(" \t\r\n") + 1);
        
        if (!regex_match(hargaInput, regex("^\\d+$"))) {
            cout << "Input tidak valid. Harap masukkan angka bulat positif tanpa titik/koma.\n";
        }
        else {
            try {
                harga = stoi(hargaInput);
                break;
            }
            catch (const invalid_argument&) {
                cout << "Input tidak valid. Bukan angka.";
            }
            catch (const out_of_range&) {
                cout << "Input tidak valid. Angka terlalu besar.";
            }
            cout << '\n';
        }
        cout << "\nHarga (Rp): ";
    }

    Vinyl newVinyl(id, nama, harga, artis, genre, tahun, ukuran, warna, kondisi);
    
    listVinyl.push_back(newVinyl);
    
    cout << "Data vinyl berhasil ditambahkan!\n\n";
}