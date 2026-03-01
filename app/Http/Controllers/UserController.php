<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\alert;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required',
            'major' => 'required',
            'class' => 'required',
            'username' => 'required|unique:users',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,member',
        ]);

        User::create([
            'school_id' => $request->school_id,
            'major' => $request->major,
            'class' => $request->class,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        // Validasi
        $validated = $request->validate([
            'username'  => 'required|string|max:255|unique:users,username,' . $user->id,
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'school_id' => 'nullable|string|max:50',
            'major'     => 'nullable|string|max:100',
            'class'     => 'nullable|string|max:50',
            'password'  => 'nullable|string|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Data user berhasil diperbarui');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function destroy(User $user)
    {
        $transaksi = Transaction::where('user_id',$user->id)->get();
        if($transaksi->isNotEmpty()){
            abort(403,'sedang ada transaksi');
        }
        
        if ($user->id == Auth::user()->id) {
            abort(403,'');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}