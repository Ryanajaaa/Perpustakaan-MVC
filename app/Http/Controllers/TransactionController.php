<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // ===============================
    // LIST TRANSAKSI
    // ===============================
    public function index()
    {
        $query = Transaction::with(['book', 'user'])->latest();

        if (Auth::user()->role === 'member') {
            $query->where('user_id', Auth::id());
        }

        $transactions = $query->get();

        return view('transactions.index', compact('transactions'));
    }

    // ===============================
    // FORM TAMBAH TRANSAKSI
    // ===============================
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('transactions.create', [
            'books' => Book::where('stock', '>', 0)->get(),
            'users' => User::where('role', 'member')->get(),
        ]);
    }

    // ===============================
    // SIMPAN PEMINJAMAN
    // ===============================
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            return back()->with('error', 'Stock buku habis');
        }

        Transaction::create([
            'book_id'     => $book->id,
            'user_id'     => $request->user_id,
            'borrowed_at' => now()->toDateString(),
            'status'      => 'borrowed',
        ]);

        $book->decrement('stock');

        return redirect()->route('transactions.index')
            ->with('success', 'Buku berhasil dipinjam');
    }

    // ===============================
    // FORM EDIT
    // ===============================
    public function edit(Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('transactions.edit', [
            'transaction' => $transaction,
            'books' => Book::all(),
            'users' => User::where('role', 'member')->get(),
        ]);
    }

    // ===============================
    // UPDATE TRANSAKSI
    // ===============================
    public function update(Request $request, Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'status'  => 'required|in:borrowed,returned',
        ]);

        $oldBook = $transaction->book;
        $newBook = Book::findOrFail($request->book_id);

        // Jika buku diganti
        if ($oldBook->id != $newBook->id) {

            // kembalikan stock buku lama jika masih borrowed
            if ($transaction->status === 'borrowed') {
                $oldBook->increment('stock');
            }

            if ($newBook->stock <= 0) {
                return back()->with('error', 'Stock buku baru habis');
            }

            if ($request->status === 'borrowed') {
                $newBook->decrement('stock');
            }
        }

        // Jika status berubah borrowed → returned
        if ($transaction->status === 'borrowed' && $request->status === 'returned') {
            $newBook->increment('stock');
        }

        // Jika status berubah returned → borrowed
        if ($transaction->status === 'returned' && $request->status === 'borrowed') {
            if ($newBook->stock <= 0) {
                return back()->with('error', 'Stock buku habis');
            }
            $newBook->decrement('stock');
        }

        $transaction->update([
            'book_id' => $request->book_id,
            'user_id' => $request->user_id,
            'status'  => $request->status,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diupdate');
    }

    // ===============================
    // RETURN BUKU (KHUSUS BUTTON RETURN)
    // ===============================
    public function return(Transaction $transaction)
    {
        if (
            Auth::user()->role === 'member' &&
            $transaction->user_id !== Auth::id()
        ) {
            abort(403);
        }

        if ($transaction->status === 'returned') {
            return redirect()
                ->route('transactions.index')
                ->with('error', 'Buku sudah dikembalikan');
        }

        $transaction->update([
            'returned_at' => now()->toDateString(),
            'status'      => 'returned',
        ]);

        $transaction->book->increment('stock');

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Buku berhasil dikembalikan');
    }

    // ===============================
    // HAPUS TRANSAKSI
    // ===============================
    public function destroy(Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($transaction->status === 'borrowed') {
            return redirect()
                ->route('transactions.index')
                ->with('error', 'Tidak bisa hapus, buku masih dipinjam');
        }

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}