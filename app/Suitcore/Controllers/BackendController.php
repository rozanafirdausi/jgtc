<?php

namespace Suitcore\Controllers;

use App;
use App\Http\Controllers\Controller;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Carbon\Carbon;
use DB;
use Excel;
use Exception;
use File;
use Form;
use Input;
use MessageBag;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Cell_DataValidation;
use PHPExcel_NamedRange;
use Redirect;
use Response;
use Route;
use Suitcore\Models\SuitModel;
use Suitcore\Repositories\SuitRepository;
use Theme;
use View;

/**
 * This class define standard backend controller for Suitcore Application Instances
 **/
class BackendController extends Controller
{
    /**
     * Constants for partial view
     **/
    const TABLE_MENU = "tablemenu";

    // Partial View Related
    public static $partialView = [
        self::TABLE_MENU => 'backend.admin.partials.tablemenu',
    ]; // default value

    /**
     * Constants for import from excel action
     **/
    const RESETBY = "resetby";
    const REPLACE = "replace";
    const IGNORE = "ignore";

    /**
     * Constants for notifications
     **/
    const NOTICE_NOTIFICATION = "notice";
    const WARNING_NOTIFICATION = "warning";
    const ERROR_NOTIFICATION = "error";
    const OTHER_NOTIFICATION = "other";

    // PROPERTIES
    /**
     * ID of certain admin page
     **/
    public $pageId;
    public $pageTitle;

    // Default Services / Repository
    protected $baseRepository;
    protected $baseModel;
    protected $topLevelRelationModelString;
    protected $routeBaseName;
    protected $routeDefaultIndex;
    protected $viewBaseClosure;
    protected $viewImportExcelClosure;
    protected $viewInstanceName;
    protected $currentImportProcessFileLocation;

    // ACTION
    /**
     * Default Constructor
     * @param  SuitRepository $_baseRepo
     * @param  SuitModel $_baseModel
     * @return void
     */
    public function __construct(SuitRepository $_baseRepo, $_baseModel, $_topLevelRelationModelString = null)
    {
        // set property
        $this->baseRepository = $_baseRepo;
        $this->baseModel = $_baseModel;
        $this->baseRepository->setMainModel($this->baseModel);
        $this->topLevelRelationModelString = $_topLevelRelationModelString;
        $this->routeBaseName = "backend.generic";
        $this->routeDefaultIndex = null; // sample : "backend.generic.index"
        $this->viewBaseClosure = "backend.admin.generic";
        $this->viewImportExcelClosure = $this->viewBaseClosure . ".template"; // sample :  "backend.admin.generic.template"
        $this->viewInstanceName = 'genericObj';
        // default authenticated user (if any)
        if (auth()->user())
        {
            View::share('currentUser', auth()->user());
        }
        // default page ID
        $this->pageId = 1;
        $this->pageTitle = '';
        View::share('pageId', $this->pageId);
        View::share('pageTitle', $this->baseModel->_label);
        // set theme (based on APP_BACKEND_THEME environment variable)
        $this->middleware(function ($request, $next) {
            $manualThemeSet = '';
            $availableThemes = array_keys(config('themes.themes'));
            if ($request->has('temporary_theme')) {
                $requestedThemes = $request->get('temporary_theme');
                if (in_array($requestedThemes, $availableThemes)) {
                    $request->session()->put('temporary_theme', $requestedThemes);
                }
            }
            if ($request->session()->has('temporary_theme')) {
                $requestedThemes = $request->session()->get('temporary_theme');
                if (in_array($requestedThemes, $availableThemes)) {
                    $manualThemeSet = $requestedThemes;
                }
            }
            Theme::set(!empty($manualThemeSet) ? $manualThemeSet : env('APP_BACKEND_THEME', 'metronics'));
            return $next($request);
        });
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * Display list of baseModel
     * @param
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        // Parameter
        $param = Input::all();
        $paramSerialized = [];
        if ($param) {
            $idx = 0;
            foreach ($param as $key => $value) {
                $paramSerialized[$idx] = $key."=".$value;
                $idx++;
            }
        }
        $paramSerialized = $paramSerialized ? implode("&", $paramSerialized) : null;
        // Render View
        return view($this->viewBaseClosure . '.index')->with($this->viewInstanceName, $this->baseModel)
                                                      ->with('paramSerialized', $paramSerialized);
    }

