<?php
session_start();

// Daftar user (username => [password, role])
$users = [
    "admin"   => ["123", "admin"],
    "kasir"   => ["123", "kasir"],
    "pembeli" => ["123", "pembeli"],
];

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'] ?? '';

    if($role == 'pembeli'){
        // Langsung login tanpa password
        $_SESSION['user'] = ['username'=>'guest','role'=>'pembeli'];
        header("Location: produk.php");
        exit;
    } else {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (isset($users[$username]) && $users[$username][0] === $password && $users[$username][1] == $role) {
            $_SESSION['user'] = ["username"=>$username, "role"=>$role];
            header("Location: index.php"); // Atau dashboard.php
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Cafe Barbie 🦄</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ff8ac9, #ffffff, #a78bfa, #60a5fa);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Poppins", sans-serif;
            overflow: hidden;
        }
        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        .login-box {
            background: rgba(255,255,255,0.9);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 380px;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        .login-box img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 1rem;
            background: #fff0f5;
            padding: 10px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .login-box h2 {
            background: linear-gradient(90deg, #ec4899, #a78bfa, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            margin-bottom: 1.5rem;
            font-size: 28px;
        }
        .form-control {
            border-radius: 12px;
            border: 1px solid #d8b4fe;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #ec4899, #a78bfa, #60a5fa);
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 12px;
            transition: 0.3s;
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg, #db2777, #7c3aed, #2563eb);
            transform: scale(1.05);
        }
        .alert-danger {
            border-radius: 10px;
        }

        /* Unicorn terbang */
        .unicorn {
            position: absolute;
            font-size: 2rem;
            animation: fly 12s linear infinite;
            top: 10%;
        }
        .unicorn:nth-child(1) { left: -10%; animation-delay: 0s; }
        .unicorn:nth-child(2) { left: -30%; animation-delay: 4s; }
        .unicorn:nth-child(3) { left: -50%; animation-delay: 8s; }
        @keyframes fly {
            0% { left: -10%; top: 20%; transform: rotate(0deg); }
            50% { left: 50%; top: 10%; transform: rotate(10deg); }
            100% { left: 110%; top: 30%; transform: rotate(-10deg); }
        }
    </style>
</head>
<body>
    <!-- Unicorns -->
    <div class="unicorn">🦄</div>
    <div class="unicorn">🦄</div>
    <div class="unicorn">🦄</div>

    <div class="login-box">
        <img src="gambar/logo-unicorn-coffee.png.png" alt="Logo Unicorn Coffee" class="logo">
        <h2>☕Login Cafe cantik🎀🦄</h2>

        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3 text-start">
                <label class="form-label">Pilih Role</label>
                <select name="role" id="role" class="form-control" onchange="togglePassword()" required>
                    <option value="pembeli">Pembeli</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                </select>
            </div>

            <div id="login-fields">
                <div class="mb-3 text-start">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <button class="btn btn-gradient w-100">Login 🦄</button>
        </form>
    </div>

    <script>
        function togglePassword(){
            var role = document.getElementById('role').value;
            document.getElementById('login-fields').style.display = (role == 'pembeli') ? 'none' : 'block';
        }
        togglePassword(); // set awal
    </script>
</body>
</html>
