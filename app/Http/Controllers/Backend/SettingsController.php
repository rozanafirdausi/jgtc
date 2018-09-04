<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Models\Settings;
use App\SuitEvent\Repositories\SettingsRepository;
use File;
use Input;
use Redirect;
use View;

class SettingsController extends BaseController
{
    // PROPERTIES
    // Default Services / Repository
    protected $settingsRepo;

    // ACTION
    /**
     * Default Constructor
     * @param  AdvertisementRepository $_adsRepo
     * @return void
     */
    public function __construct(SettingsRepository $_settingsRepo)
    {
        parent::__construct();
        $this->routeBaseName = "backend.settings";
        $this->routeDefaultIndex = "backend.settings.view";
        $this->viewBaseClosure = "backend.admin.settings";
        $this->viewInstanceName = 'Setting';
        $this->settingsRepo = $_settingsRepo;
        // page ID
        $this->pageId = 'B7';
        \View::share('pageId', $this->pageId);
        \View::share('pageIcon', 'fa fa-cogs');
        \View::share('pageTitle', $this->viewInstanceName);
        \View::share('routeBaseName', $this->routeBaseName);
        \View::share('routeDefaultIndex', $this->routeDefaultIndex);
        \View::share('viewBaseClosure', $this->viewBaseClosure);
    }

    public function getList()
    {
        $settings = new Settings;
        return View::make('backend.admin.settings.view', compact('settings'));
    }

    public function postSaveSettings()
    {
        $settings = \Input::get('settings', []);

        // Input File
        $partialPath = '/files/sitesetting/';
        $destinationPath = public_path() . $partialPath;
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0775, true);
        }

        $imageTypeSettings = [
            'logo_url',
            'history-image',
            'profile_image',
            'site-plan-1',
            'site-plan-2',
        ];

        foreach ($imageTypeSettings as $image) {
            try {
                if ($file = Input::file($image)) {
                    $fileName = $image . '.' . $file->getClientOriginalExtension();
                    $result = $file->move($destinationPath, $fileName);
                    if ($result) {
                        $settings[$image] = url($partialPath . $fileName);
                    }
                } elseif (isset($settings[$image])) {
                    $settings[$image] = '';
                } else {
                    $settings[$image] = settings($image);
                }
            } catch (Exception $e) {
                \Log::info($e);
            }
        }

        $definedSettings = Settings::pluck('value', 'key');

        // checklist settings
        foreach ($definedSettings as $key => $value) {
            if (!isset($settings[$key])) {
                $settings[$key] = '';
            }
        }

        // for array type settings
        $settings = collect($settings)->map(function ($item) {
            return is_array($item) ? json_encode($item) : $item;
        })->toArray();

        $setting = $this->settingsRepo->save($settings);
        $this->showNotification('notice', 'Setting Updated', 'You have successfully update settings');
        return Redirect::route('backend.settings.view');
    }

    protected function showNotification($type, $title, $message)
    {
        if (!session()->has('webNotification')) {
            session()->put('webNotification', []);
        }
        $webNotification = session()->get('webNotification');
        $webNotification[] = ['type' => $type, 'title' => $title, 'message' => $message];
        session()->put('webNotification', $webNotification);
    }
}
