@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="container my-4">

    {{-- Header --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">Edit Buku</h4>
                <small class="text-muted">Perbarui data buku di sistem</small>
            </div>

            <button type="submit" form="form-book" class="btn btn-primary btn-sm">
                Update
            </button>
        </div>
    </div>

    {{-- Form --}}
    <div class="card shadow-sm">
        <div class="card-body">
            {{-- ⚠️ Tambahkan enctype="multipart/form-data" untuk upload file --}}
            <form id="form-book"
                action="{{ route('books.update', $book->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Kode Buku --}}
                <div class="mb-3">
                    <label class="form-label">Kode Buku</label>
                    <input type="text"
                        name="book_code"
                        value="{{ old('book_code', $book->book_code) }}"
                        class="form-control @error('book_code') is-invalid @enderror">

                    @error('book_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>  

                {{-- Stock --}}
                <div class="mb-3">
                    <label class="form-label">Stock Buku</label>
                    <input type="number"
                        name="stock"
                        value="{{ old('stock', $book->stock ?? 0) }}"
                        class="form-control @error('stock') is-invalid @enderror"
                        min="0">

                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Status Stock --}}
                    <div class="mt-2">
                        @if(($book->stock ?? 0) > 5)
                            <span class="badge bg-success">
                                Stok Aman ({{ $book->stock }} tersedia)
                            </span>
                        @elseif(($book->stock ?? 0) > 0)
                            <span class="badge bg-warning text-dark">
                                Stok Menipis ({{ $book->stock }} tersisa)
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Stok Habis
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Judul --}}
                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text"
                        name="title"
                        value="{{ old('title', $book->title) }}"
                        class="form-control @error('title') is-invalid @enderror">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text"
                        name="author"
                        value="{{ old('author', $book->author) }}"
                        class="form-control @error('author') is-invalid @enderror">

                    @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Penerbit --}}
                <div class="mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text"
                        name="publisher"
                        value="{{ old('publisher', $book->publisher) }}"
                        class="form-control @error('publisher') is-invalid @enderror">

                    @error('publisher')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tahun --}}
                <div class="mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number"
                        name="year"
                        value="{{ old('year', $book->year) }}"
                        class="form-control @error('year') is-invalid @enderror">

                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 🖼️ Upload Gambar Cover --}}
                <div class="mb-3">
                    <label class="form-label">Cover Buku</label>
                    
                    {{-- Preview Gambar Lama --}}
                    @if($book->image)
                        <div class="mb-3">
                            <p class="mb-2 text-muted small">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $book->image) }}" 
                                 alt="Cover {{ $book->title }}" 
                                 class="img-thumbnail" 
                                 style="max-height: 200px; max-width: 100%; object-fit: contain;">
                        </div>
                    @else
                        <div class="mb-3">
                            <span class="badge bg-secondary">
                                <i class="bi bi-image"></i> Belum ada gambar
                            </span>
                        </div>
                    @endif

                    {{-- Input File Upload --}}
                    <input type="file" 
                           name="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*">

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> 
                        Kosongkan jika tidak ingin mengubah cover buku. 
                        Maksimal 2MB (JPG, PNG, GIF, WebP).
                    </small>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection