<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\User;
use Suitcore\Repositories\SuitRepository;

class UserRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new User;
    }
    
    /**
     * Create new user from registration form.
     * @param  \App\Http\Requests\SignupRequest $request
     * @return void
     */
    public function createUserRole($request)
    {
        $user = new User();
        $user->role = 'user';
        $user->username = $request['email'];
        $user->email = $request['email'];
        $user->password = \Hash::make($request['password']);
        $user->name = $request['first_name'] . ' ' . $request['last_name'];
        $user->birthdate = \Carbon\Carbon::createFromTimeStamp(strtotime($request['date_of_birth']))->toDateString();
        $user->phone_number = $request['phone'];
        $user->dp_card_number = $request['dp_card_number'];
        $user->registration_date = \Carbon\Carbon::now();
        $user->last_visit = \Carbon\Carbon::now();
        $user->activation_code = $this->generateActivationCode();
        $user->save();
        return $user;
    }

    /**
     * Generate unique activation code for new user.
     * @return string
     */
    public function generateActivationCode()
    {
        $number = str_random(32);
        if (User::where('activation_code', $number)->exists()) {
            return generateActivationCode();
        }
        return $number;
    }

    /**
     * Send user activation link to email.
     * @return void
     */
    public function sendUserActivationCode($userId)
    {
        $user = User::find($userId);
        \Mail::queue(
            'emails.user-activation',
            ['user' => $user],
            function ($message) use ($user) {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($user->email);
                $message->subject('Activate your account');
            }
        );
    }
}
