<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Siswa - Lab TKJ</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7fe; }
        .header { color: #2D31FA; padding: 20px; }
        .card-container { display: flex; gap: 20px; padding: 20px; }
        .card { background: white; padding: 15px; border-radius: 10px; width: 200px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <div class="header">
        <h1>Selamat Datang, {{ Auth::user()->name ?? 'Siswa' }}!</h1>
        <p>Silakan pilih alat yang ingin kamu pinjam di Lab TKJ.</p>
    </div>

    <div class="card-container">
        @foreach($semuaAlat as $item)
            <div class="card">
                <h3>{{ $item->nama_alat }}</h3>
                <p>Status: Tersedia</p> 
                <a href="#">Lihat Detail</a>
            </div>
        @endforeach
    </div>

</body>
</html>