    /**
     * Return json list of contentType for datatable purpose
     * @param
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postIndexJson() {
        // Parameter
        $param = Input::all();
        // specific filter if any
        $baseObj = $this->baseModel;
        $allAttribute = $baseObj->getAttributeSettings();
        $specificFilterFromRequest = [];
        foreach ($allAttribute as $attr => $config) {
            if (isset($config['visible']) &&
                $config['visible'] &&
                isset($param[$attr]) &&
                !empty($param[$attr])) {
                $specificFilterFromRequest[$baseObj->getTable().'.'.$attr] = $param[$attr];
            }
        }

        // Return
        $menuSetting = [
            'session_token' => csrf_token(),
            'url_detail' => (Route::has($this->routeBaseName . '.show') ? route($this->routeBaseName . '.show',["id"=>"#id#"]) : ''),
            'url_edit' => (Route::has($this->routeBaseName . '.edit') ? route($this->routeBaseName . '.edit',["id"=>"#id#"]) : ''),
            'url_delete' => (Route::has($this->routeBaseName . '.destroy') ? route($this->routeBaseName . '.destroy', ['id' => "#id#"]) : ''),
        ];
        $renderedMenu = View::make(self::$partialView[self::TABLE_MENU], ['menuSetting' => $menuSetting])->render();
        session()->put('datatablePageId', $this->pageId);
        return $this->baseRepository->jsonDatatable(
            $param,
            [
                'menu' => $renderedMenu
            ],
            $specificFilterFromRequest
        );
    }

    /**
     * Return json list of contentType for select2 purpose
     * @param
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getListJson() {
        // Parameter
        $q = Input::get('q', '');
        // Process
        $baseObj = $this->baseModel;
        $localColumnSearch = $baseObj->getFormattedValueColumn();
        $firstField = null;
        if ($localColumnSearch) {
            foreach ($localColumnSearch as $idx => $field) {
                if (!$firstField) {
                    $baseObj = $baseObj->where($field,"like","%".$q."%");
                    $firstField = $field;
                } else {
                    $baseObj = $baseObj->orWhere($field,"like","%".$q."%");
                }
            }
        }
        if ($firstField) {
            $baseObj = $baseObj->orderBy($firstField, 'asc');
        }
        $baseObj = $baseObj->paginate(10); // ->take(10)->get();
        if ($baseObj) {
            $data['items'] = [];
            foreach ($baseObj as $obj) { 
                $data['items'][] = [
                    "id" => $obj->id,
                    "value" => $obj->id,
                    "text" => $obj->getFormattedValue()
                ];
            }  
            $data['total_count'] = $baseObj->total();
            return Response::json($data);
        }     
        return Response::json([]);
    }

    /**
     * Display baseModel detail
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function getView($id)
    {
        // Fetch
        $fetchedData = $this->baseRepository->get($id);
        if ($fetchedData['object'] == null) {
            return App::abort(404);
        }
        // Return
        return view($this->viewBaseClosure . '.show')->with($this->viewInstanceName, $fetchedData['object']);
    }

    /**
     * Display baseModel create form
     * @param
     * @return \Illuminate\View\View
     */
    public function getCreate()
    {
        $param = Input::all();
        $baseObj = $this->baseModel;
        $allAttribute = $baseObj->getAttributeSettings();
        foreach ($allAttribute as $key => $cnf) {
            if ((isset($cnf['initiated']) && !$cnf['initiated']) || old($key)) {
                $baseObj->{$key} = old($key);
            }
        }

        return view($this->viewBaseClosure . '.create')->with($this->viewInstanceName, $baseObj);
    }

