<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\User;
use App\SuitEvent\Models\UserToken;
use Auth;
use Carbon\Carbon;
use HTML;
use Illuminate\Http\Request;
use Input;
use Suitcore\Controllers\ApiController;
use Suitcore\Models\SuitModel;
use Suitcore\Repositories\SuitRepository;

class BaseController extends ApiController
{
    /**
     * @var UserToken
     */
    protected $authToken;

    public function __construct(SuitRepository $repository, SuitModel $model)
    {
        parent::__construct($repository, $model);

        $this->detectGlobalParam();
    }

    /**
     * Login once using user instance.
     *
     * @param User $user
     * @return UserToken
     */
    protected function loginOnce(User $user)
    {
        $userToken = UserToken::getUserTokenFromUser($user);

        Auth::onceUsingId($userToken->user_id);

        $user->updateLastvisit();

        return $userToken;
    }

    protected function detectGlobalParam()
    {
        // Global Params
        if (Input::has('current_latitude') && Input::has('current_longitude')) {
            // -- begin save user position if have a long distance (> 2km) from last position
            if ($this->authUser) {
                try {
                } catch (\Exception $e) {
                }
            }
            // -- end save user position
        }

        if (Input::has('current_gcm_id')) {
            if ($this->authUser) {
                $token = Input::get('token');
                $gcmRegistrationId = Input::get('current_gcm_id');
                $lastUsed = Carbon::now();
                $userToken = UserToken::where('token', $token)->firstOrFail();
                $userToken->update(compact('gcmRegistrationId', 'lastUsed'));
            }
        }
    }

    protected function getAccessTokenUser($token)
    {
        $userToken = UserToken::where('token', $token)->first();
        if ($userToken && $userToken->user) {
            return $userToken->user;
        }
        return null;
    }
}
