<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judulHalaman ?? 'Sistem Peminjaman Ruang Kampus' }} - UCIC PBO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body>
    <header>
        <div class="brand">
            <h1>Sistem Peminjaman Ruang Kampus (UCIC)</h1>
            <p>Pranaja Gathan Aqila (20251020012) &bull; PBO Pertemuan 7 (Routing, Controller &amp; Blade)</p>
        </div>
        <nav>
            <a href="{{ route('ruang.index') }}">Daftar Ruang</a>
            <a href="{{ route('ruang.peminjaman') }}">Data Peminjaman</a>
            <a href="{{ route('ruang.peminjaman', 'disetujui') }}">Filter: Disetujui</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; 2026 Program Studi Teknik Informatika - Universitas Catur Insan Cendekia. Dibangun dengan Laravel 13 &amp; Clean OOP.
    </footer>
</body>
</html>