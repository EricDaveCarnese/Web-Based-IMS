<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\UserManagement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{   
    // Show login form
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }
        
        return view('landing');
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fullname' => 'required|string|max:255',
        'email' => 'required|email|unique:user_management',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:admin,user',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $user = UserManagement::create([
        'fullname' => $request->fullname,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make($request->password),
    ]);

    ActivityLog::create([
        'user_id' => $user->id,
        'user_name' => $user->fullname,
        'action' => 'register',
        'module' => 'auth',
        'description' => "New user registered with role: {$user->role}",
        'ip_address' => $request->ip(),
    ]);

    Auth::login($user);

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome Admin ' . $user->fullname . '! Account created successfully.');
    }

    return redirect()->route('user.dashboard')
        ->with('success', 'Welcome ' . $user->fullname . '! Account created successfully.');
}

    public function login(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }
        
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = UserManagement::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Invalid credentials. Please try again.')
                ->withInput();
        }

        Auth::login($user);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'user_name'   => Auth::user()->fullname,
            'action'      => 'login',
            'module'      => 'auth',
            'description' => 'User logged in successfully',
            'ip_address'  => $request->ip(),
        ]);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome Admin ' . $user->fullname . '!');
        } else {
            return redirect()->route('user.dashboard')
                ->with('success', 'Welcome ' . $user->fullname . '!');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id'     => Auth::id(),
                'user_name'   => Auth::user()->fullname,
                'action'      => 'logout',
                'module'      => 'auth',
                'description' => 'User logged out',
                'ip_address'  => $request->ip(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')
            ->with('success', 'Logged out successfully!');
    }
}