<?php

namespace App\SuitEvent\Controllers;

use App;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use DB;
use Excel;
use File;
use Form;
use Input;
use MessageBag;
use PHPExcel_Style_NumberFormat;
use Redirect;
use Response;
use Route;
use Suitcore\Models\SuitModel;
use Suitcore\Repositories\SuitRepository;
use View;

/**
 * Extend from SuitCore Backend Controller
 **/
class ExtendedBackendController extends \Suitcore\Controllers\ExtendedBackendController
{
    // Custom Action in SuitEvent Instances
}
