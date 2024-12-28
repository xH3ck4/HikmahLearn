<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function loginView(Request $request)
    {
        return Inertia::render('Auth/Login', [
            'title' => 'Login',
        ]);
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            // 'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Gagal login ke akun!',
                'errors' => $validator->errors()
            ], 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = auth()->user();
            $user->tokens()->delete();
            $device = substr($request->userAgent() ?? '', 0, 255);
            $token = $user->createToken($device)->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 30 * 60,
                'message' => 'Login berhasil!'
            ]);
        }
        
        return response()->json([
            'message' => 'Akun yang anda masukkan salah!'
        ], 401);
    }

    public function registerView()
    {
        return Inertia::render('Auth/Register', [
            'title' => 'Register',
        ]);
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nohp' => ['required','string','regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/','min:9','max:14','unique:users'],
            'password' => 'required|string|min:8',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Gagal membuat akun!',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'id' => Str::uuid(),
                'nama' => $request->nama,
                'email' => $request->email,
                'nohp' => $request->nohp,
                'password' => Hash::make($request->password),
                'saldo' => 5000,
                'tgl_pembuatan' => Carbon::now(),
                'apikey' => Str::random(32),
                'wlip' => '',
            ]);

            event(new Registered($user));

            Auth::login($user);
            $request->session()->regenerate();
            
            $device = substr($request->userAgent() ?? '', 0, 255);
            $token = $user->createToken($device)->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat!',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 30 * 60,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat akun!',
                'error' => $e->getMessage()  
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout berhasil!'
        ]);
    }

    public function verifyEmail(Request $request)
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect('/dashboard');
        }

        return Inertia::render('Auth/VerifyEmail',[
            'resendUrl' => route('verification.resend'),
            'title' => 'Verifikasi Email',
        ]);
    }

    public function resendVerifyEmail(Request $request)
    {
        if(Auth::user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email sudah terverifikasi!'
            ], 400);
        }
        try {
            $request->user()->sendEmailVerificationNotification();
        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengirim email verifikasi!'
            ], 500);
        }
        return response()->json([
            'message' => 'Email verifikasi berhasil dikirim!'
        ], 200);
    }

    public function handleVerifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
 
        return redirect('/dashboard');
    }
    
}
