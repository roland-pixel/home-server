<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        $uploads = Upload::latest()->get();
        return view('upload', compact('uploads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048000', // max 2 GB (dalam KB)
            'judul' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        $mime = $file->getMimeType();
        $tipe = str_contains($mime, 'image') ? 'image'
            : (str_contains($mime, 'video') ? 'video' : 'file');

        Upload::create([
            'judul' => $request->judul,
            'tipe' => $tipe,
            'path' => $path,
            'ukuran' => $file->getSize(),
        ]);

        return redirect()->back()->with('success', 'File berhasil diupload!');
    }
}
