<?php
require_once 'Produk.php';
require_once 'RilisanFisik.php';
require_once 'Vinyl.php';
session_start();

// ============ daftar genre yang diizinkan ============
function getAllowedGenres() {
    return [
        "Rock", "Electronic", "Hip_Hop", "Pop", "Jazz", "Classical", "R&B", "Psychedelic",
        "Soul", "Blues", "Country", "Reggae", "Metal", "Folk", "Punk", "Disco", "Alternative",
        "Indie_Rock", "Experimental_Rock", "Britpop", "Alternative_Rock"
    ];
}

// ============ helper: data awal vinyl (Path Lokal) ============
function defaultVinyls() {
    return [
        new Vinyl("V01", "The_Ballad_of_Darren", 550000, "Blur", "Indie_Rock", 2023, "12_inch", "Hitam", "Mint", "images/the_ballad_of_darren.jpg"),
        new Vinyl("V02", "Kid_A_Mnesia", 750000, "Radiohead", "Experimental_Rock", 2021, "12_inch", "Hitam", "Mint", "images/kid_a_mnesia.jpg"),
        new Vinyl("V03", "Different_Class", 550000, "Pulp", "Britpop", 1995, "12_inch", "Hitam", "VG+", "images/different_class.jpg"),
        new Vinyl("V04", "Urban_Hymns", 600000, "The_Verve", "Alternative_Rock", 1997, "12_inch", "Hitam", "Mint", "images/urban_hymns.jpg"),
        new Vinyl("V05", "Siamese_Dream", 700000, "The_Smashing_Pumpkins", "Alternative_Rock", 1993, "12_inch", "Hitam", "Mint", "images/siamese_dream.jpg")
    ];
}

// helper: cek apakah data vinyl di session masih valid
function isValidVinylList($list) {
    if (!is_array($list)) return false;
    foreach ($list as $item) {
        if (!($item instanceof Vinyl)) return false;
    }
    return true;
}

if (!isset($_SESSION['vinyls']) || !isValidVinylList($_SESSION['vinyls'])) {
    $_SESSION['vinyls'] = defaultVinyls();
}

if (!isset($_SESSION['log'])) {
    $_SESSION['log'] = [
        ["type" => "info", "text" => ">>> VINYL STORE COMMAND CONSOLE [v3.0]\nKetik 'panduan' untuk melihat petunjuk perintah."]
    ];
}

// ============ prosedur panduan ============
function panduanText() {
    $rows = [
        ["add", "add (id) (namaAlbum) (harga) (artis) (genre) (tahunRilis) (ukuran) (warna) (kondisi) (foto)", "Menambahkan vinyl baru."],
        ["show", "show ATAU /display", "Menampilkan seluruh koleksi."],
        ["panduan", "panduan", "Menampilkan panduan ini."],
        ["done", "done ATAU /exit", "Mereset log tampilan."]
    ];
    $out = "DAFTAR PERINTAH SISTEM:\n";
    foreach ($rows as $r) {
        $out .= "• " . str_pad($r[0], 8) . " -> " . $r[1] . "\n  (" . $r[2] . ")\n";
    }
    $out .= "\nCatatan: (foto) diisi path file gambar lokal (contoh: images/blur.jpg).";
    return $out;
}

// ============ prosedur menambahkan vinyl ============
function addVinyl(&$v, $tokens) {
    if (count($tokens) < 10) {
        return "[ERROR] Format salah! Gunakan: add (id) (namaAlbum) (harga) (artis) (genre) (tahunRilis) (ukuran) (warna) (kondisi) (foto)";
    }

    list($id, $nama, $hargaInput, $artis, $genre, $tahunInput, $ukuran, $warna, $kondisi, $foto) = $tokens;

    if (!preg_match('/^V\d{2,}$/i', $id)) {
        return "[ERROR] ID tidak valid! Harus diawali 'V' dan diikuti angka (contoh: V06).";
    }

    foreach ($v as $item) {
        if (strcasecmp($item->getIdProduk(), $id) === 0) {
            return "[ERROR] ID '$id' sudah terdaftar!";
        }
    }

    $allowedGenres = getAllowedGenres();
    if (!in_array($genre, $allowedGenres)) {
        return "[ERROR] Genre '$genre' tidak valid!\nPilihan genre: [" . implode(", ", $allowedGenres) . "]";
    }

    if (!preg_match('/^\d+$/', $tahunInput) || !preg_match('/^\d+$/', $hargaInput)) {
        return "[ERROR] Tahun rilis dan harga harus berupa angka positif!";
    }

    $tahun = (int)$tahunInput;
    $harga = (int)$hargaInput;

    if ($tahun < 1900 || $tahun > 2026) {
        return "[ERROR] Tahun rilis harus antara 1900 - 2026.";
    }

    $newVinyl = new Vinyl($id, $nama, $harga, $artis, $genre, $tahun, $ukuran, $warna, $kondisi, $foto);
    $v[] = $newVinyl;
    return "[SUCCESS] Vinyl \"$nama\" ($artis) berhasil ditambahkan ke sistem!";
}

