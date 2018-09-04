<?php

namespace App\Http\Controllers\Backend;

use App\SuitEvent\Controllers\BackendController;
use Input;
use Suitcore\Models\SuitModel;
use Suitcore\Repositories\SuitRepository;
use SuitUtil;
use View;

class BaseController extends BackendController
{
    // ATTRIBUTES

    // METHODS
    /**
     * Override Default Constructor
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new SuitRepository, new SuitModel);
        // page ID
        $this->pageId = 1;
        View::share('pageId', $this->pageId);
    }

    protected function preprocessDatatablesJson($_genericModel, $_displayedColumn, $_specificFilters = null)
    {
        // input param
        $draw = ((int) Input::get('draw', 0));
        $start = ((int) Input::get('start', 0));
        $length = ((int) Input::get('length', 10));
        $search = Input::get("search", '');
        $order = Input::get("order", '');
        Input::merge(['page' => (((int) floor($start / $length)) + 1)]); // define page
        // fetch model
        $genericModel = $_genericModel;
        $displayedColumn = $_displayedColumn;
        // search filter
        if (isset($search['value'])) {
            $genericModel = $genericModel->where(function ($query) use ($displayedColumn, $search) {
                $nbColumn = count($displayedColumn);
                if ($nbColumn > 0) {
                    $query->where($displayedColumn[0], "like", "%" . $search['value'] . "%");
                    for ($i = 1; $i < $nbColumn; $i++) {
                        $query->orWhere($displayedColumn[$i], "like", "%" . $search['value'] . "%");
                    }
                }
            });
            if ($_specificFilters != null && count($_specificFilters) > 0) {
                $genericModel->where(function ($query) use ($_specificFilters) {
                    foreach ($_specificFilters as $key => $val) {
                        $query->where($key, "=", $val);
                    }
                });
            }
        }
        // order filter
        if (isset($order[0]) && isset($order[0]['column']) && isset($displayedColumn[$order[0]['column']])) {
            $genericModel = $genericModel
            ->orderBy($displayedColumn[$order[0]['column']], (isset($order[0]['dir']) ? $order[0]['dir'] : 'desc'));
        }
        // paginate
        $genericModel = $genericModel->paginate($length);
        // construct json-source
        $nbElmt = $genericModel->total();
        $jsonSource['draw'] = $draw;
        $jsonSource['recordsTotal'] = $nbElmt;
        $jsonSource['recordsFiltered'] = $nbElmt;
        $jsonSource['rawdata'] = $genericModel;
        // return
        return $jsonSource;
    }
}
