<?php

namespace App\Http\Controllers\Api;

use App\SuitEvent\Models\BannerImage;
use App\SuitEvent\Repositories\BannerImageRepository;
use App\SuitEvent\Repositories\SponsorRepository;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class BannerImageController extends BaseController
{
    protected $sponsorRepository;
    protected $defaultParams = [
        'status' => BannerImage::STATUS_ACTIVE,
        'orderBy' => 'position_order,title',
        'orderType' => 'asc'
    ];

    /**
     * Initialize
     *
     * @param BannerImageRepository $repository
     * @param BannerImage           $model
     */
    public function __construct(
        BannerImageRepository $repository,
        BannerImage $model,
        SponsorRepository $sponsorRepository
    ) {
        $this->sponsorRepository = $sponsorRepository;
        parent::__construct($repository, $model);
    }

    public function getTicketPage()
    {
        // Ticket banner
        $this->defaultParams['type'] = 'ticket';
        $this->defaultParams['perPage'] = -1;
        $ticketBanners = $this->repository->getByParameter($this->defaultParams);

        // Ticket store
        $ticketStoreParams = [
            'type' => 'ticket-store',
            'perPage' => -1,
            'orderBy' => 'position_order,name',
            'orderType' => 'desc'
        ];
        $ticketStores = $this->sponsorRepository->getByParameter($ticketStoreParams);

        return $this->toJson(200, [
            'message' => 'Success get ticket page',
            'result' => [
                'ticket-banner' => $ticketBanners->count() > 0 ? $ticketBanners->toArray() : null,
                'ticket-store' => $ticketStores->count() > 0 ? $ticketStores->toArray() : null
            ]
        ]);
    }
}
