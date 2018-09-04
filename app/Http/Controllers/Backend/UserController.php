<?php

namespace App\Http\Controllers\Backend;

use App;
use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\City;
use App\SuitEvent\Models\Kecamatan;
use App\SuitEvent\Models\Kelurahan;
use App\SuitEvent\Models\Location;
use App\SuitEvent\Models\User;
use App\SuitEvent\Repositories\UserRepository;
use Auth;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Carbon\Carbon;
use Excel;
use File;
use Form;
use Hash;
use Illuminate\Http\Request;
use Input;
use Mail;
use MessageBag;
use PHPExcel_Cell_DataValidation;
use PHPExcel_NamedRange;
use PHPExcel_Style_NumberFormat;
use Redirect;
use Response;
use Route;
use Session;
use Storage;
use Upload;
use Validator;
use View;
use \datetime as datetime;

class UserController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  UserRepository $_baseRepo
     * @param  User $_baseModel
     * @return void
     */
    public function __construct(UserRepository $_baseRepo, User $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.user";
        $this->routeDefaultIndex = "backend.user.index";
        $this->viewBaseClosure = "backend.admin.users";
        $this->viewInstanceName = 'baseObject';
        $this->viewImportExcelClosure = $this->viewBaseClosure . ".template";
        // page ID
        $this->pageId = 'C1';
        View::share('pageId', $this->pageId);
        View::share('pageIcon', 'fa fa-users');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);

        // Visible Config
        $_baseModel->setAttributeSettingsCustomState([
            'id',
            'role',
            'email',
            'password',
            'name',
            'birthdate',
            //'identity_number',
            //'tax_id_number',
            //'address_street',
            //'address_city',
            //'address_country',
            //'address_zipcode',
            'phone_number',
            'status',
            //'newsletter',
            //'escrow_amount',
            'registration_date',
            'last_visit',
            'created_at',
            'updated_at'
        ]);

        $_baseModel->setBufferedAttributeSettings('picture', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('premium_expired_date', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('message', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('billing_address_id', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('shop_name', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('shop_description', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('registration_date', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('referral_code', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('optional_user_code', 'formdisplay', false);
        $_baseModel->setBufferedAttributeSettings('address_id_default', 'formdisplay', false);
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

    public function postCreate()
    {
        // Save
        $param = Input::all();
        if ($param['role'] == User::USER) {
            $param['password'] = '-';
            $param['password_confirmation'] = '-';
        }
        $param['username'] = '-';
        $baseObj = $this->baseModel;
        if (isset($param['password']) &&
            !empty($param['password']) &&
            isset($param['password_confirmation']) &&
            !empty($param['password_confirmation']) &&
            ($param['password'] == $param['password_confirmation']) ) {
            $param['password'] = Hash::make($param['password']);
        } else {
            $this->showNotification(self::
                ERROR_NOTIFICATION, $baseObj->getLabel() . ' Created', 'Password confirmation does not match');
            return redirect()->back()->withInput();
        }
        if (isset($param['birthdate']) && strtotime($param['birthdate']) < 0) {
            $param['birthdate'] = Carbon::now()->subYears(18)->toDateTimeString();
        }
        $date = new datetime;
        $param['registration_date'] = $date;
        $param['last_visit'] = $date;
        $param['address_country'] = "Indonesia";
        $result = $this->baseRepository->create($param, $baseObj);
        // Return
        if ($result) {
            $this->showNotification(
                self::
                NOTICE_NOTIFICATION,
                $baseObj->getLabel() . ' Created',
                'New ' . $baseObj->getLabel() . ' data had been created!'
            );
            if (Route::has($this->routeBaseName . '.show')) {
                return Redirect::route($this->routeBaseName . '.show', ['id' => $baseObj->id]);
            } else {
                if (!empty($this->routeDefaultIndex)) {
                    return Redirect::route($this->routeDefaultIndex);
                }
                return Redirect::route($this->routeBaseName . '.index');
            }
        }
        return Redirect::route($this->routeBaseName . '.create')->with('errors', $baseObj->errors)->withInput($param);
    }

    public function postUpdate($id)
    {
        // Save
        $param = Input::all();
        $baseObj = $this->baseModel->find($id);
        if ($baseObj) {
            // Password is set
            if (!empty($param['password']) &&
                !empty($param['password_confirmation']) &&
                ($param['password'] == $param['password_confirmation'])) {
                $param['password'] = Hash::make($param['password']);
            } else { // Password is not set
                if (empty($param['password']) && empty($param['password_confirmation'])) {
                    $param['password'] = $baseObj->password;
                } else {
                    $this->showNotification(
                        self::
                        ERROR_NOTIFICATION,
                        $baseObj->getLabel() . ' Created',
                        'Password confirmation does not match'
                    );
                    return redirect()->back()->withInput();
                }
            }
        }
        if (isset($param['birthdate']) && strtotime($param['birthdate']) < 0) {
            $param['birthdate'] = Carbon::now()->subYears(18)->toDateTimeString();
        }
        $result = $this->baseRepository->update($id, $param, $baseObj);
        // Return
        if ($result) {
            $this->showNotification(
                self::
                NOTICE_NOTIFICATION,
                $baseObj->getLabel() . ' Updated',
                $baseObj->getLabel() . ' data had been updated!'
            );
            if (Route::has($this->routeBaseName . '.show')) {
                return Redirect::route($this->routeBaseName . '.show', ['id' => $id]);
            } else {
                if (!empty($this->routeDefaultIndex)) {
                    return Redirect::route($this->routeDefaultIndex);
                }
                return Redirect::route($this->routeBaseName . '.index');
            }
        }
        if ($baseObj == null) {
            App::abort(404);
        }
        return Redirect::
        route(
            $this->routeBaseName . '.update',
            ['id' => $id]
        )->with('errors', $baseObj->errors)->withInput($param);
    }
}