    /**
     * Save entry data from baseModel create form
     * @param
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function postCreate() {
        // Save
        $param = Input::all();
        $baseObj = $this->baseModel;
        $result = $this->baseRepository->create($param, $baseObj);
        if ($baseObj->uploadError) {
            $this->showNotification(self::ERROR_NOTIFICATION, $baseObj->_label . trans('suitcore.backend.create.upload.error.title'), trans('suitcore.backend.create.upload.error.message', ['obj' => strtolower($baseObj->_label)]));
        }
        // Return
        if ($result) {
            $this->showNotification(self::NOTICE_NOTIFICATION, $baseObj->_label . ' Created', 'Successfully create new ' . strtolower($baseObj->_label) .'.');
            if (Route::has($this->routeBaseName . '.show')) {
                return Redirect::route($this->routeBaseName . '.show', ['id'=>$baseObj->id]);
            } else {
                return $this->returnToRootIndex($baseObj);
            }
        }
        $this->showNotification(self::ERROR_NOTIFICATION, $baseObj->_label . ' Not Created', $baseObj->errors->first());
        return Redirect::route($this->routeBaseName . '.create')->with('errors', $baseObj->errors)->withInput($param);
    }

    /**
     * Display baseModel update form
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function getUpdate($id) {
        $baseObj = $this->baseModel->find($id);
        if ($baseObj == null) return App::abort(404);

        return view($this->viewBaseClosure . '.edit')->with($this->viewInstanceName, $baseObj);
    }

    /**
     * Save entry data from baseModel update form
     * @param  int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function postUpdate($id) {
        // Save
        $param = Input::all();
        $baseObj = $this->baseModel;
        $result = $this->baseRepository->update($id, $param, $baseObj);
        if ($baseObj->uploadError) {
            $this->showNotification(self::ERROR_NOTIFICATION, $baseObj->_label . trans('suitcore.backend.update.upload.error.title'), trans('suitcore.backend.update.upload.error.message', ['obj' => strtolower($baseObj->_label)]));
        }
        // Return
        if ($result) {
            $this->showNotification(self::NOTICE_NOTIFICATION, $baseObj->_label . ' Updated', 'Successfully update ' . strtolower($baseObj->_label) .'.');
            if (Route::has($this->routeBaseName . '.show'))
                return Redirect::route($this->routeBaseName . '.show', ['id'=>$id]);
            else {
                return $this->returnToRootIndex($baseObj);
            }
        }
        if ($baseObj == null) App::abort(404);
        $this->showNotification(self::ERROR_NOTIFICATION, $baseObj->_label . ' Not Updated', $baseObj->errors->first());
        return Redirect::route($this->routeBaseName . '.update', ['id'=>$id])->with('errors', $baseObj->errors)->withInput($param);
    }

    /**
     * Delete baseModel data
     * @param int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function postDelete($id) {
        // Delete
        $baseObj = $this->baseModel;
        $result = $this->baseRepository->delete($id, $baseObj);
        // Return
        if ($result) {
            $this->showNotification(self::NOTICE_NOTIFICATION, $baseObj->_label . ' Deleted', 'Successfully delete ' . strtolower($baseObj->_label) .'.');
        } else {
            $this->showNotification(self::ERROR_NOTIFICATION, $baseObj->_label . ' Not Deleted', 'Fail to delete ' . strtolower($baseObj->_label) .'. An error occured when processing with database.');
        }

        return $this->returnToRootIndex($baseObj);
    }

    /**
     * Index return route
     * @param int $id
     * @return \Illuminate\Support\Facades\Redirect
     */
    protected function returnToRootIndex($baseObj) {
        if (!empty($this->routeDefaultIndex)) {
            if (endsWith('.show', $this->routeDefaultIndex) &&
                !empty($this->topLevelRelationModelString)) {
                // custom detail return
                $topLevelRelationObject = $baseObj->getAttribute($this->topLevelRelationModelString);
                if ($topLevelRelationObject) {
                    return Redirect::route($this->routeDefaultIndex, ['id'=>$topLevelRelationObject->id]);
                }
            }
            return Redirect::route($this->routeDefaultIndex);
        }
        return Redirect::route($this->routeBaseName . '.index');
    }

