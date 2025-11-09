<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display login form.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle login attempt.
     */
    public function store(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                return redirect('/');
            }

            return back()
                ->with('error', 'The provided credentials do not match our records.')
                ->withInput($request->only('username'));

        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error('Login failed: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Login failed. Please try again.')
                ->withInput($request->only('username'));
        }
    }

    /**
     * Logout user.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}