import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.Scanner;
import java.util.regex.Pattern;

public class Main {

    public static void main(String[] args) {
        List<String> genres = Arrays.asList(
            "Rock", "Electronic", "Hip_Hop", "Pop", "Jazz", "Classical", "R&B", "Psychedelic",
            "Soul", "Blues", "Country", "Reggae", "Metal", "Folk", "Punk", "Disco", "Alternative"
        );

        List<Vinyl> listVinyl = new ArrayList<>();
        listVinyl.add(new Vinyl("V01", "The_Ballad_of_Darren", 550000, "Blur", "Indie_Rock", 2023, "12_inch", "Hitam", "Mint"));
        listVinyl.add(new Vinyl("V02", "Kid_A_Mnesia", 750000, "Radiohead", "Experimental_Rock", 2021, "12_inch", "Hitam", "Mint"));
        listVinyl.add(new Vinyl("V03", "Different_Class", 550000, "Pulp", "Britpop", 1995, "12_inch", "Hitam", "VG+"));
        listVinyl.add(new Vinyl("V04", "Urban_Hymns", 600000, "The_Verve", "Alternative_Rock", 1997, "12_inch", "Hitam", "Mint"));
        listVinyl.add(new Vinyl("V05", "Siamese_Dream", 700000, "The_Smashing_Pumpkins", "Alternative_Rock", 1993, "12_inch", "Hitam", "Mint"));

        Scanner scanner = new Scanner(System.in);

        System.out.println("====================================================");
        System.out.println("Vinyl Store Management System");
        System.out.println("====================================================\n");

        System.out.println("1. /add (ADD NEW VINYL)");
        System.out.println("2. /display (DISPLAY ALL VINYL)");
        System.out.println("3. /exit (EXIT)");

        System.out.println("\nEnter your command:");

        while (true) {
            System.out.print(">> ");
            if (!scanner.hasNextLine()) break;
            
            String command = scanner.nextLine().trim();

            if (command.equals("1") || command.equals("/add")) {
                addVinyl(listVinyl, genres, scanner);
            } else if (command.equals("2") || command.equals("/display")) {
                displayVinyls(listVinyl);
            } else if (command.equals("3") || command.equals("/exit")) {
                System.out.println("Exiting program...");
                System.exit(0);
            } else {
                System.out.println("\nInvalid command, try again!\n");
            }
        }
        
        scanner.close();
    }

    private static void displayVinyls(List<Vinyl> listVinyl) {
        if (listVinyl.isEmpty()) {
            System.out.println("Katalog kosong.\n");
            return;
        }

        List<List<String>> rows = new ArrayList<>();
        rows.add(Arrays.asList("No.", "ID Produk", "Nama Album", "Artis", "Genre", "Tahun Rilis", "Ukuran", "Warna Plat", "Kondisi", "Harga"));

        int vinylNumber = 1;
        for (Vinyl v : listVinyl) {
            rows.add(Arrays.asList(
                String.valueOf(vinylNumber++),
                v.getIdProduk(),
                v.getNamaProduk(),
                v.getArtis(),
                v.getGenre(),
                String.valueOf(v.getTahunRilis()),
                v.getUkuran(),
                v.getWarna(),
                v.getKondisi(),
                "Rp" + v.getHarga()
            ));
        }

        int[] columnWidths = calculateColumnWidths(rows);

        System.out.println("\nKatalog Toko Vinyl:");
        printTableBorder(columnWidths);
        printTableRow(rows.get(0), columnWidths); // Print Header
        printTableBorder(columnWidths);

        for (int i = 1; i < rows.size(); i++) {
            printTableRow(rows.get(i), columnWidths);
        }

        printTableBorder(columnWidths);
        System.out.println("Total koleksi vinyl: " + listVinyl.size() + "\n");
    }

