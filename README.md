# Janji
Saya Jillena Surbakti dengan NIM 2501485 mengerjakan Tugas Praktikum 2 pada Mata Kuliah Desain dan Pemrograman Berorientasi Objek (DPBO) untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

# Struktur File
```
TP2DPBO2526C1
├── CPP/
│   ├── program/
│   │   ├── main.cpp
│   │   ├── Produk.cpp
│   │   ├── RilisanFisik.cpp
│   │   ├── Vinyl.cpp
│   │   └── input.txt
│   │
│   └── dokumentasi/
│       ├── cpp1.png
│       ├── cpp2.png
│       └── cpp3.png
│
├── Java/
│   ├── program/
│   │   ├── Main.java
│   │   ├── Produk.java
│   │   ├── RilisanFisik.java
│   │   ├── Vinyl.java
│   │   └── input.txt
|   |
│   └── Dokumentasi/
│       ├── java1.png
│       ├── java2.png
│       └── java3.png
│
├── Python/
│   ├── program/
│   │   ├── main.py
│   │   ├── produk.py
│   │   ├── rilisan_fisik.py
│   │   ├── vinyl.py
│   │   └── input.txt
|   |
│   └── Dokumentasi/
│       ├── py1.png
│       ├── py2.png
│       └── py3.png
│
├── PHP/
│   ├── program/
│   │   ├── index.php
│   │   ├── Produk.cpp
│   │   ├── RilisanFisik.cpp
│   │   ├── Vinyl.cpp
│   │   └── input.txt
│   │
│   └── Dokumentasi/
│       ├── php1.png
│       ├── php2.png
│       ├── php3.png
│       └── php4.png
│
├── Diagram.png
└── README.md
```

# Diagram
<img width="1072" height="342" alt="Untitled Diagram drawio" src="https://github.com/user-attachments/assets/eb936be4-f28b-48ef-adf6-e6b4a1d956c2" />


# Penjelasan Desain
Ketiga class ini dihubungkan menggunakan konsep **inheritance** (pewarisan) untuk membagi data berdasarkan tingkat kekhususannya:
* **Produk**: Berperan sebagai class dasar (*parent class*) yang menyimpan atribut paling umum untuk seluruh barang, seperti ID, harga, stok, dan foto (khusus versi PHP).
* **RilisanFisik**: Mewarisi seluruh atribut dari class **Produk**, lalu menambahkan detail spesifik media musik seperti artis, genre, dan tahun rilis.
* **Vinyl**: Mewarisi atribut dari **Produk** dan **RilisanFisik**, serta melengkapinya dengan atribut khusus piringan hitam seperti ukuran, warna plat, dan kondisi.

Karena penerapan inheritance ini, objek **Vinyl** dapat secara langsung mengakses seluruh atribut dan *method* (*getter* & *setter*) dari kedua class induknya tanpa perlu mendefinisikannya ulang.

# Perintah yang tersedia pada C++, Java, dan Python:

| Perintah | Fungsi |
|---|---|
| `/add` | Menambahkan produk |
| `/display` | Menampilkan seluruh produk dalam bentuk tabel dinamis |
| `/exit` | Keluar dari program |

# Flow Code C++, Java, Python
Penjelasan alur jalannya program (**Flow Code**):
1. **Inisialisasi Data Awal**
Program mengimpor class `Vinyl` (yang mewarisi `RilisanFisik` dan `Produk`). Saat dijalankan, program membuat daftar (*list*) penampung bernama `list_vinyl` yang diisi dengan 5 data awal *vinyl* secara *hardcode* (seperti Blur, Radiohead, Pulp, dll).
2. **Loop Membaca Perintah**
Program menampilkan daftar perintah dasar, kemudian masuk ke dalam perulangan utama (`while True`) untuk membaca input dari pengguna secara terus-menerus hingga perintah keluar dipanggil.
3. **Parsing & Case-Insensitive**
Input baris dari pengguna dipisah kata-katanya (`split()`). Kata pertama diambil sebagai perintah utama dan diubah menjadi huruf kecil semua (`lower()`) agar bersifat *case-insensitive* (dapat menerima `ADD`, `Add`, maupun `add`).
4. **Eksekusi Perintah**
* **`add / 1`**: Mengambil sisa argumen input, melakukan validasi format (format ID `'V..'`, genre terdaftar, tahun rilis $1900-2026$, serta harga/stok berupa angka). Jika valid, objek `Vinyl` baru dibuat dan dimasukkan ke `list_vinyl`.
* **`display / 2`**: Mengecek isi `list_vinyl`. Jika kosong, menampilkan pesan bahwa katalog kosong. Jika ada, program menghitung lebar maksimum tiap kolom secara otomatis dan mencetak tabel data dinamis.
* **`exit / 3`**: Menghentikan perulangan `while` dan mengakhiri eksekusi program.

