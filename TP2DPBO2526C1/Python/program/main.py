import sys
import re
from vinyl import Vinyl

def calculate_column_widths(rows):
    if not rows:
        return []
    columns = len(rows[0])
    widths = [0] * columns
    for row in rows:
        for i in range(columns):
            widths[i] = max(widths[i], len(str(row[i])))
    return widths

def print_table_border(widths):
    border = "+"
    for width in widths:
        border += "-" * (width + 2) + "+"
    print(border)

def print_table_row(row, widths):
    row_str = "|"
    for i in range(len(row)):
        # Format string agar rata kiri seperti setw(width) dan left di C++
        row_str += f" {str(row[i]):<{widths[i]}} |"
    print(row_str)

def display_vinyls(list_vinyl):
    if not list_vinyl:
        print("Katalog kosong.\n")
        return

    rows = [["No.", "ID Produk", "Nama Album", "Artis", "Genre", "Tahun Rilis", "Ukuran", "Warna Plat", "Kondisi", "Harga"]]
    
    for idx, v in enumerate(list_vinyl, start=1):
        rows.append([
            str(idx),
            v.get_id_produk(),
            v.get_nama_produk(),
            v.get_artis(),
            v.get_genre(),
            str(v.get_tahun_rilis()),
            v.get_ukuran(),
            v.get_warna(),
            v.get_kondisi(),
            f"Rp{v.get_harga()}"
        ])

    widths = calculate_column_widths(rows)

    print("\nKatalog Toko Vinyl:")
    print_table_border(widths)
    print_table_row(rows[0], widths) # Print Header
    print_table_border(widths)
    
    for row in rows[1:]:
        print_table_row(row, widths)
        
    print_table_border(widths)
    print(f"Total koleksi vinyl: {len(list_vinyl)}\n")

def add_vinyl(list_vinyl, genres):
    print("\nID Produk: ", end="")
    id_input = input().strip()
    
    while True:
        if not re.match(r"^V\d{2,}$", id_input):
            print("Format ID tidak valid. Harus diawali 'V' diikuti angka (contoh: V06).\n")
        else:
            id_exists = any(v.get_id_produk() == id_input for v in list_vinyl)
            if not id_exists:
                break
            print("ID Produk sudah ada. Silakan masukkan ID yang berbeda.\n")
            
        print("ID Produk: ", end="")
        id_input = input().strip()

    print("Nama Album: ", end="")
    nama = input().strip()

    print("Artis: ", end="")
    artis = input().strip()

    print("Genre: ", end="")
    genre = input().strip()

    while genre not in genres:
        print(f"Genre tidak valid. Silakan pilih dari daftar berikut: [{', '.join(genres)}]\n")
        print("Genre: ", end="")
        genre = input().strip()

    print("Tahun Rilis: ", end="")
    while True:
        tahun_input = input().strip()
        if not re.match(r"^\d+$", tahun_input):
            print("Input tidak valid. Harap masukkan angka bulat positif.")
        else:
            tahun = int(tahun_input)
            if tahun < 1900 or tahun > 2026:
                print("Tahun rilis tidak logis. Harap masukkan tahun antara 1900 - 2026.", end="")
            else:
                break
        print("\nTahun Rilis: ", end="")

    print("Ukuran (contoh: 12_inch): ", end="")
    ukuran = input().strip()

    print("Warna Plat: ", end="")
    warna = input().strip()

    print("Kondisi (contoh: Mint, VG+): ", end="")
    kondisi = input().strip()

    print("Harga (Rp): ", end="")
    while True:
        harga_input = input().strip()
        if not re.match(r"^\d+$", harga_input):
            print("Input tidak valid. Harap masukkan angka bulat positif tanpa titik/koma.")
        else:
            harga = int(harga_input)
            break
        print("\nHarga (Rp): ", end="")

    new_vinyl = Vinyl(id_input, nama, harga, artis, genre, tahun, ukuran, warna, kondisi)
    list_vinyl.append(new_vinyl)
    print("Data vinyl berhasil ditambahkan!\n")

def main():
    genres = [
        "Rock", "Electronic", "Hip_Hop", "Pop", "Jazz", "Classical", "R&B", "Psychedelic",
        "Soul", "Blues", "Country", "Reggae", "Metal", "Folk", "Punk", "Disco", "Alternative"
    ]

    list_vinyl = [
        Vinyl("V01", "The_Ballad_of_Darren", 550000, "Blur", "Indie_Rock", 2023, "12_inch", "Hitam", "Mint"),
        Vinyl("V02", "Kid_A_Mnesia", 750000, "Radiohead", "Experimental_Rock", 2021, "12_inch", "Hitam", "Mint"),
        Vinyl("V03", "Different_Class", 550000, "Pulp", "Britpop", 1995, "12_inch", "Hitam", "VG+"),
        Vinyl("V04", "Urban_Hymns", 600000, "The_Verve", "Alternative_Rock", 1997, "12_inch", "Hitam", "Mint"),
        Vinyl("V05", "Siamese_Dream", 700000, "The_Smashing_Pumpkins", "Alternative_Rock", 1993, "12_inch", "Hitam", "Mint")
    ]

    print("====================================================")
    print("Vinyl Store Management System")
    print("====================================================\n")
    print("1. /add (ADD NEW VINYL)")
    print("2. /display (DISPLAY ALL VINYL)")
    print("3. /exit (EXIT)")
    print("\nEnter your command:")

    while True:
        command = input(">> ").strip()

        if command in ("1", "/add"):
            add_vinyl(list_vinyl, genres)
        elif command in ("2", "/display"):
            display_vinyls(list_vinyl)
        elif command in ("3", "/exit"):
            print("Exiting program...")
            sys.exit(0)
        else:
            print("\nInvalid command, try again!\n")

if __name__ == "__main__":
    main()