    private static void addVinyl(List<Vinyl> listVinyl, List<String> genres, Scanner scanner) {
        System.out.print("\nID Produk: ");
        String id = scanner.nextLine().trim();

        while (true) {
            if (!Pattern.matches("^V\\d{2,}$", id)) {
                System.out.println("Format ID tidak valid. Harus diawali 'V' diikuti angka (contoh: V06).\n");
            } else {
                boolean idExists = false;
                for (Vinyl v : listVinyl) {
                    if (v.getIdProduk().equals(id)) {
                        idExists = true;
                        break;
                    }
                }

                if (!idExists) {
                    break;
                }
                System.out.println("ID Produk sudah ada. Silakan masukkan ID yang berbeda.\n");
            }
            System.out.print("ID Produk: ");
            id = scanner.nextLine().trim();
        }

        System.out.print("Nama Album: ");
        String nama = scanner.nextLine().trim();

        System.out.print("Artis: ");
        String artis = scanner.nextLine().trim();

        System.out.print("Genre: ");
        String genre = scanner.nextLine().trim();

        while (!genres.contains(genre)) {
            System.out.print("Genre tidak valid. Silakan pilih dari daftar berikut: [");
            System.out.print(String.join(", ", genres));
            System.out.println("]\n");
            
            System.out.print("Genre: ");
            genre = scanner.nextLine().trim();
        }

        System.out.print("Tahun Rilis: ");
        int tahun;
        while (true) {
            String tahunInput = scanner.nextLine().trim();
            if (!Pattern.matches("^\\d+$", tahunInput)) {
                System.out.println("Input tidak valid. Harap masukkan angka bulat positif.");
            } else {
                try {
                    tahun = Integer.parseInt(tahunInput);
                    if (tahun < 1900 || tahun > 2026) {
                        System.out.print("Tahun rilis tidak logis. Harap masukkan tahun antara 1900 - 2026.");
                    } else {
                        break;
                    }
                } catch (NumberFormatException e) {
                    System.out.print("Input tidak valid. Angka terlalu besar.");
                }
                System.out.println();
            }
            System.out.print("\nTahun Rilis: ");
        }

        System.out.print("Ukuran (contoh: 12_inch): ");
        String ukuran = scanner.nextLine().trim();

        System.out.print("Warna Plat: ");
        String warna = scanner.nextLine().trim();

        System.out.print("Kondisi (contoh: Mint, VG+): ");
        String kondisi = scanner.nextLine().trim();

        System.out.print("Harga (Rp): ");
        int harga;
        while (true) {
            String hargaInput = scanner.nextLine().trim();
            if (!Pattern.matches("^\\d+$", hargaInput)) {
                System.out.println("Input tidak valid. Harap masukkan angka bulat positif tanpa titik/koma.");
            } else {
                try {
                    harga = Integer.parseInt(hargaInput);
                    break;
                } catch (NumberFormatException e) {
                    System.out.print("Input tidak valid. Angka terlalu besar.");
                }
                System.out.println();
            }
            System.out.print("\nHarga (Rp): ");
        }

        Vinyl newVinyl = new Vinyl(id, nama, harga, artis, genre, tahun, ukuran, warna, kondisi);
        listVinyl.add(newVinyl);

        System.out.println("Data vinyl berhasil ditambahkan!\n");
    }

    private static int[] calculateColumnWidths(List<List<String>> rows) {
        int columns = rows.get(0).size();
        int[] columnWidths = new int[columns];

        for (List<String> row : rows) {
            for (int i = 0; i < columns; i++) {
                columnWidths[i] = Math.max(columnWidths[i], row.get(i).length());
            }
        }
        return columnWidths;
    }

    private static void printTableBorder(int[] columnWidths) {
        System.out.print("+");
        for (int width : columnWidths) {
            // Repeat '-' character (width + 2) times
            System.out.print(new String(new char[width + 2]).replace('\0', '-') + "+");
        }
        System.out.println();
    }

    private static void printTableRow(List<String> row, int[] columnWidths) {
        System.out.print("|");
        for (int i = 0; i < row.size(); i++) {
            // Left alignment equivalent to C++'s setw and left
            String format = " %-" + (columnWidths[i] + 1) + "s|";
            System.out.printf(format, row.get(i));
        }
        System.out.println();
    }
}