<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>

        <form method="POST" action="{{ request()->routeIs('login.mahasiswa') ? route('login.mahasiswa') : route('login.pegawai') }}">
            @csrf
        
            <!-- ID User (NRP/NIP) -->
            <div class="mb-4">
                <label for="id_user" class="block text-sm font-medium text-gray-700">
                    {{ request()->routeIs('login.mahasiswa') ? 'NRP' : 'NIP' }}
                </label>
                <input id="id_user" type="text"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    name="{{ request()->routeIs('login.mahasiswa') ? 'nrp' : 'nip' }}" value="{{ old('id_user') }}" required autofocus>
            </div>
        
            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    name="password" required>
            </div>
        
            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Login
                </button>
            </div>
        </form>
        
    </div>
</body>

</html>
