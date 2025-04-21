<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminLoginController extends Controller
{
    public function showForm()
    {
        return view('admin.login'); // Pointing to the Blade view for the login form
    }

    // Method to handle login form submission
    public function submitForm(Request $request)
    {
        // Validate the form inputs
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $validated['email'])->first();

        if ($user) {
            session(['_auth' => true]);
            session()->save();
            return redirect()->route('home');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }//
}