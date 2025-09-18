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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja 🦄</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .payment-option { display: none; margin-top: 10px; }
    </style>
</head>
<body class="container py-4">
    <h2>🦄 Keranjang Belanja 🦄</h2>
    <?php if(empty($cart)): ?>
        <p>Keranjang kosong 🦄</p>
    <?php else: ?>
        <ul class="list-group mb-3">
            <?php foreach($cart as $c): ?>
            <li class="list-group-item d-flex justify-content-between">
                🦄 <?= $c['nama']; ?> 
                <span>Rp <?= number_format($c['harga']); ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <h4>Total: Rp <?= number_format($total); ?> 🦄</h4>

        <!-- Tombol Pembayaran -->
        <button id="btn-cash" class="btn btn-primary w-100 mt-3">🦄 Bayar Cash</button>

        <!-- Tombol Pembayaran Online -->
<button class="btn btn-warning w-100 mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#online-payment">
    🦄 Pembayaran Online
</button>

<!-- Isi pilihan pembayaran online -->
<div class="collapse mt-3" id="online-payment">
    <div class="card card-body">
        <label for="bank">Pilih Metode:</label>
        <select id="bank" class="form-select mt-2">
            <option value="">-- Pilih Bank / QRIS --</option>
            <option value="qris">QRIS</option>
            <option value="bca">Bank BCA</option>
            <option value="bni">Bank BNI</option>
            <option value="bri">Bank BRI</option>
            <option value="mandiri">Bank Mandiri</option>
        </select>

        <!-- Tombol lanjut -->
        <a id="lanjut-bayar" class="btn btn-secondary w-100 mt-3">🦄 Lanjut Bayar</a>
    </div>
</div>
    <?php endif; ?>
    <a href="produk.php" class="btn btn-secondary w-100 mt-3">🦄 Kembali Belanja</a>

    <!-- Tambahkan Bootstrap JS + script kontrol -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const bankSelect = document.getElementById('bank');
    const lanjutBtn = document.getElementById('lanjut-bayar');

    bankSelect.addEventListener('change', () => {
        const bank = bankSelect.value;

        if (bank === "") {
            lanjutBtn.classList.remove('btn-success');
            lanjutBtn.classList.add('btn-secondary');
            lanjutBtn.removeAttribute('href'); // belum bisa klik
        } else {
            lanjutBtn.classList.remove('btn-secondary');
            lanjutBtn.classList.add('btn-success');
            lanjutBtn.href = "checkout.php?metode=online&bank=" + bank; // aktif
        }
    });
</script>
<script>
    document.getElementById("btn-cash").addEventListener("click", function() {
        window.location.href = "checkout.php?metode=cash";
    });
</script>
</body>
</html>
