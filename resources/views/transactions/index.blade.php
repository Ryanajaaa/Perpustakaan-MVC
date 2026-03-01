@extends('layouts.app')

@section('title', 'Dashboard Transaksi')

@section('content')
<div class="container my-4">

    {{-- Header --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold">Dashboard Transaksi</h4>
                <small class="text-muted">Data peminjaman & pengembalian buku</small>
            </div>

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('transactions.create') }}" 
                   class="btn btn-primary btn-sm">
                    + Tambah Transaksi
                </a>
            @endif
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Judul Buku</th>
                        <th>Kode</th>

                        @if (Auth::user()->role === 'admin')
                            <th>Peminjam</th>
                        @endif

                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="220">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>

                            {{-- ID --}}
                            <td>{{ $transaction->id }}</td>

                            {{-- Buku --}}
                            <td>{{ $transaction->book->title }}</td>
                            <td>{{ $transaction->book->book_code }}</td>

                            {{-- Peminjam --}}
                            @if (Auth::user()->role === 'admin')
                                <td>{{ $transaction->user->name }}</td>
                            @endif

                            {{-- Tanggal --}}
                            <td>
                                {{ \Carbon\Carbon::parse($transaction->borrowed_at)->format('d M Y') }}
                            </td>

                            <td>
                                {{ $transaction->returned_at 
                                    ? \Carbon\Carbon::parse($transaction->returned_at)->format('d M Y') 
                                    : '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if ($transaction->status === 'borrowed')
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="badge bg-success px-3 py-2">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">

                                {{-- EDIT (Admin only) --}}
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                                       class="btn btn-sm btn-info text-white">
                                        Edit
                                    </a>
                                @endif

                                {{-- RETURN --}}
                                @if ($transaction->status === 'borrowed')
                                    <form action="{{ route('transactions.return', $transaction->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-warning">
                                            Return
                                        </button>
                                    </form>
                                @endif

                                {{-- DELETE (Admin only & returned only) --}}
                                @if (Auth::user()->role === 'admin' && $transaction->status === 'returned')
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Tidak ada data transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection