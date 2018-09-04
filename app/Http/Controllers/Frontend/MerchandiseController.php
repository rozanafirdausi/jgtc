<?php

namespace App\Http\Controllers\Frontend;

use App\SuitEvent\Models\BannerImage;
use App\SuitEvent\Models\DynamicMenu;

class MerchandiseController extends BaseController
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
    public function index()
    {
        $menus = DynamicMenu::where('position', 'web-header')
                            ->where('status', 'active')
                            ->orderBy('position_order')
                            ->get();
        $footer = settings('footer-description', '');

        $merchandises = BannerImage::where('type', 'merch')
                            ->where('status', BannerImage::STATUS_ACTIVE)
                            ->orderBy('position_order')
                            ->get();
        $profileImage = settings('profile_image', '');

        return view('frontend.merchandise.show', compact(
            'merchandises',
            'menus',
            'profileImage',
            'footer'
        ));
    }
}
