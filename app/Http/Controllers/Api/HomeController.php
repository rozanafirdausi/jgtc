<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\Content;
use App\SuitEvent\Models\Gallery;
use App\SuitEvent\Repositories\ContentRepository;
use App\SuitEvent\Repositories\GalleryRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class HomeController extends BaseController
{
    protected $galleryRepository;

    /**
     * Initialize
     *
     * @param GalleryRepository $repository
     * @param Gallery           $model
     */
    public function __construct(
        ContentRepository $repository,
        Content $model,
        GalleryRepository $galleryRepository
    ) {
        $this->galleryRepository = $galleryRepository;
        parent::__construct($repository, $model);
    }

    public function getHomePage()
    {
        // Setting
        $mainBannerText = settings('main_banner_label', '');
        // Event Countdown
        $eventCountdownString = settings('event_start_date', '2017-10-17');
        $eventCountdown = Carbon::createFromTimeStamp(strtotime($eventCountdownString))->toIso8601String();

        // Vote Countdown
        $voteCountdownString = settings('performer_vote_deadline', '2017-10-17');
        $voteCountdown = Carbon::createFromTimeStamp(strtotime($voteCountdownString))->toIso8601String();

        // Latest News
        $this->defaultParams = [
            '_type_code' => 'news',
            'paginate' => false,
            'perPage' => 1,
            'orderBy' => 'created_at, title',
            'orderType' => 'desc'
        ];
        $latestNews = $this->repository->getByParameter($this->defaultParams);

        // Ticket store
        $galleryParams = [
            'paginate' => false,
            'perPage' => 5,
            'orderBy' => 'created_at, title',
            'orderType' => 'desc'
        ];
        $latestGalleries = $this->galleryRepository->getByParameter($galleryParams);

        return $this->toJson(200, [
            'message' => 'Success get home page',
            'result' => [
                'main_banner_label' => $mainBannerText,
                'event_start_date' => $eventCountdown,
                'performer-vote-deadline' => $voteCountdown,
                'latest-news' => $latestNews,
                'latest-galleries' => $latestGalleries->count() > 0 ? $latestGalleries->toArray() : null
            ]
        ]);
    }
}
