<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Mahasiswa</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background: white;
      color: #2c3e50;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .container {
      background: linear-gradient(135deg, #667eea, #764ba2);
      padding: 50px;
      border-radius: 20px;
      backdrop-filter: blur(12px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      width: 90%;
      max-width: 420px;
      text-align: center;
    }

    h4 {
      font-size: 1.8rem;
      font-weight: 700;
      color: white;
    }

    p {
      font-size: 1.2rem;
      opacity: 0.85;
      color: white;
    }

    .form-group {
      position: relative;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      padding-left: 40px;
      height: 50px;
      border-radius: 10px;
    }

    .form-control::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .form-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: rgba(255, 255, 255, 0.8);
    }

    .btn-custom,
    .btn-back {
      background: #ffcc00;
      color: #141e30;
      font-weight: bold;
      transition: 0.3s ease-in-out;
      border-radius: 50px;
      padding: 12px;
      font-size: 1.2rem;
      border: none;
      width: 100%;
    }

    .btn-custom:hover,
    .btn-back:hover {
      background: #db57f5d8;
      color: white;
    }

    /* Error message styling (oranye) */
    .text-error {
      color: #ffcc00;
      font-size: 0.95rem;
      text-align: left;
      margin-top: 5px;
      padding-left: 5px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h4>Mahasiswa</h4>
    <br>
    <br>
    <p>Silakan login untuk mengakses sistem pengajuan surat akademik.</p>

    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ url('/login/mahasiswa') }}">
      @csrf
      <div class="form-group">
        <i class="fas fa-user form-icon"></i>
        <input type="text" class="form-control" id="nrp" name="nrp" placeholder="NRP" value="{{ old('nrp') }}" required autofocus>
        @error('nrp')
          <div class="text-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <i class="fas fa-lock form-icon"></i>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
      </div>
      @error('password')
        <div class="text-error">{{ $message }}</div>
      @enderror

      <button type="submit" class="btn btn-custom btn-block">Login</button>
      <button type="button" class="btn-back btn-block mt-2" onclick="window.history.back();">Back</button>
    </form>
  </div>
</body>

</html>
