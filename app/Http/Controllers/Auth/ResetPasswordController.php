<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class ResetPasswordController extends Controller
{

    public function viewResetPassword(Request $request)
    {
        return Inertia::render('Auth/ResetPassword', [
            'title' => 'Reset Password'
        ]);
    }

    public function tokenResetPasswordView(Request $request, $token)
    {
        $cekUser = User::where('email', $request->email)->first();
        if (!$cekUser) {
            return response()->json([
                'status' => 404,
                'message' => 'Email tidak ditemukan!'
            ], 404);
        }

        return Inertia::render('Auth/ResetPasswordToken', [
            'title' => 'Reset Password',
            'email' => $request->email,
            'token' => $token
        ]);
    }

    public function sendResetLink(Request $request)
    {
        $cekUser = User::where('email', $request->email)->first();
        if (!$cekUser) {
            return response()->json([
                'status' => 404,
                'message' => 'Email tidak ditemukan!'
            ], 404);
        }

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['message' => 'Link reset password sudah dikirimkan ke email anda!'], 200)
                    : response()->json(['message' => 'Gagal mengirimkan link reset password!'], 400);
    }

    public function newPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? response()->json(['message' => 'Password berhasil diubah!'], 200)
                    : response()->json(['message' => __($status)], 400);
    }

    public function updateProfilePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        $user = $request->user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 400,
                'message' => 'Password lama tidak sesuai!'
            ], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => 'Password berhasil diubah!'
        ]);
    }
}
