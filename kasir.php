<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'kasir') {
    header("Location: index.php");
    exit;
}

$transactions = $_SESSION['transactions'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi 🦄</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="container py-4">
    <h2>🦄✨ Data Transaksi Kasir ✨🦄</h2>
    <?php if(empty($transactions)): ?>
        <p>Belum ada transaksi 🦄</p>
    <?php else: ?>
        <table class="table table-bordered">
            <tr>
                <th>Nama Pembeli 🦄</th>
                <th>Alamat 🦄</th>
                <th>Total 🦄</th>
                <th>Detail 🦄</th>
            </tr>
            <?php foreach($transactions as $t): ?>
            <tr>
                <td><?= $t['nama'] ?></td>
                <td><?= $t['alamat'] ?></td>
                <td>Rp <?= number_format($t['total']) ?></td>
                <td>
                    <ul>
                        <?php foreach($t['items'] as $item): ?>
                        <li>🦄 <?= $item['nama'] ?> (Rp <?= number_format($item['harga']) ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <a href="index.php" class="btn btn-secondary">🦄 Kembali</a>
</body>
</html>
