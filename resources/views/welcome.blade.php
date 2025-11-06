@php
    use App\Models\Upload;
    $uploads = Upload::latest()->get();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Upload File</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Optional: Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col items-center justify-start min-h-screen p-6 lg:p-8 font-sans">

    <h1 class="text-3xl font-bold mb-6">Upload File</h1>

    @if (session('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 w-full max-w-md bg-white p-6 rounded shadow-md">
        @csrf
        <input type="text" name="judul" placeholder="Judul (opsional)" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="file" name="file" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Upload</button>
    </form>

    <div class="mt-10 w-full max-w-3xl">
        <h2 class="text-2xl font-semibold mb-4">Daftar File</h2>

        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($uploads as $item)
                <div class="border p-4 rounded shadow-sm bg-white">
                    <p class="font-semibold">{{ $item->judul ?? 'Tanpa Judul' }}</p>
                    <p class="text-sm text-gray-600">{{ strtoupper($item->tipe) }} - {{ number_format($item->ukuran / 1048576, 2) }} MB</p>

                    @if ($item->tipe === 'image')
                        <img src="{{ asset('storage/' . $item->path) }}" alt="" class="mt-2 rounded max-h-48 w-full object-contain">
                    @elseif ($item->tipe === 'video')
                        <video controls class="mt-2 rounded max-h-64 w-full">
                            <source src="{{ asset('storage/' . $item->path) }}" type="video/mp4">
                            Browser Anda tidak mendukung video.
                        </video>
                    @else
                        <a href="{{ asset('storage/' . $item->path) }}" class="text-blue-500 mt-2 inline-block hover:underline" download>Unduh File</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