# Penanganan Error Handling
Penjelasan mekanisme **Error Handling** yang diterapkan di dalam program:

* **Validasi Perintah Utama (Command Validation)**
* **Kondisi:** Pengguna memasukkan perintah yang tidak terdaftar di sistem (seperti `remove 6` atau `delete`).
* **Penanganan:** Program tidak akan *crash*, melainkan menampilkan pesan error (misalnya `Invalid command, try again!`) lalu kembali menampilkan *prompt* input.


* **Validasi Format & Duplikasi ID Produk**
* **Format Salah:** ID wajib diawali huruf `'V'` dan diikuti digit angka (misalnya `V06`). Jika format tidak sesuai, program menolak input dan meminta pengguna mengisi ulang.
* **Duplikasi ID:** Program mengecek katalog secara dinamis. Jika ID yang diinput sudah digunakan oleh vinyl lain (misalnya `V01`), sistem menampilkan pesan bahwa ID sudah ada.


* **Validasi Genre Musik**
* **Kondisi:** Pengguna menginput genre yang tidak ada dalam daftar genre resmi (misalnya `Dangdut`).
* **Penanganan:** Program mengecek input terhadap daftar genre yang diizinkan. Jika tidak cocok, program menampilkan opsi genre yang valid dan meminta input ulang.


* **Validasi Tahun Rilis**
* **Tipe Data:** Memastikan input berupa angka bulat positif (tanpa huruf atau karakter spesial).
* **Batas Logis:** Membatasi tahun rilis pada rentang yang masuk akal ($1900 - 2026$). Jika pengguna menginput tahun seperti `1850` atau `2030`, program akan menampilkan pesan error.


* **Validasi Harga & Stok (Tipe Data & Exception Handling)**
* **Format Input:** Memastikan input berupa angka murni tanpa simbol Rp, titik, atau koma.
* **Exception Handling (`try-catch` / `try-except`):** Mengantisipasi kesalahan konversi teks ke angka (`invalid_argument` / `ValueError`) serta angka yang terlalu besar hingga melebihi batas simpan tipe data integer (`out_of_range`).


* **Validasi Kelengkapan Argumen Input**
* **Kondisi:** Jumlah parameter pada perintah `add` kurang dari yang dibutuhkan (misalnya lupa memasukkan warna atau kondisi).
* **Penanganan:** Program mengecek kelengkapan data sebelum menginstansiasi objek `Vinyl`. Jika argumen tidak lengkap, proses penambahan dibatalkan dan pengguna diberi tahu format yang benar.


* **Penanganan Katalog Kosong (`show`)**
* **Kondisi:** Perintah `show` dipanggil saat belum ada data vinyl sama sekali.
* **Penanganan:** Program melakukan pengecekan `empty` pada list/vector penampung, kemudian menampilkan pesan bahwa katalog kosong tanpa membuat tampilan tabel rusak.

# Flow Code PHP
Penjelasan alur jalannya program (**Flow Code**) **PHP**:

