<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Terms and Conditions' }}</title>
    <!-- Tambahkan stylesheet atau script yang diperlukan -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Header Khusus untuk Halaman Terms -->
    <header>
        <div class="container">
            <h1>Terms and Conditions</h1>
        </div>
    </header>

    <!-- Konten Utama -->
    <main>
        <div class="container">
            {{ $slot }} <!-- Gunakan $slot untuk menampilkan konten dari Livewire -->
            <livewire:pages.auth.terms />
        </div>
    </main>

    <!-- Footer Khusus untuk Halaman Terms -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </footer>

    <!-- Tambahkan script JS jika diperlukan -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>