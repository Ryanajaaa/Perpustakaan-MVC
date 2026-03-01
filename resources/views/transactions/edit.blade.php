@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="container my-4">

    {{-- Header --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold">Edit Transaksi</h4>
                <small class="text-muted">Perbarui data transaksi</small>
            </div>

            <div>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm me-2">
                    Kembali
                </a>

                <button type="submit" form="form-transaction" class="btn btn-primary btn-sm">
                    Update
                </button>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form id="form-transaction"
                  action="{{ route('transactions.update', $transaction->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                {{-- Buku --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Buku</label>
                    <select name="book_id" class="form-control">
                        @foreach($books as $book)
                            <option value="{{ $book->id }}"
                                {{ $transaction->book_id == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} (Stock: {{ $book->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- User --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Peminjam</label>
                    <select name="user_id" class="form-control">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $transaction->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-control">
                        <option value="borrowed"
                            {{ $transaction->status == 'borrowed' ? 'selected' : '' }}>
                            Dipinjam
                        </option>
                        <option value="returned"
                            {{ $transaction->status == 'returned' ? 'selected' : '' }}>
                            Dikembalikan
                        </option>
                    </select>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection