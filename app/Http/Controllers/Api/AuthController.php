<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\User;
use App\SuitEvent\Models\UserToken;
use App\SuitEvent\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Validation\ValidationException;
use Mail;

/**
 * @property-read UserRepository
 */
class AuthController extends BaseController
{
    /**
     * New AuthController instance
     *
     * @param UserRepository $repository
     * @param User $model
     */
    public function __construct(UserRepository $repository, User $model)
    {
        parent::__construct($repository, $model);
        if (\Auth::check()) {
            $this->authUser = \Auth::user();
        }
    }

    /**
     * @api POST api/v1/login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credential = $request->only('email', 'password');

        $user = User::where('email', $credential['email'])->first();

        if (!$user) {
            return $this->toJson(400, [
                'message' => 'Login failed! User not found'
            ]);
        }

        if ($user->status == User::STATUS_INACTIVE) {
            return $this->toJson(400, [
                'message' => 'Login failed! User is not activated yet.',
            ]);
        }

        if ($user->status == User::STATUS_UNREGISTERED) {
            $user->update([
                'status' => User::STATUS_ACTIVE
            ]);
        }

        if (\Hash::check($credential['password'], $user->password)) {
            $userToken = $this->loginOnce($user);

            return $this->toJson(200, [
                'message' => 'Login success',
                'result' => [
                    'token' => $userToken->token,
                    'user' => $user->toApi()
                ]
            ]);
        }

        return $this->toJson(40, ['message' => 'Login failed! Wrong email or password']);
    }

    /**
     * @api POST /v1/user/logout
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function logout(Request $request)
    {
        $userToken = $request->get('token');
        $userToken = UserToken::where('token', $userToken)->first();
        if ($userToken) {
            if ($userToken->delete()) {
                return $this->toJson(200, ['message' => 'Logout Success, session ended']);
            } else {
                return $this->toJson(400, ['message' => 'Invalid token!']);
            }
        }

        return $this->toJson(400, ['message' => 'Logout Failed, there is no logged in user in current session!']);
    }
}
