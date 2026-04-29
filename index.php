<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Laci Siswa</title>

    <link rel="icon" type="image/x-icon" href="assets/logo-sma.png">


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #F6F8FD;
    }

    /* HERO */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        text-align: center;
    }

    .hero h1 {
        color: #111;
        font-weight: 700;
        font-size: 2.5rem;
    }

    .hero p {
        color: #555;
        font-size: 1.1rem;
    }

    /* BUTTON */
    .btn-main {
        background: #4f46e5;
        color: white;
        border-radius: 30px;
        padding: 12px 22px;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-main:hover {
        background: #4338ca;
        transform: translateY(-2px);
    }

    /* SECTION */
    .section {
        padding: 70px 0;
    }

    /* FEATURE */
    .feature-box {
        background: white;
        border-radius: 16px;
        padding: 25px;
        text-align: center;
        transition: 0.3s;
        height: 100%;
    }

    .feature-box:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        font-size: 32px;
        color: #4f46e5;
        margin-bottom: 10px;
    }

    /* CTA */
    .cta-box {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        border-radius: 30px;
        padding: 40px;
    }

    footer {
        background: #1e293b;
        color: white;
        text-align: center;
        padding: 15px;
    }

    @media(max-width:576px) {
        .hero h1 {
            font-size: 1.8rem;
        }
    }
    </style>

</head>

<body>

    <!-- HERO -->
    <section class="hero">
        <div class="container">

            <img src="assets/logo-sma.png" width="90" class="mb-3" data-aos="zoom-in">

            <h1 data-aos="fade-up">📁 Sistem Label Laci Siswa</h1>

            <p class="mt-2" data-aos="fade-up" data-aos-delay="100">
                Kelola label laci siswa dengan cepat, rapi, dan profesional
            </p>

            <a href="auth/login.php" class="btn btn-main mt-4" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-box-arrow-in-right"></i> Login Admin
            </a>

        </div>
    </section>

    <!-- FITUR -->
    <section class="section bg-light">
        <div class="container text-center">

            <h3 class="mb-5 fw-bold" data-aos="fade-up">Fitur Unggulan</h3>

            <div class="row g-4">

                <div class="col-md-3 col-6" data-aos="fade-up">
                    <div class="feature-box">
                        <div class="feature-icon">📋</div>
                        <h6 class="fw-bold">Manajemen Data</h6>
                        <small class="text-muted">CRUD siswa cepat & mudah</small>
                    </div>
                </div>

                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box">
                        <div class="feature-icon">📥</div>
                        <h6 class="fw-bold">Import Excel</h6>
                        <small class="text-muted">Upload data otomatis</small>
                    </div>
                </div>

                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box">
                        <div class="feature-icon">🖨</div>
                        <h6 class="fw-bold">Export PDF</h6>
                        <small class="text-muted">Siap cetak langsung</small>
                    </div>
                </div>

                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box">
                        <div class="feature-icon">🔳</div>
                        <h6 class="fw-bold">QR Code</h6>
                        <small class="text-muted">Identitas digital siswa</small>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- CTA -->
    <section class="section">
        <div class="container text-center">

            <div class="cta-box" data-aos="zoom-in">

                <h4 class="fw-bold">Mulai Kelola Label Sekarang</h4>

                <p class="mt-2">
                    Masuk sebagai admin untuk mengelola data siswa
                </p>

                <a href="auth/login.php" class="btn btn-light mt-3" style="border-radius: 30px">
                    🚀 Masuk ke Dashboard
                </a>

            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container-fluid px-4 text-center">
            <h6 class="mb-0"><b>Copyright &copy; <script>
                    document.write(new Date().getFullYear())
                    </script> <a href="https://robbyilham.com/" target="_blank" style="text-decoration: none;">by</a> IT
                    Development IHBS</b></h6>
        </div>
    </footer>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 800,
        once: true
    });
    </script>

</body>

</html>