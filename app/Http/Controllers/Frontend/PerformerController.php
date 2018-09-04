<?php

namespace App\Http\Controllers\Frontend;

use App\SuitEvent\Models\DynamicMenu;
use App\SuitEvent\Models\Performer;

class PerformerController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show Frontend / Desktop Site Homepage
     *
     * @return View
     **/
    public function show($id)
    {
        $menus = DynamicMenu::where('position', 'web-header')
                            ->where('status', 'active')
                            ->orderBy('position_order')
                            ->get();
        $footer = settings('footer-description', '');

        $performers = Performer::where('id', $id)
                                ->with('galleries')
                                ->get();
        $profileImage = settings('profile_image', '');

        return view('frontend.lineup.show', compact(
            'performers',
            'menus',
            'profileImage',
            'footer'
        ));
    }
}
