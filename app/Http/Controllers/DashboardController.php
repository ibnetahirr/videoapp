<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    public function index()
    {
        $creators = User::where('role','creator')->get();
        return view('admin.dashboard', compact('creators'));
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Redirect or return a success message
        return redirect()->route('dashboard')->with('success', 'User created successfully!');
    }
}
