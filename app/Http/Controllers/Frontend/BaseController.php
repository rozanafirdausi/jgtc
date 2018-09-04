<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\SuitEvent\Models\User;
use Input;
use Suitcore\SEO\SeoTrait;

class BaseController extends Controller
{
    use SeoTrait;

    // ATTRIBUTES
    protected $referralCode;

    // METHODS
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!($this->layout == null)) {
            $this->layout = View::make($this->layout);
        }
    }
}
