<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
        {
            $validated = $request->validate([
                'school_id' => 'required|unique:users|regex:/^\d{9}$/',
                'name' => 'required',
                'class' => 'required',
                'major' => 'required',
                'username' => 'required|unique:users|min:8',
                'password' => 'required|min:8|confirmed',
        ]);


        $validated['email'] = $validated['school_id'] . '@student.smktelkom-jkt.sch.id';
        $validated['name'] = strtoupper($validated['name']);
        $validated['class'] = strtoupper($validated['class']);
        $validated['major'] = strtoupper($validated['major']);
        $validated['username'] = strtolower($validated['username']);
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'member';

        User::create($validated);

        return redirect()->route('login')->with('success', '');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('books.index');
        }

        return back()->withErrors([
            'message' => 'Username atau password salah.',
        ]);
    }

    public function showlogin(){
        return view('auth.login');
        }
    public function showregister(){
        return view('auth.register');
        }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout.');
    }
}