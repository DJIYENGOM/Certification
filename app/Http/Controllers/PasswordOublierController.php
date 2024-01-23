<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordOublierController extends Controller
{
     /**
     * Submit the forget password form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send('EmailReçu', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['message' => 'Nous vous avons envoyé un email de récupération!']);
    }

    /**
     * Show the reset password form.
     *
     * @param  string  $token
 
     */
    public function showResetPasswordForm($token)
    {
        return view('MotPasseOublier', ['token' => $token]);    
    }

    /**
     * Submit the reset password form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'token' => $request->token,
            ])
            ->first();

        if (!$updatePassword) {
            return response()->json(['error' => 'données invalides!'], 422);
        }
        
        $user= DB::table('password_reset_tokens')->where(['token' => $request->token])->first();

       User::where('email', $user->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['token' => $request->token])->delete();

        return response()->json(['message' => 'Votre mot de passe a ete mis a jour']);
    }
}
