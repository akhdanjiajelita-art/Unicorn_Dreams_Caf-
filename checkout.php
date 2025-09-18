<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'pembeli') {
    header("Location: index.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach($cart as $c) {
    $total += $c['harga'];
}

if(isset($_POST['checkout'])) {
    // Simpan transaksi
    $_SESSION['transactions'][] = [
        "nama" => $_POST['nama'],
        "alamat" => $_POST['alamat'],
        "total" => $total,
        "items" => $cart
    ];
    // Kosongkan keranjang
    $_SESSION['cart'] = [];
    $msg = "🦄✨ Terima kasih, pesanan Anda sudah diproses dengan indah! ✨🦄";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout 🦄</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="container py-4">
    <h2>🦄 Checkout Pesanan 🦄</h2>
    <?php if(isset($msg)): ?>
        <div class="alert alert-success text-center"><?= $msg; ?></div>
        <a href="produk.php" class="btn btn-primary w-100">🦄 Kembali Belanja</a>
    <?php elseif(empty($cart)): ?>
        <p>Keranjang kosong 🦄. <a href="produk.php">Belanja sekarang ✨</a></p>
    <?php else: ?>
        <h4>Total Bayar: Rp <?= number_format($total); ?> 🦄</h4>
        <form method="post" class="mt-3">
            <div class="mb-3">
                <label>🦄 Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>🦄 Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>
            <button type="submit" name="checkout" class="btn btn-success w-100">✨ Konfirmasi Pesanan 🦄</button>
        </form>
    <?php endif; ?>
</body>
</html>
