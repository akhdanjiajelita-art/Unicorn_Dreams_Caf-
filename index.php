<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user']['username'];
$role = $_SESSION['user']['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Cafe Barbie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Animasi Logo Kopi */
        .logo {
            animation: bounce 3s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Fade-in animasi konten */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Delay tiap tombol */
        .btn-gradient {
            opacity: 0;
            transform: scale(0.9);
            animation: popIn 0.6s forwards;
        }
        .btn1 { animation-delay: 0.5s; }
        .btn2 { animation-delay: 0.8s; }
        .btn3 { animation-delay: 1.1s; }

        @keyframes popIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="container-box text-center fade-in">
        <!-- Logo Kopi -->
        <img src="https://cdn-icons-png.flaticon.com/512/924/924514.png" width="90" class="mb-3 logo">

        <h1>☕ Selamat Datang, <?= ucfirst($username) ?> 🎀</h1>
        <p class="mb-4">Kamu login sebagai <b><?= ucfirst($role) ?></b></p>

        <!-- Menu Berdasarkan Role -->
        <?php if ($role == "admin"): ?>
            <a href="admin.php" class="btn-gradient m-2 btn1">📦 Kelola Produk</a>
            <a href="admin.php#transaksi" class="btn-gradient m-2 btn2">📊 Lihat Transaksi</a>
        <?php elseif ($role == "kasir"): ?>
            <a href="kasir.php" class="btn-gradient m-2 btn1">🛍️ Proses Pembelian</a>
        <?php elseif ($role == "pembeli"): ?>
            <a href="produk.php" class="btn-gradient m-2 btn1">🛒 Belanja Sekarang</a>
        <?php endif; ?>

        <br><br>
        <a href="logout.php" class="btn btn-outline-danger btn-sm btn3">🚪 Logout</a>
    </div>
</body>
</html>