* **Inisialisasi Session & Data Awal (State Management)**
Saat halaman `index.php` diakses, program menjalankan `session_start()`. Program mengecek apakah data katalog di `$_SESSION['vinyls']` dan log terminal di `$_SESSION['log']` sudah ada. Jika belum ada atau tidak valid, program menginstansiasi 5 objek awal `Vinyl` (Blur, Radiohead, Pulp, The Verve, The Smashing Pumpkins) dengan path gambar lokal serta menambahkan log sambutan awal.
* **Penerimaan & Parsing Perintah (Form Handling)**
Ketika pengguna menginput perintah di form web-terminal dan menekan tombol EXECUTE, form mengirimkan permintaan via metode `POST` ke `index.php`. Program memotong string perintah berdasarkan spasi (`preg_split`) untuk mengambil kata kunci perintah utama (`$cmd`) dan argumen pendukungnya (`$tokens`).
* **Pemrosesan Perintah & Validasi Data**
Program mengecek nilai `$cmd`:
1. **`add`**: Memanggil fungsi `addVinyl()`. Fungsi mengecek kelengkapan 10 parameter (*ID, Nama, Harga, Artis, Genre, Tahun, Ukuran, Warna, Kondisi, Foto*). Dilakukan validasi format ID (`V..`), pengecekan ID unik, validasi genre terdaftar, serta konversi angka untuk tahun (1900–2026) dan harga. Jika valid, objek `Vinyl` baru dibuat dan dimasukkan ke `$_SESSION['vinyls']`.
2. **`display`**: Menghitung jumlah elemen pada `$_SESSION['vinyls']` dan menghasilkan status pesan katalog.
3. **`panduan`**: Memanggil fungsi `panduanText()` yang mengembalikan daftar format perintah yang tersedia.
4. **`exit`**: Mengembalikan pesan penutup sesi.
5. **Perintah Lain**: Mengembalikan pesan error bahwa perintah tidak dikenal.


* **Penerapan PRG Pattern (Post-Redirect-Get)**
Setelah perintah selesai diproses dan hasilnya disimpan ke dalam log `$_SESSION['log']`, program melakukan *redirect* menggunakan `header("Location: index.php")` lalu menghentikan skrip (`exit`). Hal ini mencegah terjadinya pengiriman ulang perintah secara tidak sengaja saat pengguna melakukan *refresh* halaman.
* **Rendering Tampilan Web Terminal & Tabel Katalog**
Program merender HTML yang terdiri dari dua komponen utama:
1. **Web Terminal Console**: Membaca seluruh riwayat transaksi di `$_SESSION['log']` dan menyajikannya dalam tampilan gaya CLI Terminal.
2. **Tabel Katalog Dynamic**: Melakukan *looping* pada `$_SESSION['vinyls']` untuk menampilkan daftar piringan hitam lengkap dengan thumbnail gambar, ID, nama album, artis, genre, tahun rilis, spesifikasi fisik, kondisi, serta format harga.

# Dokumentasi
## Dokumentasi C++
### ADD
<img width="530" height="473" alt="add" src="https://github.com/user-attachments/assets/9cc939b5-b03c-408c-bb1f-b74e24a69bea" />
### Display
<img width="1461" height="489" alt="display" src="https://github.com/user-attachments/assets/b546c96d-f216-44e2-93f6-05466bea2790" />
## Dokumentasi Java
### ADD
<img width="627" height="375" alt="add" src="https://github.com/user-attachments/assets/ef909ad8-87db-48a4-a34b-18b8432bb208" />
### Display
<img width="1219" height="227" alt="display" src="https://github.com/user-attachments/assets/6b68b9a7-c037-4bb0-8773-46c0c6a2d710" />

## Dokumentasi Python
### ADD
<img width="543" height="500" alt="add" src="https://github.com/user-attachments/assets/bb02e933-8f1e-414d-831f-a7c051d6536d" />
### Display
<img width="1319" height="499" alt="display" src="https://github.com/user-attachments/assets/37039016-b7e9-4df5-b818-95e932a0170e" />
## Dokumentasi PHP
### Panduan
<img width="1462" height="370" alt="panduan" src="https://github.com/user-attachments/assets/12e5c104-5ede-4ee4-bb92-75dbba7d3eac" />
### Display
<img width="1920" height="1017" alt="display" src="https://github.com/user-attachments/assets/9a23b62c-4f77-46fb-ba24-4773d09bedec" />
### ADD
<img width="1920" height="1023" alt="add" src="https://github.com/user-attachments/assets/41c8f7ae-3250-4312-bc61-c0e086e0372d" />
