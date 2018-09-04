<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $email = PasswordReset::where('token', $token)->firstOrFail()->email;

        view()->share([
            'url' => route('frontend.user.resetpassword', [$token]),
            'title' => 'Reset My Password'
        ]);

        return view('frontend.auth.reset-password')->with(
            ['token' => $token, 'email' => $email]
        );
    }

    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => \Hash::make($password)
        ])->save();

        \Auth::login($user);
        \Session::flash('notif_success', 'Password Anda berhasil diperbarui');
    }
}
