<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('profile.auth.signin');
    }

    public function login(Request $request, User $users, Project $projects)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $users = User::all();
        $projects = Project::all();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return view('welcome', compact("users", "projects"))->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid email!', 'password' => 'Invalid password!'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
