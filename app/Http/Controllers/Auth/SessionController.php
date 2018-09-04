<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\SuitEvent\Models\OauthUser;
use App\SuitEvent\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Input;
use Redirect;
use Session;
use Socialite;
use Validator;
use View;

class SessionController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return redirect()->route('frontend.home');
    }

    public function create(Request $request)
    {
        return view('session.create');
    }

    public function getUserLogin(Request $request)
    {
        return view('session.user-login');
    }

    /**
     * Authenticate a user.
     * @param  Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'email' => 'required_without:username|email',
            'username' => 'required_without:email',
            'password' => 'required',
        ];
        $this->validate($request, $rules);
        $credentials = [($request->has('email') ? 'email' : 'username'), 'password'];
        // Check if user select 'remember_me' checkbox.
        $remember = $request->has('remember_me') ? true : false;

        if (!auth()->attempt($request->only($credentials), $remember)) {
            \Session::flash('message_error', 'Email atau password Anda salah, silahkan ulangi kembali');
            if ($request->type == "0") { // User login
                return redirect()->route('sessions.user.login')->withInput();
            }
            return redirect()->back()->withInput();
        }

        $user = auth()->user();
        $user->updateLastvisit();

        if (session()->has('redirectTo')) {
            return redirect()->to(session()->pull('redirectTo'));
        }

        if (in_array($user->role, ['admin'])) {
            return redirect()->intended(route('backend.home.index'));
        }

        \Session::flash('notif_success', 'Anda berhasil login ke akun SMILE!');
        return redirect()->intended(route('frontend.home'));
    }

    public function guest(Request $request)
    {
        $email = $request->get('email');
        if ($user = User::whereEmail($email)->where('status', '<>', User::STATUS_UNREGISTERED)->first()) {
            session()->put("message", "Email Anda sudah terdaftar sebagai member. Silakan login dengan email Anda.");
            return redirect()->route('sessions.login', compact('email'));
        }

        $user = User::firstOrCreate(['email' => $email, 'status' => User::STATUS_UNREGISTERED]);
        auth()->loginUsingId($user->id);

        if (session()->has('redirectTo')) {
            return redirect()->to(session()->pull('redirectTo'));
        }

        return redirect()->intended(route('frontend.home'));
    }

    public function destroy()
    {
        $successUpdate = Auth::user()->updateLastvisit();
        if ($successUpdate) {
            Auth::logout();
            if (Session::get('mobilelogout')) {
                Session::forget('mobilelogout');
                return redirect()->route('mobile.home');
            } else {
                return redirect()->route('sessions.login');
            }
        } else {
            return redirect()->route('backend.home.index');
        }
    }

    public function auth($app)
    {
        return Socialite::driver($app)->redirect();
    }

    public function redirectAuth(Request $request, $app)
    {
        $socialite = Socialite::driver($app)->user();
        $socialiteUser = User::where('email', $socialite->email)->first();

        $oauthData = [
            'provider' => $app,
            'oauth_id' => $socialite->id,
        ];

        $oauth = OauthUser::firstOrNew($oauthData);

        $oauthData['graph'] = $socialite;
        $oauth->fill($oauthData);

        if ($user = auth()->user()) {
            $user->oauths()->save($oauth);
            return redirect()->route('sessions.login');
        }

        $oauth->save();

        $user = $oauth->user ?: ($socialiteUser ?: $user);

        // if no user means = need registration
        if ($user == null) {
            $registrationData = [
                'name' => $socialite->name,
                'email' => $socialite->email,
                'username' => $socialite->nickname ?: getUsernameByEmail($socialite->email),
                'oauth_id' => $oauth->id,
            ];

            return redirect()->route('frontend.user.registration')->withInput($registrationData);
        }

        if ($user->isActive()) {
            auth()->loginUsingId($user->id);
        } else {
            Session::put(
                'message',
                'Akun Anda belum aktif, silakan cek email dari kami di inbox atau spambox Anda (' . $user->email . ')'
            );
        }
        return redirect()->route('sessions.login');
    }
}
