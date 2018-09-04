<?php

namespace App\Http\Controllers\Backend;

use App;
use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\User;
use App\SuitEvent\Repositories\UserRepository;
use Auth;
use Illuminate\Http\Request;
use Redirect;
use View;

class AdminUserController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  UserRepository $_baseRepo
     * @param  User $_baseModel
     * @return void
     */
    public function __construct(UserRepository $_baseRepo, User $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.useraccount";
        $this->routeDefaultIndex = "backend.useraccount.index";
        $this->viewBaseClosure = "backend.admin.users";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'A3';
        View::share('pageId', $this->pageId);
        View::share('pageTitle', 'User Account');
        View::share('pageIcon', 'icon-user');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }

    public function getAccount()
    {
        $user = auth()->user();
        return view($this->viewBaseClosure . '.useraccount', compact('user'));
    }

    public function postAccount(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string'
        ];

        $this->validate($request, $rules);

        $user->update([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'phone_number' => trim($request->phone_number)
        ]);

       /* if ($user->status == User::STATUS_INACTIVE) {
            $user->activation_code = $this->userRepo->generateActivationCode();
            $user->save();
            $user->notify('UserActivation', route('frontend.user.activation.post', $user->activation_code), $user);

            session()->put('notif_success', 'Link aktivasi akun sudah dikirim ke email Anda');
            return redirect()->back();
        }*/

        $this->showNotification(self::
            NOTICE_NOTIFICATION, 'Update profile berhasil', 'Berhasil memperbarui profile Anda');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'old_password' => 'required_with:password',
            'password' => 'required_with:old_password|confirmed|min:6',
            'password_confirmation' => 'required_with:password,old_password',
        ];

        $this->validate($request, $rules);

        if ($request->old_password != null) {
            if (!\Hash::check($request->old_password, $user->password)) {
                $this->showNotification(
                    self::
                    ERROR_NOTIFICATION,
                    'Update password failed',
                    'Password lama yang Anda masukkan salah, silahkan ulangi kembali'
                );
                return redirect()->back();
            }
        }

        $user->update([
            'password' => \Hash::make($request->password)
        ]);

        $this->showNotification(self::NOTICE_NOTIFICATION, 'Update password berhasil', 'Update password Anda berhasil');
        return redirect()->back();
    }
}
