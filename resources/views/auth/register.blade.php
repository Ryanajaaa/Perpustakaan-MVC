<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-card {
            background: white;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .register-card h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 18px;
        }

        .input-group label {
            font-size: 14px;
            margin-bottom: 6px;
            display: block;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #4e73df;
            outline: none;
            box-shadow: 0 0 0 2px rgba(78,115,223,0.2);
        }

        .row {
            display: flex;
            gap: 15px;
        }

        .row .input-group {
            flex: 1;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: #4e73df;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            background: #2e59d9;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .footer-text a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 500;
        }

        .alert {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #842029;
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
        }

        @media(max-width: 600px){
            .row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="register-card">
    <h2>📚 Daftar Akun</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/register" method="POST">
        @csrf

        <div class="row">
            <div class="input-group">
                <label>NIS</label>
                <input type="number" name="school_id" required>
            </div>

            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required>
            </div>
        </div>

        <div class="row">
            <div class="input-group">
                <label>Kelas</label>
                <input type="text" name="class" required>
            </div>

            <div class="input-group">
                <label>Jurusan</label>
                <input type="text" name="major" required>
            </div>
        </div>

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="input-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn-register">
            Daftar
        </button>
    </form>

    <div class="footer-text">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </div>
</div>

</body>
</html>