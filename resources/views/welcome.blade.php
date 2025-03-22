<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1>Welcome</h1>
                <a href="{{ route('login.mahasiswa') }}" class="btn btn-primary mt-3">Login Mahasiswa</a>
                <a href="{{ route('login.pegawai') }}" class="btn btn-secondary mt-3">Login Pegawai</a>
            </div>
        </div>
    </div>
</body>
</html>