<?php

namespace App\Http\Controllers\Frontend;

use App\SuitEvent\Models\BannerImage;
use App\SuitEvent\Models\DynamicMenu;
use App\SuitEvent\Models\Faq;
use App\SuitEvent\Models\Performer;
use App\SuitEvent\Models\Schedule;
use App\SuitEvent\Models\Settings;
use App\SuitEvent\Models\Sponsor;
use App\SuitEvent\Models\Stage;

class HomeController extends BaseController
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
        $tickets = BannerImage::where('type', 'ticket')
            ->where('status', BannerImage::STATUS_ACTIVE)
            ->orderBy('position_order')
            ->get();
        $performers = Performer::where('is_visible', Performer::STATUS_VISIBLE)
            ->orderBy('position_order')
            ->get();

        $scheduleOnStages = Schedule::select(
            'schedules.*',
            'stages.name AS stage_name',
            'performer_schedules.performer_id',
            'performers.name AS performers_name'
        )->leftJoin('stages', 'schedules.stage_id', '=', 'stages.id')
            ->leftJoin('performer_schedules', 'performer_schedules.schedule_id', '=', 'schedules.id')
            ->leftJoin('performers', 'performers.id', '=', 'performer_schedules.performer_id')
            ->where('schedules.event_type', 'event')
            ->where('schedules.is_visible', Schedule::STATUS_VISIBLE)
            ->where('stages.is_visible', Stage::STATUS_VISIBLE)
            ->orderBy('stages.position_order')
            ->orderBy('schedules.start_date')
            ->get()
            ->groupBy('stage_name');

        $hiddenScheduleOnStages = Schedule::select(
            'schedules.*',
            'stages.name AS stage_name',
            'performer_schedules.performer_id',
            'performers.name AS performers_name'
        )->leftJoin('stages', 'schedules.stage_id', '=', 'stages.id')
            ->leftJoin('performer_schedules', 'performer_schedules.schedule_id', '=', 'schedules.id')
            ->leftJoin('performers', 'performers.id', '=', 'performer_schedules.performer_id')
            ->where('schedules.event_type', 'event')
            ->where('schedules.is_visible', Schedule::STATUS_HIDDEN)
            ->where('stages.is_visible', Stage::STATUS_VISIBLE)
            ->orderBy('stages.position_order')
            ->orderBy('schedules.start_date')
            ->get()
            ->groupBy('stage_name');

        $faqs = Faq::orderBy('position_order')->get();
        $siteplan1 = settings('site-plan-1') ?: asset('frontend/assets/img/site-plan-soon.png');
        $siteplan2 = settings('site-plan-2') ?: asset('frontend/assets/img/site-plan-soon.png');
        $trainRoute = settings('train-route', '');
        $busRoute = settings('bus-route', '');
        $spotifyPlaylistUrl = settings('spotify-playlist-url', '');
        $history = settings('history', '');
        $historyImage = settings('history-image', '');
        $profile = settings('profile', '');
        $profileImage = settings('profile_image', '');
        $footer = settings('footer-description', '');

        $preEvents = Schedule::where('event_type', 'pre')
            ->where('is_visible', Schedule::STATUS_VISIBLE)
            ->orderBy('start_date')
            ->get();

        $merchandises = BannerImage::where('type', 'merch')
            ->where('status', 'active')
            ->orderBy('position_order')
            ->get();

        $organizerSponsors = Sponsor::where('type', 'organizer')
            ->where('is_visible', Sponsor::STATUS_VISIBLE)
            ->orderBy('position_order')
            ->get();

        $supporterSponsors = Sponsor::where('type', 'supporter')
            ->where('is_visible', Sponsor::STATUS_VISIBLE)
            ->orderBy('position_order')
            ->get();

        $ticketSponsors = Sponsor::where('type', 'official-ticketing')
            ->where('is_visible', Sponsor::STATUS_VISIBLE)
            ->orderBy('position_order')
            ->get();

        $mediaSponsors = Sponsor::where('type', 'media')
            ->where('is_visible', Sponsor::STATUS_VISIBLE)
            ->orderBy('position_order')
            ->get();

        return view('frontend.home.index', compact(
            'menus',
            'faqs',
            'merchandises',
            'performers',
            'performerschedules',
            'preEvents',
            'sponsors',
            'tickets',
            'history',
            'historyImage',
            'profile',
            'profileImage',
            'siteplan1',
            'siteplan2',
            'trainRoute',
            'busRoute',
            'spotifyPlaylistUrl',
            'footer',
            'scheduleOnStages',
            'hiddenScheduleOnStages',
            'supporterSponsors',
            'organizerSponsors',
            'ticketSponsors',
            'mediaSponsors',
            'faqs1'
        ));
    }
}
