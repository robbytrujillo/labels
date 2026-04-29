<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <link rel="icon" type="image/x-icon" href="../assets/logo-sma.png">


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
    body {
        height: 100vh;
        /* background: linear-gradient(135deg, #4f46e5, #6366f1); */
        background: #F6F8FD;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
    }

    .login-card {
        width: 100%;
        max-width: 380px;
        border-radius: 18px;
        overflow: hidden;
        animation: fadeIn 0.5s ease-in-out;
    }

    .card {
        border: none;
    }

    .card-header {
        background: transparent;
        text-align: center;
        padding-top: 25px;
    }

    .logo {
        width: 50px;
        margin-bottom: 10px;
    }

    .title {
        font-weight: bold;
        font-size: 20px;
    }

    .subtitle {
        font-size: 13px;
        color: #888;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px;
    }

    .input-group-text {
        border-radius: 10px;
        cursor: pointer;
    }

    .btn-login {
        background: #4f46e5;
        border-radius: 30px;
        padding: 10px;
        font-weight: 500;
        transition: 0.2s;
    }

    .btn-login:hover {
        background: #4338ca;
    }

    .footer-text {
        font-size: 12px;
        color: #aaa;
        text-align: center;
        margin-top: 10px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>

</head>

<body>

    <div class="login-card card shadow">

        <div class="card-header">
            <!-- LOGO -->
            <img src="../assets/logo-sma.png" class="logo" alt="Logo">

            <!-- <div class="title">Login Admin</div> -->
            <div class="subtitle">Sistem Label Laci Siswa</div>
        </div>

        <div class="card-body px-4 pb-4">

            <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2 text-center">
                Username / Password salah
            </div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST">

                <!-- USERNAME -->
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">Password</label>

                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password" required>

                        <span class="input-group-text" onclick="togglePassword()">
                            <i class="bi bi-eye" id="iconEye"></i>
                        </span>
                    </div>
                </div>

                <!-- BUTTON -->
                <button class="btn btn-login w-100 text-white">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>

                <div class="text-center mt-3">
                    <a href="../index.php" class="text-decoration-none text-muted">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>

            </form>

            <div class="footer-text">
                Copyright &copy; <?= date('Y'); ?>
                <a href="https://robbyilham.com/" target="_blank" class="text-primary font-weight-bold"
                    style="text-decoration: none;">
                    by
                </a>
                IT Development IHBS
            </div>


        </div>
    </div>

    <!-- JS -->
    <script>
    function togglePassword() {
        var input = document.getElementById("password");
        var icon = document.getElementById("iconEye");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
    </script>

</body>

</html>