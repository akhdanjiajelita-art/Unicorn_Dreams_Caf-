<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'pembeli') {
    header("Location: index.php");
    exit;
}

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$products = [
    1 => ["nama" => "Kopi Hitam", "harga" => 15000],
    2 => ["nama" => "Teh Susu", "harga" => 12000],
    3 => ["nama" => "Roti Bakar", "harga" => 20000],
];

$pesan = '';
if(isset($_GET['add'])) {
    $id = $_GET['add'];
    if(isset($products[$id])) {
        $_SESSION['cart'][] = $products[$id];
        $pesan = $products[$id]['nama'] . " berhasil ditambahkan ke keranjang!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fce7f3, #ede9fe, #dbeafe);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        .unicorn {
            position: absolute;
            font-size: 2rem;
            animation: fly 12s linear infinite;
            z-index: 0;
            pointer-events: none;
        }
        .unicorn:nth-child(1) { top: 15%; left: -50px; animation-delay: 0s; }
        .unicorn:nth-child(2) { top: 35%; left: -100px; animation-delay: 4s; }
        .unicorn:nth-child(3) { top: 60%; left: -150px; animation-delay: 8s; }

        @keyframes fly {
            0% { transform: translateX(0) rotate(0deg); opacity: 1; }
            50% { transform: translateX(120vw) rotate(20deg); opacity: 0.9; }
            100% { transform: translateX(0) rotate(0deg); opacity: 1; }
        }
        .notif {
            position: relative; z-index: 1; margin-bottom: 15px;
        }
    </style>
</head>
<body class="container py-4">

    <!-- Unicorns -->
    <div class="unicorn">🦄</div>
    <div class="unicorn">🦄</div>
    <div class="unicorn">🦄</div>

    <h2 class="mb-4 text-center">✨ Daftar Produk Cafe Barbie ✨</h2>

    <!-- Notifikasi -->
    <?php if($pesan): ?>
        <div class="alert alert-success notif"><?= $pesan ?></div>
    <?php endif; ?>

    <!-- Produk -->
    <div class="row">
        <?php foreach($products as $id => $p): ?>
        <div class="col-12 col-md-4 mb-3">
            <div class="card p-3 shadow-sm text-center" style="position: relative; z-index:1;">
                <h5><?= $p['nama']; ?></h5>
                <p>Rp <?= number_format($p['harga']); ?></p>
                <a href="?add=<?= $id; ?>" class="btn btn-gradient w-100">Tambah ke Keranjang 🛒</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Tombol Lihat Keranjang & Kembali -->
    <a href="cart.php" class="btn btn-success w-100 mt-3" style="position: relative; z-index:1;">Lihat Keranjang 🛍️ (<?= count($_SESSION['cart']); ?>)</a>
    <a href="index.php" class="btn btn-secondary w-100 mt-3" style="position: relative; z-index:1;">Kembali</a>

</body>
</html>
