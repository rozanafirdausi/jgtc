<?php

namespace App\Http\Controllers\Frontend;

use App\SuitEvent\Models\DynamicMenu;
use App\SuitEvent\Models\Gallery;
use App\SuitEvent\Models\Performer;

class GalleryController extends BaseController
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

        $performers = Performer::with('galleries')
                                ->get();
        
        return view('frontend.gallery.index', compact(
            'gallery_videos',
            'gallery_images',
            'performers',
            'menus',
            'footer'
        ));
    }
}
