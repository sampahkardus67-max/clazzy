<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clazzy - Aplikasi Akademik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #e0e0e0;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .logo-icon {
            background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .nav-menu {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            list-style: none;
        }

        .nav-item {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-item:hover {
            background-color: #d0d0d0;
        }

        .nav-item.active {
            background-color: #00bcd4;
            color: white;
        }

        .nav-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border: 2px solid #00bcd4;
            border-radius: 8px;
            background: white;
            color: #00bcd4;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background: #00bcd4;
            color: white;
        }

        .btn-register {
            background: #00bcd4;
            color: white;
        }

        .btn-register:hover {
            background: #0097a7;
            border-color: #0097a7;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        /* Home Page */
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            padding: 3rem 0;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-style: italic;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: #666;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .btn-primary {
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(147, 51, 234, 0.3);
        }

        .btn-secondary {
            padding: 1rem 2rem;
            background: white;
            color: #9333ea;
            border: 2px solid #9333ea;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #9333ea;
            color: white;
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #9333ea;
        }

        .stat-label {
            color: #666;
        }

        .hero-image {
            background: #d0d0d0;
            height: 400px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Features Section */
        .section-title {
            text-align: center;
            font-size: 2rem;
            margin: 3rem 0 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: #d0d0d0;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
        }

        .feature-header {
            background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);
            color: white;
            padding: 1rem;
            margin: -2rem -2rem 1rem;
            border-radius: 12px 12px 0 0;
            font-weight: bold;
        }

        .feature-card p {
            line-height: 1.6;
            color: #333;
        }

        /* Academic/Page Title style */
        .page-title {
            font-size: 2.5rem;
            text-align: center;
            margin: 2rem 0 3rem;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 8rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero {
                grid-template-columns: 1fr;
            }

            .cards-grid,
            .features-grid,
            .assessment-grid {
                grid-template-columns: 1fr;
            }

            .progress-item {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon">C</div>
            <span>Clazzy</span>
        </div>
        <ul class="nav-menu">
            <li class="nav-item" onclick="showPage('home')">
                <i class="fas fa-home"></i> Home
            </li>
            <li class="nav-item" onclick="showPage('about')">
                <i class="fas fa-user"></i> About
            </li>
        </ul>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </nav>

    <!-- Home Page -->
    <div id="home" class="page active">
        <div class="container">
            <div class="hero">
                <div class="hero-content">
                    <h1>WELCOME TO CLAZZY!!</h1>
                    <p>Selamat datang di aplikasi Clazzy, dimana kamu akan mulai mengerjakan tugas dari dosen kamu
                        melalui aplikasi ini, selamat mengerjakan!! ^_^</p>
                    <div class="hero-buttons">
                        <button class="btn-primary">Start Learning</button>
                        <button class="btn-secondary">
                            <i class="fas fa-compass"></i> Explore Courses
                        </button>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">250+</div>
                            <div class="stat-label">Students</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">100+</div>
                            <div class="stat-label">Courses</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">Success Rate</div>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="https://sugenghartono.ac.id/wp-content/uploads/2025/06/Universitas-Sugeng-Hartono-Catat-Prestasi-11-Dosen-Lolos-Hibah-DPPM-Kemendikti-Saintek-2025-dengan-12-Judul-.png" alt="Hero Image" style="width: 115%; max-width: 1000px; border-radius: 15px; height: 100%;">
                </div>
            </div>

            <h2 class="section-title">Kenapa Harus Memilih Aplikasi Clazzy</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-header">Platform Digital</div>
                    <p>Menyediakan platform digital yang efektif dan mudah diakses mahasiswa dan dosen untuk mendukung
                        proses pembelajaran.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-header">Forum Diskusi</div>
                    <p>Mahasiswa dan Dosen dapat menggunakan forum sederhana untuk diskusi sebagai tanya jawab</p>
                </div>
                <div class="feature-card" style="grid-column: 1 / -1; max-width: 600px; margin: 0 auto;">
                    <div class="feature-header">Akses Mata Kuliah</div>
                    <p>Mahasiswa dapat mengakses mata kuliah yang diambil dan tugas terbaru</p>
                </div>
            </div>
        </div>
    </div>


    <div id="about" class="page">
        <div class="container">
            <h1 class="page-title">Universitas Sugeng Hartono</h1>
            <div class="cards-grid">
            <h2>Jln. Ir. Soekarno, Madegondo, Solo Baru, Sukoharjo, Jawa Tengah, Indonesia.</h2>
            </div>
        </div>
    </div>

    <script>
        function showPage(pageId) {
            // Hide all pages
            const pages = document.querySelectorAll('.page');
            pages.forEach(page => page.classList.remove('active'));

            // Remove active class from all nav items
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => item.classList.remove('active'));

            // Show selected page
            document.getElementById(pageId).classList.add('active');

            // Add active class to clicked nav item
            event.target.closest('.nav-item').classList.add('active');
        }

        // Set default active page
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.nav-item').classList.add('active');
        });
    </script>
</body>

</html>