// ============ proses command ============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
    $line = trim($_POST['command']);
    if ($line !== "") {
        $tokens = preg_split('/\s+/', $line);
        $cmd = strtolower(array_shift($tokens));

        if ($cmd === "add" || $cmd === "/add") {
            $outputText = addVinyl($_SESSION['vinyls'], $tokens);
        } elseif ($cmd === "show" || $cmd === "/display") {
            $jumlah = count($_SESSION['vinyls']);
            $outputText = ($jumlah === 0)
                ? "Katalog vinyl kosong!"
                : "Menampilkan $jumlah album vinyl dalam basis data.";
        } elseif ($cmd === "panduan" || $cmd === "/help") {
            $outputText = panduanText();
        } elseif ($cmd === "done" || $cmd === "/exit") {
            $outputText = "Sesi selesai. Sampai jumpa!";
        } else {
            $outputText = "Perintah '$cmd' tidak dikenal! Ketik 'panduan' untuk bantuan.";
        }

        $_SESSION['log'][] = ["type" => "cmd", "text" => $line];
        $_SESSION['log'][] = ["type" => "out", "text" => $outputText];
    }
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vinyl Store &mdash; Neo-Brutalist CLI</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@600;800&family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">
<style>
    :root {
        --bg: #F4F0EA;
        --card-bg: #FFFFFF;
        --border: #000000;
        --yellow: #FFE600;
        --pink: #FF6B8B;
        --cyan: #4D96FF;
        --green: #6BCB77;
        --purple: #9D4EDD;
        --shadow: 5px 5px 0px #000000;
    }

    * { box-sizing: border-box; }

    body {
        background-color: var(--bg);
        background-image: radial-gradient(#000000 1.2px, transparent 1.2px);
        background-size: 24px 24px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #000;
        margin: 0;
        padding: 40px 20px;
        display: flex;
        justify-content: center;
        min-height: 100vh;
    }

    .wrapper { width: 100%; max-width: 1150px; }

    .brand-banner {
        background: var(--yellow);
        border: 3px solid var(--border);
        box-shadow: var(--shadow);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .brand-banner h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 900;
        text-transform: uppercase;
    }

    .brand-badge {
        background: #000;
        color: #fff;
        padding: 6px 14px;
        font-weight: 800;
        border-radius: 6px;
        font-size: 12px;
        text-transform: uppercase;
    }

    .console-card {
        background: var(--card-bg);
        border: 3px solid var(--border);
        box-shadow: var(--shadow);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 36px;
    }

    .console-header {
        background: #000;
        color: #fff;
        padding: 10px 16px;
        font-weight: 800;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .console-dots { display: flex; gap: 6px; }
    .console-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 1px solid #000;
    }

    .terminal-body {
        background: #FAF8F5;
        font-family: 'JetBrains Mono', monospace;
        padding: 20px;
        height: 240px;
        overflow-y: auto;
        font-size: 14px;
        border-bottom: 3px solid var(--border);
    }

    .log-item { margin-bottom: 12px; }

    .cmd-text {
        color: #000;
        font-weight: 800;
        background: rgba(77, 150, 255, 0.25);
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
    }

    .out-text {
        color: #000;
        font-weight: 600;
        white-space: pre-wrap;
        margin-top: 4px;
        padding-left: 12px;
        border-left: 3px solid var(--purple);
    }

    .info-text {
        color: #000;
        font-weight: 600;
        white-space: pre-wrap;
    }

    .cmd-form {
        padding: 16px;
        background: var(--card-bg);
        display: flex;
        gap: 12px;
    }

    .cmd-input {
        flex: 1;
        background: #FFF;
        border: 3px solid var(--border);
        border-radius: 8px;
        padding: 12px 16px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 13px;
        font-weight: 600;
        outline: none;
    }

    .cmd-input:focus {
        background: #FFFDE7;
        box-shadow: 3px 3px 0px #000;
    }

    .cmd-btn {
        background: var(--pink);
        color: #000;
        border: 3px solid var(--border);
        box-shadow: 3px 3px 0px #000;
        border-radius: 8px;
        padding: 0 24px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 900;
        font-size: 14px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .cmd-btn:hover { background: #FF5277; }
    .cmd-btn:active {
        transform: translate(2px, 2px);
        box-shadow: 1px 1px 0px #000;
    }

    .table-header-title {
        font-size: 20px;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 16px;
        display: inline-block;
        background: var(--cyan);
        padding: 6px 14px;
        border: 3px solid var(--border);
        box-shadow: 3px 3px 0px #000;
        border-radius: 8px;
    }

    .table-container {
        background: var(--card-bg);
        border: 3px solid var(--border);
        box-shadow: var(--shadow);
        border-radius: 12px;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    th {
        background: #000;
        color: #FFF;
        font-weight: 900;
        text-transform: uppercase;
        padding: 14px;
        font-size: 12px;
    }

    td {
        padding: 10px 14px;
        border-bottom: 2px solid var(--border);
        font-weight: 700;
        vertical-align: middle;
    }

    tr:last-child td { border-bottom: none; }
    tr:nth-child(even) { background: #FAF8F5; }

    .cover-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 2px solid #000;
        border-radius: 6px;
        box-shadow: 2px 2px 0px #000;
        display: block;
        background: #eee;
    }

    .tag {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        border: 2px solid #000;
        font-weight: 800;
        font-size: 11px;
    }

    .tag-id { background: var(--yellow); }
    .tag-mint { background: var(--green); }
    .tag-vg { background: var(--pink); }
    .tag-price { background: var(--cyan); }

    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #FAF8F5; }
    ::-webkit-scrollbar-thumb { background: #000; border-radius: 4px; }
</style>
</head>
<body>

<div class="wrapper">

    <!-- Header Banner -->
    <div class="brand-banner">
        <h1>Vinyl Store Management System</h1>
        <div class="brand-badge">CLI Terminal v3.0</div>
    </div>

    <!-- Terminal Console -->
    <div class="console-card">
        <div class="console-header">
            <span>TERMINAL_SESSION // ACTIVE</span>
            <div class="console-dots">
                <div class="console-dot" style="background:#FF5F56;"></div>
                <div class="console-dot" style="background:#FFBD2E;"></div>
                <div class="console-dot" style="background:#27C93F;"></div>
            </div>
        </div>

        <div class="terminal-body" id="terminal">
            <?php foreach ($_SESSION['log'] as $entry): ?>
                <div class="log-item">
                <?php if ($entry['type'] === 'cmd'): ?>
                    <span class="cmd-text">> <?php echo htmlspecialchars($entry['text']); ?></span>
                <?php elseif ($entry['type'] === 'out'): ?>
                    <div class="out-text"><?php echo htmlspecialchars($entry['text']); ?></div>
                <?php else: ?>
                    <div class="info-text"><?php echo htmlspecialchars($entry['text']); ?></div>
                <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <form class="cmd-form" method="post" action="index.php">
            <input type="text" name="command" class="cmd-input" autofocus autocomplete="off" 
                   placeholder="add V06 Definitely_Maybe 600000 Oasis Britpop 1994 12_inch Hitam Mint images/oasis.jpg">
            <button type="submit" class="cmd-btn">EXECUTE</button>
        </form>
    </div>

    <!-- Tabel Katalog Data -->
    <div class="table-header-title">Katalog Vinyl Saat Ini</div>

    <?php if (count($_SESSION['vinyls']) === 0): ?>
        <p style="font-weight: 800;">Katalog vinyl masih kosong.</p>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>ID</th>
                        <th>Nama Album</th>
                        <th>Artis</th>
                        <th>Genre</th>
                        <th>Tahun</th>
                        <th>Ukuran</th>
                        <th>Warna</th>
                        <th>Kondisi</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['vinyls'] as $v): ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($v->getFoto()); ?>" 
                                 alt="<?php echo htmlspecialchars($v->getNamaProduk()); ?>" 
                                 class="cover-thumb"
                                 onerror="this.src='images/no-cover.jpg'">
                        </td>
                        <td><span class="tag tag-id"><?php echo htmlspecialchars($v->getIdProduk()); ?></span></td>
                        <td><u><?php echo htmlspecialchars($v->getNamaProduk()); ?></u></td>
                        <td><?php echo htmlspecialchars($v->getArtis()); ?></td>
                        <td><?php echo htmlspecialchars($v->getGenre()); ?></td>
                        <td><?php echo $v->getTahunRilis(); ?></td>
                        <td><?php echo htmlspecialchars($v->getUkuran()); ?></td>
                        <td><?php echo htmlspecialchars($v->getWarna()); ?></td>
                        <td>
                            <?php 
                                $kondisi = $v->getKondisi();
                                $tagClass = (strcasecmp($kondisi, 'Mint') === 0) ? 'tag-mint' : 'tag-vg';
                            ?>
                            <span class="tag <?php echo $tagClass; ?>"><?php echo htmlspecialchars($kondisi); ?></span>
                        </td>
                        <td><span class="tag tag-price">Rp<?php echo number_format($v->getHarga(), 0, ',', '.'); ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <p style="font-weight: 800; font-size: 14px; margin-top: 12px;">Total koleksi: <?php echo count($_SESSION['vinyls']); ?> vinyl</p>
    <?php endif; ?>

</div>

<script>
    var term = document.getElementById('terminal');
    term.scrollTop = term.scrollHeight;
</script>
</body>
</html>