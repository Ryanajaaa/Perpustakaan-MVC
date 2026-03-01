<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    // ✅ STORE (SIMPAN BUKU + GAMBAR + STOCK)
    public function store(Request $request)
    {
        $request->validate([
            'book_code' => 'required|string|max:50',
            'title'     => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year'      => 'required|digits:4',
            'stock'     => 'required|integer|min:0',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }

        Book::create([
            'book_code' => $request->book_code,
            'title'     => $request->title,
            'author'    => $request->author,
            'publisher' => $request->publisher,
            'year'      => $request->year,
            'stock'     => $request->stock,
            'image'     => $imagePath,
        ]);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // ✅ UPDATE (SUPPORT GANTI GAMBAR)
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'book_code' => 'required|string|max:50',
            'title'     => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year'      => 'required|digits:4',
            'stock'     => 'required|integer|min:0',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($book->image && Storage::exists('public/' . $book->image)) {
                Storage::delete('public/' . $book->image);
            }

            $data['image'] = $request->file('image')
                                     ->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    // ✅ BORROW (KURANGI STOCK)
    public function borrow(Book $book)
    {
        if ($book->stock <= 0) {
            return redirect()->route('books.index')
                ->with('error', 'Stok buku habis');
        }

        Transaction::create([
            'user_id'     => Auth::id(),
            'book_id'     => $book->id,
            'borrowed_at' => now()->toDateString(),
            'status'      => 'borrowed',
        ]);

        $book->decrement('stock');

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dipinjam');
    }

    // ✅ RETURN (TAMBAH STOCK)
    public function returnBook(Book $book)
    {
        $transaction = Transaction::where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if (!$transaction) {
            return redirect()->route('books.index')
                ->with('error', 'Tidak ada transaksi aktif');
        }

        $transaction->update([
            'status'      => 'returned',
            'returned_at' => now()->toDateString(),
        ]);

        $book->increment('stock');

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dikembalikan');
    }

    // ✅ DELETE (HAPUS GAMBAR JUGA)
    public function destroy(Book $book)
    {
        if (Transaction::where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists()) {

            return redirect()->route('books.index')
                ->with('error', 'Tidak bisa hapus, buku sedang dipinjam');
        }

        // hapus gambar jika ada
        if ($book->image && Storage::exists('public/' . $book->image)) {
            Storage::delete('public/' . $book->image);
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}