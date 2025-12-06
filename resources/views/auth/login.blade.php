<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Catatan Harian</title>

    <!-- Google Font & Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f9f9f9, #ececec);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* subtle animated gradient shadow */
        .background-blur {
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            filter: blur(120px);
            background: radial-gradient(circle, rgba(0,0,0,0.15), transparent 70%);
            animation: float 6s ease-in-out infinite alternate;
        }
        @keyframes float {
            from {transform: translate(0,0);}
            to {transform: translate(40px, -30px);}
        }

        .card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 390px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.08);
            padding: 40px 35px;
            animation: fadeIn 0.8s ease;
        }

        .app-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
            color: #111;
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 500;
            color: #222;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
            color: #333;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ccc;
            box-shadow: none;
            padding: 10px 12px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #111;
            box-shadow: 0 0 0 0.2rem rgba(0,0,0,0.05);
        }

        .btn-primary {
            width: 100%;
            background: #111;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-weight: 500;
            color: white;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #333;
            transform: translateY(-2px);
        }

        p {
            margin-top: 18px;
            color: #555;
            font-size: 0.9rem;
        }

        p a {
            color: #000;
            text-decoration: none;
            font-weight: 600;
        }

        p a:hover {
            text-decoration: underline;
        }

        .alert {
            font-size: 0.9rem;
            border-radius: 8px;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(10px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

    <div class="background-blur"></div>

    <div class="card">
        <div class="app-title">Catatan Harian</div>
        <h2>Masuk ke Akun</h2>

        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="contoh@email.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="********">
            </div>

            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>

        <p class="text-center">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </p>
    </div>

</body>
</html>
