<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Settings;
use App\SuitEvent\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class SettingController extends BaseController
{
    protected $defaultParams = [
        'orderBy' => 'created_at',
        'orderType' => 'desc'
    ];

    /**
     * Initialize
     *
     * @param SettingsRepository $repository
     * @param Settings           $model
     */
    public function __construct(
        SettingsRepository $repository,
        Settings $model
    ) {
        parent::__construct($repository, $model);
    }
}
