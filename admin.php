<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$products = &$_SESSION['products'];
$transactions = $_SESSION['transactions'] ?? [];

// Tambah produk
if(isset($_POST['tambah'])) {
    $id = count($products) + 1;
    $products[$id] = [
        "nama" => $_POST['nama'],
        "harga" => (int) $_POST['harga']
    ];
}

// Hapus produk
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    unset($products[$id]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Unicorn background */
        .unicorn-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }
        .unicorn {
            position: absolute;
            font-size: 2rem;
            animation: flyUnicorn 10s linear infinite;
            opacity: 0.9;
        }
        .unicorn:nth-child(1) { left: 10%; animation-delay: 0s; }
        .unicorn:nth-child(2) { left: 25%; animation-delay: 2s; }
        .unicorn:nth-child(3) { left: 50%; animation-delay: 4s; }
        .unicorn:nth-child(4) { left: 70%; animation-delay: 6s; }
        .unicorn:nth-child(5) { left: 85%; animation-delay: 8s; }

        @keyframes flyUnicorn {
            from {
                top: 110%;
                transform: translateX(0) rotate(0deg);
            }
            to {
                top: -10%;
                transform: translateX(50px) rotate(360deg);
            }
        }

        /* Supaya konten di atas unicorn */
        .container-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="container py-4">

    <!-- Unicorn -->
    <div class="unicorn-container">
        <div class="unicorn">🦄</div>
        <div class="unicorn">🦄</div>
        <div class="unicorn">🦄</div>
        <div class="unicorn">🦄</div>
        <div class="unicorn">🦄</div>
    </div>

    <!-- Konten admin -->
    <div class="container-content">
        <h2>Admin Panel</h2>

        <!-- ================= PRODUK ================= -->
        <h4 class="mt-4">Kelola Produk</h4>
        <form method="post" class="mb-4">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="nama" placeholder="Nama produk" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="harga" placeholder="Harga" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="tambah" class="btn btn-success w-100">Tambah</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
            <?php foreach($products as $id => $p): ?>
            <tr>
                <td><?= $id ?></td>
                <td><?= $p['nama'] ?></td>
                <td>Rp <?= number_format($p['harga']) ?></td>
                <td><a href="?hapus=<?= $id ?>" class="btn btn-danger btn-sm">Hapus</a></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- ================= TRANSAKSI ================= -->
        <h4 class="mt-5">Data Transaksi</h4>
        <?php if(empty($transactions)): ?>
            <p>Belum ada transaksi.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <tr>
                    <th>Nama Pembeli</th>
                    <th>Alamat</th>
                    <th>Total</th>
                    <th>Detail</th>
                </tr>
                <?php 
                $grandTotal = 0;
                foreach($transactions as $t): 
                    $grandTotal += $t['total'];
                ?>
                <tr>
                    <td><?= $t['nama'] ?></td>
                    <td><?= $t['alamat'] ?></td>
                    <td>Rp <?= number_format($t['total']) ?></td>
                    <td>
                        <ul>
                            <?php foreach($t['items'] as $item): ?>
                            <li><?= $item['nama'] ?> (Rp <?= number_format($item['harga']) ?>)</li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>

            <!-- ================= REKAP ================= -->
            <div class="alert alert-info">
                <strong>Rekap Penjualan:</strong> Rp <?= number_format($grandTotal) ?>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>
