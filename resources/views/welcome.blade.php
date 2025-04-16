<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f5fa;
            color: #2c3e50;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .container {
            width: 90%;
            max-width: 900px;
            background: white;
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        .welcome-title {
            font-size: 2.8rem;
            font-weight: 700;
        }
        .welcome-text {
            font-size: 1.4rem;
            opacity: 0.8;
        }
        .role-selection {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }
        .role-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 50px;
            border-radius: 20px;
            width: 48%;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .role-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        .role-card i {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .role-card h4 {
            font-size: 2rem;
            font-weight: 700;
        }
        .role-card p {
            font-size: 1.2rem;
            opacity: 0.9;
            flex-grow: 1; /* Menjaga teks agar proporsional */
        }
        .btn-role {
            display: inline-block;
            padding: 15px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            background: #ffcc00;
            color: #2c3e50;
            transition: 0.3s;
            margin-top: auto; /* Memastikan tombol tetap sejajar di bawah */
        }
        .btn-role:hover {
            background: #db57f5d8;
            color: white;
        }
        footer {
            margin-top: 40px;
            font-size: 1rem;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="welcome-title">Selamat Datang!</h2>
        <p class="welcome-text">Sistem ini mempermudah pengajuan dan pengelolaan surat akademik. Silakan pilih peran Anda.</p>
        
        <div class="role-selection">
            <div class="role-card" onclick="window.location.href='{{ route('login.mahasiswa') }}'">
                <i class="fas fa-user-graduate"></i>
                <h4>Mahasiswa</h4>
                <p>Ajukan surat dan pantau status pengajuan dengan mudah.</p>
                <a href="{{ route('login.mahasiswa') }}" class="btn-role">Login Mahasiswa</a>
            </div>
            <div class="role-card" onclick="window.location.href='{{ route('login.pegawai') }}'">
                <i class="fas fa-user-tie"></i>
                <h4>Pegawai</h4>
                <p>Kelola dan proses pengajuan surat dengan efisien.</p>
                <a href="{{ route('login.pegawai') }}" class="btn-role">Login Pegawai</a>
            </div>
        </div>
        
        <footer>&copy; 2025 Sistem Akademik.</footer>
    </div>
</body>
</html>
