@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container my-5">

    {{-- Header --}}
    <div class="card border shadow-sm mb-4 bg-white">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">
                    Dashboard Buku
                </h3>
                <small class="text-muted">
                    Ringkasan data buku di sistem perpustakaan
                </small>
            </div>

            @if (Auth::user()->role == 'admin')
                <a href="{{ route('books.create') }}" 
                   class="btn btn-primary px-4">
                    Tambah Buku
                </a>
            @endif
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border shadow-sm bg-white">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th>Cover</th>
                            <th class="text-start">Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Stock</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr class="text-center">

                                {{-- COVER --}}
                                <td>
                                    @if($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}"
                                             width="60"
                                             height="80"
                                             class="rounded shadow-sm"
                                             style="object-fit: cover;">
                                    @else
                                        <span class="text-muted small">
                                            No Image
                                        </span>
                                    @endif
                                </td>

                                {{-- JUDUL --}}
                                <td class="fw-semibold text-start">
                                    {{ $book->title }}
                                </td>

                                {{-- PENULIS --}}
                                <td>
                                    {{ $book->author }}
                                </td>

                                {{-- PENERBIT --}}
                                <td>
                                    {{ $book->publisher }}
                                </td>

                                {{-- TAHUN --}}
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $book->year }}
                                    </span>
                                </td>

                                {{-- STOCK --}}
                                <td>
                                    @if($book->stock > 0)
                                        <span class="badge bg-success px-3 py-2">
                                            {{ $book->stock }} tersedia
                                        </span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">
                                            Habis
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>

                                    @if (Auth::user()->role == 'admin')

                                        <a href="{{ route('books.edit', $book->id) }}"
                                           class="btn btn-warning btn-sm me-1">
                                            Edit
                                        </a>

                                        <form action="{{ route('books.destroy', $book->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form>

                                    @else

                                        @if ($book->stock > 0)
                                            <form method="POST"
                                                  action="{{ route('transactions.borrow', $book->id) }}">
                                                @csrf
                                                <button class="btn btn-success btn-sm">
                                                    Pinjam
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2">
                                                Tidak Tersedia
                                            </span>
                                        @endif

                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    Tidak ada data buku
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection