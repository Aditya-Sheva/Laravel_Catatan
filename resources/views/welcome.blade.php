<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Harian</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Animate.css for subtle fade effects -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        html, body {
            scroll-behavior: smooth;
            background-color: #f8f8f8;
        }

        .fade-section {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1.2s ease, transform 1.2s ease;
        }
        .fade-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Parallax background effect */
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0%;
            height: 2px;
            background-color: black;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        footer a:hover {
            color: #000;
            text-decoration: underline;
        }

        /* Smooth parallax scroll */
        .parallax::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.65);
        }
    </style>
</head>
<body class="font-[Poppins] text-gray-800">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center py-4 px-6">
            <h1 class="text-2xl font-semibold text-gray-900">Catatan<span class="font-light">Harian</span></h1>
            <div class="space-x-8 text-sm font-medium">
                <a href="#fitur" class="nav-link">Fitur</a>
                <a href="#tentang" class="nav-link">Tentang</a>
                <a href="{{ route('login') }}" class="bg-black text-white px-5 py-2 rounded-full hover:bg-gray-800 transition">Mulai</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center parallax"
        style="background-image: url('https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative text-center text-white px-6 fade-section">
            <h2 class="text-5xl md:text-6xl font-semibold mb-6 animate__animated animate__fadeInDown">Catat Setiap Momen</h2>
            <p class="max-w-lg mx-auto text-lg font-light mb-8 animate__animated animate__fadeInUp">
                Simpan cerita hidupmu dalam bentuk digital yang aman dan pribadi.
            </p>
            <a href="{{ route('login') }}" class="bg-white text-black px-8 py-3 rounded-full font-semibold hover:bg-gray-200 transition animate__animated animate__fadeInUp animate__delay-1s">
                Mulai Sekarang
            </a>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="min-h-screen flex items-center justify-center bg-gray-50 fade-section">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-semibold mb-10">Fitur Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-white p-8 shadow-md rounded-xl hover:shadow-lg transition-all">
                    <h3 class="font-semibold text-xl mb-4">Tambah Catatan</h3>
                    <p class="text-gray-600">Tulis pikiran dan pengalamanmu kapan saja dengan antarmuka sederhana namun elegan.</p>
                </div>
                <div class="bg-white p-8 shadow-md rounded-xl hover:shadow-lg transition-all">
                    <h3 class="font-semibold text-xl mb-4">Edit & Hapus</h3>
                    <p class="text-gray-600">Ubah atau hapus catatan lama dengan mudah sesuai keinginanmu.</p>
                </div>
                <div class="bg-white p-8 shadow-md rounded-xl hover:shadow-lg transition-all">
                    <h3 class="font-semibold text-xl mb-4">Privasi Aman</h3>
                    <p class="text-gray-600">Setiap catatan hanya dapat diakses oleh akunmu sendiri, menjaga privasimu sepenuhnya.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section id="tentang" class="min-h-screen flex items-center justify-center bg-white fade-section">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-semibold mb-6">Tentang Aplikasi</h2>
            <p class="text-gray-600 text-lg leading-relaxed mb-10">
                <strong>Catatan Harian</strong> dibuat untuk membantu kamu mengabadikan momen, ide, atau emosi dalam satu tempat pribadi.
                Dengan desain yang minimalis dan modern, kamu bisa menulis tanpa gangguan dan menyimpan setiap cerita hidupmu dengan aman.
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-black text-white px-10 py-3 rounded-full hover:bg-gray-800 transition">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-gray-400 text-sm text-center py-8">
        <p class="mb-3">© 2025 Catatan Harian — Semua Hak Dilindungi</p>
        <div class="flex justify-center space-x-6">
            <a href="#fitur" class="hover:text-white">Fitur</a>
            <a href="#tentang" class="hover:text-white">Tentang</a>
            <a href="{{ route('login') }}" class="hover:text-white">Masuk</a>
        </div>
    </footer>

    <!-- Fade on scroll -->
    <script>
        const sections = document.querySelectorAll('.fade-section');
        const revealOnScroll = () => {
            const triggerBottom = window.innerHeight * 0.9;
            sections.forEach(sec => {
                const rect = sec.getBoundingClientRect().top;
                if (rect < triggerBottom) sec.classList.add('visible');
            });
        };
        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll();
    </script>
</body>
</html>
