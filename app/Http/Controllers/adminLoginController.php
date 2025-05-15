<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminLoginController
{
    public function showForm()
    {
        return view('admin.login');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $validated['email'])->where('password', $validated['password'])->first();

        if ($user) {
            session(['_auth' => true]);
            session()->save();
            return redirect()->route('home');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }//
}