    public function exportToExcel($specificFilter = null)
    {
        if ($this->baseModel) {
            $baseObj = $this->baseModel;
            $dataSpecificFilter = ($specificFilter && is_array($specificFilter) ? $specificFilter : []);
            // CAPTURE DATATABLE FILTER IF ANY
            $datatableSpecificFilters = session()->get('datatable_specific_filters', null);
            if ($datatableSpecificFilters &&
                is_array($datatableSpecificFilters) &&
                count($datatableSpecificFilters) > 0) {
                $attrSettings = $baseObj->attribute_settings;
                foreach ($datatableSpecificFilters as $key => $value) {
                    $estimatedMainObjectRealKey = str_replace($baseObj->getTable().".", "", $key);
                    if (isset($attrSettings[$estimatedMainObjectRealKey])) {
                        $dataSpecificFilter[$key] = $value;
                    }
                }
            }
            // BOX SPOUT WAY
            $fileName = str_replace(" ", "", $baseObj->_label)  . 'Data'.date('dmYhis').'.xlsx';
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename='. $fileName,
            ];

            $callback = function () use ($baseObj, $dataSpecificFilter, $specificFilter) {
                $writer = WriterFactory::create(Type::XLSX); // available :  XLSX / CSV / ODS

                $writer->openToFile("php://output"); // file or phpStream
                // $writer->openToBrowser($fileName); // stream data directly to the browser

                // Customizing the sheet name when writing
                $sheet = $writer->getCurrentSheet();
                $sheet->setName('Data');

                $columnHeader = [];
                foreach ($baseObj->getBufferedAttributeSettings() as $key=>$val) {
                    if ( $val['visible'] ) {
                        $columnHeader[] = $val['label'];
                    }
                }
                $writer->addRow($columnHeader); // Header - add a row at a time
                $objectList = $baseObj->select($baseObj->getTable().".*");
                if ($dataSpecificFilter != null && count($dataSpecificFilter) > 0) {
                    $objectList->where(function($query) use ($dataSpecificFilter, $baseObj) {
                        $attrSettings = $baseObj->attribute_settings;
                        foreach($dataSpecificFilter as $key=>$val) {
                            $estimatedMainObjectRealKey = str_replace($baseObj->getTable().".", "", $key);
                            if (isset($attrSettings[$estimatedMainObjectRealKey]) &&
                                isset($attrSettings[$estimatedMainObjectRealKey]['type']) &&
                                in_array($attrSettings[$estimatedMainObjectRealKey]['type'], [SuitModel::TYPE_DATETIME, SuitModel::TYPE_DATE]) &&
                                str_contains($val, "-yadcf_delim-") ) {
                                $ranges = explode("-yadcf_delim-", $val);
                                if (count($ranges) == 2 &&
                                    !empty($ranges[0]) &&
                                    !empty($ranges[1])) {
                                    $query->where($key,">=",$ranges[0]);
                                    $query->where($key,"<=",$ranges[1]);
                                }
                            } elseif (!str_contains($val, "-yadcf_delim-")) {
                                if (is_array($val) && !empty($val)) {
                                    $query->whereIn($key, $val);
                                } else {
                                    $query->where($key,"=",$val);
                                }
                            }
                        }
                    }); 
                }
                // get execution timelimit
                $currentMaxTimeLimit = ini_get('max_execution_time');
                $currentMaxMemoryLimit = ini_get('memory_limit');
                // set timelimit unlimited
                ini_set('max_execution_time', 0);
                ini_set('memory_limit','512M');
                // process
                $objectList->chunk(100, function($objects) use ($writer, $specificFilter) {
                    // init data
                    $data = [];
                    foreach ($objects as $object) {
                        $tmpRow = [];
                        foreach ($object->getBufferedAttributeSettings() as $attrName=>$attrSettings) {
                            if ($attrSettings['visible']) {
                                if ($specificFilter == null ||
                                    !is_array($specificFilter) ||
                                    !isset($specificFilter[$attrName])) {
                                    $tmpRow[] = $object->renderRawAttribute($attrName);
                                }
                            }
                        }
                        $data[] = $tmpRow;
                    }
                    // Write Rows
                    $writer->addRows($data); // add multiple rows at a time
                });
                // Close Writer
                $writer->close();
                // revert back timelimit 
                ini_set('max_execution_time', $currentMaxTimeLimit);
                ini_set('memory_limit',$currentMaxMemoryLimit);
            };
            // return
            return Response::stream($callback, 200, $headers);

            /*
            // MAATWEBSITE EXCEL WAY
            $currentMaxTimeLimit = ini_get('max_execution_time');
            ini_set('max_execution_time', 0);
            Excel::create(str_replace(" ", "", $baseObj->_label)  . 'Data', function ($excel) {
                // Set sheets
                $excel->sheet('Data', function ($sheet) {
                    $idx = 1;
                    $objectList = $baseObj->select($baseObj->getTable().".*");
                    if ($specificFilter != null && count($specificFilter) > 0) {
                        $objectList->where(function($query) use ($specificFilter) {
                            foreach($specificFilter as $key=>$val) {
                                $query->where($key, "=", $val);
                            }
                        });
                    }
                    $objectList->chunk(100, function($objects) use ($idx, $sheet) {
                        // reinit
                        $data = [];
                        // header if needed
                        if ($idx == 1 ){
                            $data[0] = [];
                            foreach ($baseObj->getBufferedAttributeSettings() as $key=>$val) {
                                if ( $val['visible'] ) {
                                    $data[0][] = $val['label'];
                                }
                            }
                        }
                        // write data
                        foreach ($objects as $object) {
                            $tmpRow = [];
                            foreach ($object->getBufferedAttributeSettings() as $attrName=>$attrSettings) {
                                if ($attrSettings['visible']) {
                                    if ($specificFilter == null ||
                                        !is_array($specificFilter) ||
                                        !isset($specificFilter[$attrName])) {
                                        $tmpRow[] = $object->renderRawAttribute($attrName);
                                    }
                                }
                            }
                            $data[] = $tmpRow;
                        }
                        // Sheet manipulation
                        $sheet->fromArray($data, null, 'A' . $idx, false, false);
                        // increment index
                        $idx += ($idx == 1 ? 101 : 100);
                    });

                    // Sheet further manipulation
                    // $sheet->fromArray($data, null, 'A1', false, false);
                    $sheet->cells('A1:Z1', function ($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->freezeFirstRow();

                });
            })->export('xlsx'); //*.xls only support until 65.536 rows
            ini_set('max_execution_time', $currentMaxTimeLimit);
            */
        }
    }

    /**
     * Route Implementation to import from excel page
     * @return Illuminate\View\View
     */
    public function template()
    {
        $baseObj = $this->baseModel;
        return view($this->viewImportExcelClosure)->with($this->viewInstanceName, $baseObj);
    }

    /**
     * Route Implementation to download template
     * @return ExcelFile
     */
    public function downloadTemplate()
    {
        // Generate data for Excel file
        // -- data source and settings
        $sourceData = $this->getTemplateAttributes();
        $sourceDataSettings = $this->baseModel->getBufferedAttributeSettings();
        // -- references data settings for relationship attributes
        $exceptionFields = is_array($this->getImportRelationshipFieldException()) ? $this->getImportRelationshipFieldException() : [];
        $relationshipReferences = $this->getImportRelationshipReferencesData();
        // Create an Excel file
        Excel::create($this->baseModel->_label . ' Template', function ($excel) use ($sourceData, $sourceDataSettings, $exceptionFields, $relationshipReferences) {
            // 1. Create list sheet.
            $excel->sheet('Data', function ($sheet) use ($sourceData, $sourceDataSettings, $exceptionFields, $relationshipReferences) {
                $excelSourceDataFormat = [];
                $parentIdx = -1;
                $idx = 0;
                $ranges = range('A', 'Z');
                $rangePrefix = "";
                foreach ($sourceData as $key => $value) {
                    $columnIdx = $rangePrefix.$ranges[$idx]; // handle A to ZZ
                    // default is text
                    $excelSourceDataFormat[$columnIdx] = PHPExcel_Style_NumberFormat::FORMAT_TEXT;
                    // check for exception fields
                    $applicated = false;
                    if (!$applicated && in_array($key, array_keys($exceptionFields))) {
                        $excelSourceDataFormat[$columnIdx] = PHPExcel_Style_NumberFormat::FORMAT_TEXT;
                        $applicated = true;
                    }
                    // check for relationship
                    if (!$applicated && in_array($key, array_keys($relationshipReferences))) {
                        for($i=2; $i < 1000; $i++) {
                            $cellValidation = $sheet->getCell(sprintf('%s%s', $columnIdx, $i))->getDataValidation();
                            $cellValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                            $cellValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                            $cellValidation->setAllowBlank(false);
                            $cellValidation->setShowInputMessage(true);
                            $cellValidation->setShowErrorMessage(true);
                            $cellValidation->setShowDropDown(true);
                            $cellValidation->setErrorTitle('Your input is invalid');
                            $cellValidation->setError('Value is does not exist in references sheet.');
                            $cellValidation->setPromptTitle('Choose from the list');
                            $cellValidation->setFormula1($columnIdx);
                        }
                        $applicated = true;
                    }
                    // check for other fields
                    if (!$applicated &&
                        isset($sourceDataSettings[$key]) &&
                        isset($sourceDataSettings[$key]['type'])) {
                        if (($sourceDataSettings[$key]['type'] == SuitModel::TYPE_NUMERIC ||
                             $sourceDataSettings[$key]['type'] == SuitModel::TYPE_FLOAT) &&
                            ( (isset($sourceDataSettings[$key]['options']) && !is_array($sourceDataSettings[$key]['options'])) || !isset($sourceDataSettings[$key]['options'])) ) {
                            $excelSourceDataFormat[$columnIdx] = PHPExcel_Style_NumberFormat::FORMAT_NUMBER;
                        } else if ($sourceDataSettings[$key]['type'] == SuitModel::TYPE_DATETIME ||
                            $sourceDataSettings[$key]['type'] == SuitModel::TYPE_DATE ||
                            $sourceDataSettings[$key]['type'] == SuitModel::TYPE_TIME) {
                            $excelSourceDataFormat[$columnIdx] = PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME; // d/m/Y H:i
                        }
                    }
                    // continue to next index
                    $idx++;
                    if ($idx >= 26) {
                        $parentIdx++;
                        if ($parentIdx >= 26) break; // end of column index in excel
                        $idx = 0;
                        if ($parentIdx >= 0) $rangePrefix = $ranges[$parentIdx];
                    }
                }
                $sheet->fromArray($sourceData);
                $sheet->setColumnFormat($excelSourceDataFormat);
            });
            // 2. Create references sheet.
            $excel->sheet('Master Data', function ($sheet) use ($sourceData, $relationshipReferences) {
                $parentIdx = -1;
                $idx = 0;
                $ranges = range('A', 'Z');
                $rangePrefix = "";
                $sheet->fromArray($sourceData);
                foreach ($sourceData as $key => $value) {
                    $columnIdx = $rangePrefix.$ranges[$idx]; // handle A to ZZ
                    $row = 2;
                    if (isset($relationshipReferences[$key])) {
                        foreach ($relationshipReferences[$key] as $value2) {
                            $cell = sprintf('%s%s', $columnIdx, $row);
                            $sheet->setCellValue($cell, $value2);
                            $row++;
                        }
                        // Set cell range name.
                        $sheet->_parent->addNamedRange(
                            new PHPExcel_NamedRange($columnIdx, $sheet, sprintf('%s%s:%s%s', $columnIdx, 2, $columnIdx, $row - 1))
                        );
                    }
                    // continue to next index
                    $idx++;
                    if ($idx >= 26) {
                        $parentIdx++;
                        if ($parentIdx >= 26) break; // end of column index in excel
                        $idx = 0;
                        if ($parentIdx >= 0) $rangePrefix = $ranges[$parentIdx];
                    }
                }
            });
            // unset unneccessary
            unset($sourceData);
            unset($sourceDataSettings);
        })->export('xlsx');
    }

    /**
     * Helper function to return template attribuets for imported baseModel
     * @return ExcelFile
     */
    public function getTemplateAttributes()
    {
        $attributes = [];
        $sourceData = $this->baseModel->getBufferedAttributeSettings();
        foreach ($sourceData as $key => $value) {
            if ( isset($value['formdisplay']) &&
                 $value['formdisplay'] &&
                 ( (isset($value['initiated']) && !$value['initiated']) ||
                    !isset($value['initiated']))
               ) {
                $attributes[$key] = ucwords(str_replace("_", " ", strtolower($key))); // $value['label'];
            }
        }
        return $attributes;
    }

    /**
     * Get list of relationship field exception
     * @return array of [ $relationshipAttributeName => $relationshipAttributeReplacementField ]
     **/
    public function getImportRelationshipFieldException() {
        return [];
    }

    /**
     * Get list of relationship references masterdata to be added on references sheet
     * @return array of options value
     **/
    public function getImportRelationshipReferencesData() {
        $exceptionFields = is_array($this->getImportRelationshipFieldException()) ? array_keys($this->getImportRelationshipFieldException()) : [];
        $relationshipFields = [];
        $sourceData = $this->baseModel->getBufferedAttributeSettings();
        foreach ($sourceData as $key => $value) {
            if ( !in_array($key, $exceptionFields) &&
                 isset($value['formdisplay']) &&
                 $value['formdisplay'] &&
                 ( (isset($value['relation']) && !empty($value['relation'])) ||
                   (isset($value['options']) && is_array($value['options']))
                 ) &&
                 ( (isset($value['initiated']) && !$value['initiated']) ||
                    !isset($value['initiated']))
               ) {
                if (isset($value['relation']) && !empty($value['relation'])) {
                    $tmpData = $this->baseModel->getRelatedObject($value['relation'])->all();
                    if ($tmpData && count($tmpData) > 0) {
                        foreach ($tmpData as $object) {
                            $relationshipFields[$key][] = $object->id . ":" . $object->getFormattedValue();
                        }
                    } else {
                        $relationshipFields[$key] = [];
                    }
                } else {
                    $tmpData = $value['options'];
                    if ($tmpData && count($tmpData) > 0) {
                        foreach ($tmpData as $val => $label) {
                            $relationshipFields[$key][] = $val . ":" . $label;
                        }
                    } else {
                        $relationshipFields[$key] = [];
                    }
                }
            }
        }
        return $relationshipFields;
    }

    /**
     * Route Implementation to process importing from excel
     * @return Redirect
     */
    public function importFromTemplate()
    {
        $method = Input::get('method');
        $templateAttributes = $this->getTemplateAttributes();
        $modelAttrSettings = $this->baseModel->getBufferedAttributeSettings();

        $excel = $this->getUploadedFile();
        if ($excel == null || $excel->first() == null) {
            return redirect()->back()->with('error', 'Error template! Please check if header column is exist and data is available!');
        }
        $tableHeader = array_keys($excel->first()->toArray());

        $checkResult = true;
        foreach ($tableHeader as $key => $value) {
            if (!in_array($value, array_keys($templateAttributes))) {
                $checkResult = false;
            }
        }
        if ($checkResult == false)
            return redirect()->back()->with('error', 'Your file should contain the following column: ' . implode(', ', $templateAttributes));

        DB::beginTransaction();
        try {
            $rowNumber = 0;
            $datas = $excel->chunk(50);
            foreach ($datas as $data) {
                foreach ($data as $row) {
                    $rowNumber++;
                    $objectInstance = $this->baseModel;
                    $keyBaseName = $this->baseModel->getImportExcelKeyBaseName();
                    if (is_array($keyBaseName)) {
                        foreach ($keyBaseName as $key => $value) {
                            if (isset($row[$value])) {
                                $objectInstance = $objectInstance->where($value, $row[$value]);
                            }
                        }
                        $objectInstance = $objectInstance->first();
                    } else {
                        if (isset($row[$keyBaseName])) {
                            $objectInstance = $objectInstance->where($keyBaseName, $row[$keyBaseName])->first();
                        }
                    }

                    // datetime, date and time format validation
                    foreach($row as $key=>$val) {
                        if (is_array($modelAttrSettings) &&
                            isset($modelAttrSettings[$key]) &&
                            isset($modelAttrSettings[$key]['type'])) {
                            if ($modelAttrSettings[$key]['type'] == SuitModel::TYPE_DATETIME ||
                                $modelAttrSettings[$key]['type'] == SuitModel::TYPE_DATE ||
                                $modelAttrSettings[$key]['type'] == SuitModel::TYPE_TIME) {
                                $dateConfirm = null;
                                try {
                                    // From Excel : m/d/Y H:i
                                    // Already a Carbon
                                    $dateConfirm = $val->format('Y-m-d H:i:s');
                                    $row[$key] = $dateConfirm;
                                    // $dateConfirm = Carbon::createFromFormat('d/m/Y H:i', $val);
                                } catch (Exception $e) { $dateConfirm = null; }
                                if ($dateConfirm == null || $dateConfirm == false) {
                                    return back()->with('error', 'Error in row ' . $rowNumber . ': Date format does not match');
                                }
                            }
                        }
                    }

                    // Process...
                    if ($objectInstance && $objectInstance->id > 0) {
                        if ($method == self::REPLACE) {
                            // if data virtual account confirmation exist, update
                            $result = $this->baseRepository->update($objectInstance->id, $row->toArray(), $objectInstance);
                        }
                        // else IGNORED
                    } else {
                        // create new record
                        $baseObj = $this->baseModel;
                        $result = $this->baseRepository->create($row->toArray(), $baseObj);
                    }
                }
            }
        } catch (\PDOException $e) {
            DB::rollback();
            return redirect()->back()
                 ->with('error', 'Error in row ' . $rowNumber . ': ' . $e->errorInfo[2] . '.');
        }
        DB::commit();
        return back()->with('success', 'New records successfully imported.');
    }

    /**
     * Route Implementation to read uploaded template
     * @return ExcelFile
     */
    protected function getUploadedFile()
    {
        $input = Input::all();
        // $destinationPath = 'files/importexcel/'.strtolower(get_class($this->baseModel));
        $destinationPath = 'files/importexcel/'.strtolower((new \ReflectionClass($this->baseModel))->getShortName()); // upload path
        $file = array_get($input, 'file_url');
        if (is_null($file)) {
            Session::flash('error', 'Please select files that want to be imported!');
            return back();
        }
        $extension = $file->getClientOriginalExtension();
        // RENAME THE UPLOAD WITH RANDOM NUMBER
        $fileName = rand(11111, 99999) . '.' . $extension;
        // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
        $isUploadSuccess = $file->move($destinationPath, $fileName);
        $this->currentImportProcessFileLocation = $destinationPath . '/' . $fileName; 
        //get by sheet
        return Excel::selectSheetsByIndex(0)->load($destinationPath . '/' . $fileName, function () {})->get();
    }

    /**
     * Show notification to users
     * @param int $type
     * @param int $title
     * @param int $message
     * @return void
     */
    protected function showNotification($type, $title, $message) {
        if (!session()->has('webNotification')) {
            session()->put('webNotification', []);
        }
        $webNotification = session()->get('webNotification');
        $webNotification[] = ['type' => $type, 'title' => $title, 'message' => $message];
        session()->put('webNotification', $webNotification);
    }
}
