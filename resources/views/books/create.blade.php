@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="container my-4">

    {{-- Header --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">Tambah Buku</h4>
                <small class="text-muted">Masukkan data buku baru ke sistem</small>
            </div>

            <button type="submit" form="form-book" class="btn btn-primary btn-sm">
                Simpan
            </button>
        </div>
    </div>

    {{-- Form --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form id="form-book"
                  action="{{ route('books.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- Kode Buku --}}
                <div class="mb-3">
                    <label class="form-label">Kode Buku</label>
                    <input type="text"
                        name="book_code"
                        value="{{ old('book_code') }}"
                        class="form-control @error('book_code') is-invalid @enderror"
                        placeholder="AA456">

                    @error('book_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Stock --}}
                <div class="mb-3">
                    <label class="form-label">Stock Buku</label>
                    <input type="number"
                        name="stock"
                        value="{{ old('stock', 0) }}"
                        class="form-control @error('stock') is-invalid @enderror"
                        min="0">

                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @php
                        $stockPreview = old('stock', 0);
                    @endphp

                    <div class="mt-2">
                        @if($stockPreview > 5)
                            <span class="badge bg-success">Stok Aman</span>
                        @elseif($stockPreview > 0)
                            <span class="badge bg-warning text-dark">Stok Menipis</span>
                        @else
                            <span class="badge bg-danger">Stok Habis</span>
                        @endif
                    </div>
                </div>

                {{-- Judul --}}
                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="Contoh: Laravel Untuk Pemula">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text"
                        name="author"
                        value="{{ old('author') }}"
                        class="form-control @error('author') is-invalid @enderror"
                        placeholder="Nama penulis">

                    @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Penerbit --}}
                <div class="mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text"
                        name="publisher"
                        value="{{ old('publisher') }}"
                        class="form-control @error('publisher') is-invalid @enderror"
                        placeholder="Nama penerbit">

                    @error('publisher')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tahun --}}
                <div class="mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number"
                        name="year"
                        value="{{ old('year') }}"
                        class="form-control @error('year') is-invalid @enderror"
                        placeholder="2024">

                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Cover Buku --}}
                <div class="mb-3">
                    <label class="form-label">Cover Buku</label>
                    <input type="file"
                        name="image"
                        class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="text-muted">
                        Format: JPG, JPEG, PNG (Max 2MB)
                    </small>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection