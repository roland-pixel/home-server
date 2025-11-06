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

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    <h1 class="text-2xl font-semibold mb-4">Upload File</h1>

    @if (session('success'))
        <div class="text-green-600 mb-3">{{ session('success') }}</div>
    @endif

    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 w-full max-w-md">
        @csrf
        <input type="text" name="judul" placeholder="Judul (opsional)" class="border p-2 rounded">
        <input type="file" name="file" class="border p-2 rounded" required>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Upload</button>
    </form>

    <div class="mt-8 w-full max-w-2xl">
        <h2 class="text-xl font-medium mb-3">Daftar File</h2>

        <div class="grid gap-4">
            @foreach ($uploads as $item)
                <div class="border p-3 rounded">
                    <p class="font-semibold">{{ $item->judul ?? 'Tanpa Judul' }}</p>
                    <p class="text-sm text-gray-600">{{ strtoupper($item->tipe) }} - {{ number_format($item->ukuran / 1048576, 2) }} MB</p>

                    @if ($item->tipe === 'image')
                        <img src="{{ asset('storage/' . $item->path) }}" alt="" class="mt-2 rounded max-h-48">
                    @elseif ($item->tipe === 'video')
                        <video controls class="mt-2 rounded max-h-64 w-full">
                            <source src="{{ asset('storage/' . $item->path) }}" type="video/mp4">
                            Browser Anda tidak mendukung video.
                        </video>
                    @else
                        <a href="{{ asset('storage/' . $item->path) }}" class="text-blue-500 mt-2 inline-block" download>Unduh File</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
