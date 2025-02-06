<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Toastr;
use Validator;
use Auth;

class AuthController extends Controller
{
    // Display the login form
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function handleLogin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }
        
        $credentials = $request->only('email', 'password');

        // Check if the user exists
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            // Verify the password
            if (Hash::check($credentials['password'], $user->password)) {
                Auth::login($user); // Log in the user
                $request->session()->regenerate();

                Toastr::success('Logged in successfully!', 'Success');
                return redirect()->intended('home');
            }

            // Password is incorrect
            Toastr::error('The provided password is incorrect.', 'Error');
        } else {
            // Email does not exist
            Toastr::error('No account found with the provided email.', 'Error');
        }

        // Redirect back with the email pre-filled
        return redirect()->back()->withInput(['email' => $request->email]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // Invalidate the session
        $request->session()->invalidate();
        // Regenerate the CSRF token to prevent attacks
        $request->session()->regenerateToken();
        Toastr::success('Logged out successfully!', 'Success');
        return redirect('/login');
    }

}
