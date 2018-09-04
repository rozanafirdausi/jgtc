<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Domain definition in config file
$domain = '';
switch (App::environment()) {
    case 'local':
        $domain = env('APP_LOCAL_DOMAIN', 'event.dev');
        break;
    case 'staging':
        $domain = env('APP_STAGING_DOMAIN', 'event.suitdev.com');
        break;
    case 'production':
    default:
        $domain = env('APP_PRODUCTION_DOMAIN', 'event.suitmedia.events');
        break;
}
Config::set('app.url', $domain);

/*
  |--------------------------------------------------------------------------
  | Pattern Shortcut
  |--------------------------------------------------------------------------
  |
  | Define frequently used pattern
  |
 */

Route::pattern('id', '\d+');
Route::pattern('slug', '[a-z0-9-]+');


/*
 * Patch Related to New Relic Issue
 */
Route::macro('after', function ($callback) {
    $this->events->listen('router.filter:after:newrelic-patch', $callback);
});

/*
 * Routes List
 */

// Scope Authentication
Route::group(['middleware' => 'web'], function () {
    // User Login
    //Route::resource('sessions', 'Auth\SessionController');
    Route::get('secret/logout', ['as'=>'sessions.logout', 'uses' =>'Auth\SessionController@destroy', 'middleware' => 'auth']);
    Route::group(['middleware' => 'guest', 'prefix' => 'secret'], function () {
        Route::get('login', ['as'=>'sessions.login', 'uses' =>'Auth\SessionController@create']);
        Route::post('postlogin', ['as'=>'sessions.store', 'uses' =>'Auth\SessionController@store']);
        /* Reset Password */
        Route::get('forgot_password',['as'=>'frontend.admin.forgetpassword','uses'=>'Auth\ForgotPasswordController@showLinkRequestForm']);
        Route::post('forgot_password/',['as'=>'frontend.admin.forgetpassword.post','uses'=>'Auth\ForgotPasswordController@sendResetLinkEmail']);
        Route::get('reset_password/{token}', ['as'=> 'frontend.admin.resetpassword', 'uses'=>'Auth\ResetPasswordController@showResetForm']);
        Route::post('reset_password', ['as'=> 'frontend.admin.resetpassword.post', 'uses'=>'Auth\ResetPasswordController@reset']);
    });
});


// Scope after Admin Logged in
Route::group(['prefix' => 'admin'], function() {
    // ----- HELPER -----
    // Upload Handler
    Route::post('uploadfile', array(
        'as' => 'admin.uploadfile',
        'middleware' => 'admins',
        function(){
            try {
                $CKEditorFuncNum = Input::get("CKEditorFuncNum");
                $destinationPath = public_path() . '/files/raw/';
                $fileName = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz0123456789', 5)), 0, 5) . '.' . Input::file('upload')->getClientOriginalExtension();
                $result = Input::file('upload')->move($destinationPath, $fileName);
                if ($result) {
                    $url = url('/files/raw/' . $fileName);
                    echo "<script>window.parent.CKEDITOR.tools.callFunction("
                        . $CKEditorFuncNum . ", \"" . $url . "\");</script>";
                }
            } catch (Exception $e) {
                echo "Upload failed!";
            }
        })
    );

    // ----- HOME DASHBOARD -----
    Route::group(['middleware' => 'admins'], function () {
        // Index
        Route::get('/', ['as' => 'backend.home.index', 'uses' => 'Backend\HomeController@getIndex']);

        // Notification
        Route::get('notification', ['as' => 'backend.notification.index', 'uses' => 'Backend\NotificationController@getList']);
        Route::get('notification/{id}/read', ['as' => 'backend.notification.click', 'uses' => 'Backend\NotificationController@getClick']);
        Route::post('notification/read', ['as' => 'backend.notification.readall', 'uses' => 'Backend\NotificationController@setRead']);
        Route::get('useraccount', ['as' => 'backend.useraccount.index', 'uses' => 'Backend\AdminUserController@getAccount']);
        Route::post('useraccount', ['as' => 'backend.useraccount.update', 'uses' => 'Backend\AdminUserController@postAccount']);
        Route::post('updatepassword', ['as' => 'backend.useraccount.updatepassword', 'uses' => 'Backend\AdminUserController@updatePassword']);
    });

    // ----- SITE CMS -----
    // Menu management
    Route::group(['prefix' => 'menus'], function () {
        Route::get('index', ['as' => 'backend.menus.index', 'uses' => 'Backend\MenuController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.menus.index.json', 'uses' => 'Backend\MenuController@postIndexJson']);
        Route::get('create', ['as' => 'backend.menus.create', 'uses' => 'Backend\MenuController@getCreate']);
        Route::post('create', ['as' => 'backend.menus.store', 'uses' => 'Backend\MenuController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.menus.edit', 'uses' => 'Backend\MenuController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.menus.update', 'uses' => 'Backend\MenuController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.menus.destroy', 'uses' => 'Backend\MenuController@postDelete']);
    });

    Route::group(['prefix' => 'discussioncategories', 'middleware' => 'admin'], function () {
        Route::get('index', ['as' => 'backend.discussioncategories.index', 'uses' => 'Backend\DiscussionCategoryController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.discussioncategories.index.json', 'uses' => 'Backend\DiscussionCategoryController@postIndexJson']);
        Route::get('optionsjson', ['as' => 'backend.discussioncategories.options.json', 'uses' => 'Backend\DiscussionCategoryController@getListJson']);
        Route::get('create', ['as' => 'backend.discussioncategories.create', 'uses' => 'Backend\DiscussionCategoryController@getCreate']);
        Route::post('create', ['as' => 'backend.discussioncategories.store', 'uses' => 'Backend\DiscussionCategoryController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.discussioncategories.edit', 'uses' => 'Backend\DiscussionCategoryController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.discussioncategories.update', 'uses' => 'Backend\DiscussionCategoryController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.discussioncategories.destroy', 'uses' => 'Backend\DiscussionCategoryController@postDelete']);
    });

    Route::group(['prefix' => 'discussions'], function () {
        Route::get('index', ['as' => 'backend.discussions.index', 'uses' => 'Backend\DiscussionController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.discussions.index.json', 'uses' => 'Backend\DiscussionController@postIndexJson']);
    });

    // Content Management
    Route::group(['prefix' => 'content'], function() {
        Route::get('index', ['as' => 'backend.content.index', 'uses' => 'Backend\ContentController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.content.index.json', 'uses' => 'Backend\ContentController@postIndexJson']);
        Route::get('create', ['as' => 'backend.content.create', 'uses' => 'Backend\ContentController@getCreate']);
        Route::post('create', ['as' => 'backend.content.store', 'uses' => 'Backend\ContentController@postCreate']);
        Route::get('{id}', ['as' => 'backend.content.show', 'uses' => 'Backend\ContentController@getView']);
        Route::get('{id}/update', ['as' => 'backend.content.edit', 'uses' => 'Backend\ContentController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.content.update', 'uses' => 'Backend\ContentController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.content.destroy', 'uses' => 'Backend\ContentController@postDelete']);
    });

    // Content Attachment Management
    Route::group(['prefix' => 'contentattachment'], function() {
        Route::get('index', ['as' => 'backend.contentattachment.index', 'uses' => 'Backend\ContentAttachmentController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.contentattachment.index.json', 'uses' => 'Backend\ContentAttachmentController@postIndexJson']);
        Route::get('create', ['as' => 'backend.contentattachment.create', 'uses' => 'Backend\ContentAttachmentController@getCreate']);
        Route::post('create', ['as' => 'backend.contentattachment.store', 'uses' => 'Backend\ContentAttachmentController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.contentattachment.edit', 'uses' => 'Backend\ContentAttachmentController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.contentattachment.update', 'uses' => 'Backend\ContentAttachmentController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.contentattachment.destroy', 'uses' => 'Backend\ContentAttachmentController@postDelete']);
    });

    // FAQ Management
    Route::group(['prefix' => 'faq'], function() {
        Route::get('index', ['as' => 'backend.faq.index', 'uses' => 'Backend\FaqController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.faq.index.json', 'uses' => 'Backend\FaqController@postIndexJson']);
        Route::get('create', ['as' => 'backend.faq.create', 'uses' => 'Backend\FaqController@getCreate']);
        Route::post('create', ['as' => 'backend.faq.store', 'uses' => 'Backend\FaqController@postCreate']);
        Route::get('{id}', ['as' => 'backend.faq.show', 'uses' => 'Backend\FaqController@getView']);
        Route::get('{id}/update', ['as' => 'backend.faq.edit', 'uses' => 'Backend\FaqController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.faq.update', 'uses' => 'Backend\FaqController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.faq.destroy', 'uses' => 'Backend\FaqController@postDelete']);
    });

    // Banner Images Management
    Route::group(['prefix' => 'bannerimages'], function() {
        Route::get('index', ['as' => 'backend.bannerimages.index', 'uses' => 'Backend\BannerImageController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.bannerimages.index.json', 'uses' => 'Backend\BannerImageController@postIndexJson']);
        Route::get('create', ['as' => 'backend.bannerimages.create', 'uses' => 'Backend\BannerImageController@getCreate']);
        Route::post('create', ['as' => 'backend.bannerimages.store', 'uses' => 'Backend\BannerImageController@postCreate']);
        Route::get('{id}', ['as' => 'backend.bannerimages.show', 'uses' => 'Backend\BannerImageController@getView']);
        Route::get('{id}/update', ['as' => 'backend.bannerimages.edit', 'uses' => 'Backend\BannerImageController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.bannerimages.update', 'uses' => 'Backend\BannerImageController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.bannerimages.destroy', 'uses' => 'Backend\BannerImageController@postDelete']);
    });

    // Site Settings
    Route::group(['prefix' => 'settings'], function() {
        Route::get('view', ['as' => 'backend.settings.view', 'uses' => 'Backend\SettingsController@getList']);
        Route::post('save', ['as' => 'backend.settings.save', 'uses' => 'Backend\SettingsController@postSaveSettings']);
    });

    // Email Setting
    Route::group(['prefix' => 'emailsettings'], function() {
        Route::get('index', ['as' => 'backend.emailsettings.index', 'uses' => 'Backend\EmailSettingController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.emailsettings.index.json', 'uses' => 'Backend\EmailSettingController@postIndexJson']);
        Route::get('create', ['as' => 'backend.emailsettings.create', 'uses' => 'Backend\EmailSettingController@getCreate']);
        Route::post('create', ['as' => 'backend.emailsettings.store', 'uses' => 'Backend\EmailSettingController@postCreate']);
        Route::get('{id}', ['as' => 'backend.emailsettings.show', 'uses' => 'Backend\EmailSettingController@getView']);
        Route::get('{id}/update', ['as' => 'backend.emailsettings.edit', 'uses' => 'Backend\EmailSettingController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.emailsettings.update', 'uses' => 'Backend\EmailSettingController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.emailsettings.destroy', 'uses' => 'Backend\EmailSettingController@postDelete']);
    });

    // ----- SITE USERS -----
    // User Management
    Route::group(['prefix' => 'user', 'middleware' => 'admin'], function() {
        Route::get('index', ['as' => 'backend.user.index', 'uses' => 'Backend\UserController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.user.index.json', 'uses' => 'Backend\UserController@postIndexJson']);
        Route::get('optionsjson', ['as' => 'backend.user.options.json', 'uses' => 'Backend\UserController@getListJson']);
        Route::get('create', ['as' => 'backend.user.create', 'uses' => 'Backend\UserController@getCreate']);
        Route::post('create', ['as' => 'backend.user.store', 'uses' => 'Backend\UserController@postCreate']);
        Route::get('{id}', ['as' => 'backend.user.show', 'uses' => 'Backend\UserController@getView']);
        Route::get('{id}/update', ['as' => 'backend.user.edit', 'uses' => 'Backend\UserController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.user.update', 'uses' => 'Backend\UserController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.user.destroy', 'uses' => 'Backend\UserController@postDelete']);
        Route::get('exportxls', ['as' => 'backend.user.exportxls', 'uses' => 'Backend\UserController@exportToExcel']);
        /*Route::get('lastvisit', ['as' => 'backend.user.getlastvisit', 'uses' => 'Backend\UserController@getLastVisit']);
        Route::post('lastvisit', ['as' => 'backend.user.postlastvisit', 'uses' => 'Backend\UserController@postLastVisit']);

        Route::get('template', ['as' => 'backend.user.template', 'uses' => 'Backend\UserController@template']);
        Route::get('downloadtemplate', ['as' => 'backend.user.downloadtemplate', 'uses' => 'Backend\UserController@downloadTemplate']);
        Route::post('importfromtemplate', ['as' => 'backend.user.importfromtemplate', 'uses' => 'Backend\UserController@importFromTemplate']);*/

        Route::get('updateprofile', ['as' => 'admin.user.updateprofile', 'uses' => 'Backend\UserController@updateProfile']);
        Route::post('updateprofile', ['as' => 'admin.user.updateprofile.save', 'uses' => 'Backend\UserController@postUpdateProfile']);
    });

    // ----- MASTERDATA -----
    // Province Management
    Route::group(['prefix' => 'province', 'middleware' => 'admin'], function () {
        Route::get('index', ['as' => 'backend.province.index', 'uses' => 'Backend\ProvinceController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.province.index.json', 'uses' => 'Backend\ProvinceController@postIndexJson']);
        Route::get('create', ['as' => 'backend.province.create', 'uses' => 'Backend\ProvinceController@getCreate']);
        Route::post('create', ['as' => 'backend.province.store', 'uses' => 'Backend\ProvinceController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.province.edit', 'uses' => 'Backend\ProvinceController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.province.update', 'uses' => 'Backend\ProvinceController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.province.destroy', 'uses' => 'Backend\ProvinceController@postDelete']);
    });

    // City Management
    Route::group(['prefix' => 'city', 'middleware' => 'admin'], function () {
        Route::get('index', ['as' => 'backend.city.index', 'uses' => 'Backend\CityController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.city.index.json', 'uses' => 'Backend\CityController@postIndexJson']);
        Route::get('optionsjson', ['as' => 'backend.city.options.json', 'uses' => 'Backend\CityController@getListJson']);
        Route::get('create', ['as' => 'backend.city.create', 'uses' => 'Backend\CityController@getCreate']);
        Route::post('create', ['as' => 'backend.city.store', 'uses' => 'Backend\CityController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.city.edit', 'uses' => 'Backend\CityController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.city.update', 'uses' => 'Backend\CityController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.city.destroy', 'uses' => 'Backend\CityController@postDelete']);
    });

    // Kecamatan Management
    Route::group(['prefix' => 'kecamatan', 'middleware' => 'admin'], function () {
        Route::get('index', ['as' => 'backend.kecamatan.index', 'uses' => 'Backend\KecamatanController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.kecamatan.index.json', 'uses' => 'Backend\KecamatanController@postIndexJson']);
        Route::get('create', ['as' => 'backend.kecamatan.create', 'uses' => 'Backend\KecamatanController@getCreate']);
        Route::post('create', ['as' => 'backend.kecamatan.store', 'uses' => 'Backend\KecamatanController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.kecamatan.edit', 'uses' => 'Backend\KecamatanController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.kecamatan.update', 'uses' => 'Backend\KecamatanController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.kecamatan.destroy', 'uses' => 'Backend\KecamatanController@postDelete']);
    });

    // Kelurahan Management
    Route::group(['prefix' => 'kelurahan', 'middleware' => 'admin'], function () {
        Route::get('index', ['as' => 'backend.kelurahan.index', 'uses' => 'Backend\KelurahanController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.kelurahan.index.json', 'uses' => 'Backend\KelurahanController@postIndexJson']);
        Route::get('create', ['as' => 'backend.kelurahan.create', 'uses' => 'Backend\KelurahanController@getCreate']);
        Route::post('create', ['as' => 'backend.kelurahan.store', 'uses' => 'Backend\KelurahanController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.kelurahan.edit', 'uses' => 'Backend\KelurahanController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.kelurahan.update', 'uses' => 'Backend\KelurahanController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.kelurahan.destroy', 'uses' => 'Backend\KelurahanController@postDelete']);
    });
    
    // ----- REPORTS -----

    /* SUITEVENT ROUTE */

    // Performer Candidate Management
    Route::group(['prefix' => 'performer-candidates', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.performer-candidate.index', 'uses' => 'Backend\PerformerCandidateController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.performer-candidate.index.json', 'uses' => 'Backend\PerformerCandidateController@postIndexJson']);
        Route::get('optionsjson', ['as' => 'backend.performer-candidate.options.json', 'uses' => 'Backend\PerformerCandidateController@getListJson']);
        Route::get('create', ['as' => 'backend.performer-candidate.create', 'uses' => 'Backend\PerformerCandidateController@getCreate']);
        Route::post('create', ['as' => 'backend.performer-candidate.store', 'uses' => 'Backend\PerformerCandidateController@postCreate']);
        Route::get('{id}', ['as' => 'backend.performer-candidate.show', 'uses' => 'Backend\PerformerCandidateController@getView']);
        Route::get('{id}/update', ['as' => 'backend.performer-candidate.edit', 'uses' => 'Backend\PerformerCandidateController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.performer-candidate.update', 'uses' => 'Backend\PerformerCandidateController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.performer-candidate.destroy', 'uses' => 'Backend\PerformerCandidateController@postDelete']);
    });

    // Performer Group Management
    Route::group(['prefix' => 'performer-groups', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.performer-group.index', 'uses' => 'Backend\PerformerGroupController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.performer-group.index.json', 'uses' => 'Backend\PerformerGroupController@postIndexJson']);
        Route::get('create', ['as' => 'backend.performer-group.create', 'uses' => 'Backend\PerformerGroupController@getCreate']);
        Route::post('create', ['as' => 'backend.performer-group.store', 'uses' => 'Backend\PerformerGroupController@postCreate']);
        #Route::get('{id}', ['as' => 'backend.performer-group.show', 'uses' => 'Backend\PerformerGroupController@getView']);
        #Route::get('{id}/update', ['as' => 'backend.performer-group.edit', 'uses' => 'Backend\PerformerGroupController@getUpdate']);
        #Route::post('{id}/update', ['as' => 'backend.performer-group.update', 'uses' => 'Backend\PerformerGroupController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.performer-group.destroy', 'uses' => 'Backend\PerformerGroupController@postDelete']);
        Route::get('exportxls', ['as' => 'backend.performer-group.exportxls', 'uses' => 'Backend\PerformerGroupController@exportToExcel']);
    });

    // Performer Management
    Route::group(['prefix' => 'performers', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.performer.index', 'uses' => 'Backend\PerformerController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.performer.index.json', 'uses' => 'Backend\PerformerController@postIndexJson']);
        Route::get('optionsjson', ['as' => 'backend.performer.options.json', 'uses' => 'Backend\PerformerController@getListJson']);
        Route::get('create', ['as' => 'backend.performer.create', 'uses' => 'Backend\PerformerController@getCreate']);
        Route::post('create', ['as' => 'backend.performer.store', 'uses' => 'Backend\PerformerController@postCreate']);
        Route::get('{id}', ['as' => 'backend.performer.show', 'uses' => 'Backend\PerformerController@getView']);
        Route::get('{id}/update', ['as' => 'backend.performer.edit', 'uses' => 'Backend\PerformerController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.performer.update', 'uses' => 'Backend\PerformerController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.performer.destroy', 'uses' => 'Backend\PerformerController@postDelete']);
    });

    // Performer Specification Management
    Route::group(['prefix' => 'performerspec', 'middleware' => 'admins'], function () {
        Route::post('indexjson', ['as' => 'backend.performerspec.index.json', 'uses' => 'Backend\PerformerSpecificationController@postIndexJson']);
        Route::get('create', ['as' => 'backend.performerspec.create', 'uses' => 'Backend\PerformerSpecificationController@getCreate']);
        Route::post('create', ['as' => 'backend.performerspec.store', 'uses' => 'Backend\PerformerSpecificationController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.performerspec.edit', 'uses' => 'Backend\PerformerSpecificationController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.performerspec.update', 'uses' => 'Backend\PerformerSpecificationController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.performerspec.destroy', 'uses' => 'Backend\PerformerSpecificationController@postDelete']);
    });

    // Stage Management
    Route::group(['prefix' => 'stages', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.stage.index', 'uses' => 'Backend\StageController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.stage.index.json', 'uses' => 'Backend\StageController@postIndexJson']);
        Route::get('optionsjson', ['as' => 'backend.stage.options.json', 'uses' => 'Backend\StageController@getListJson']);
        Route::get('create', ['as' => 'backend.stage.create', 'uses' => 'Backend\StageController@getCreate']);
        Route::post('create', ['as' => 'backend.stage.store', 'uses' => 'Backend\StageController@postCreate']);
        Route::get('{id}', ['as' => 'backend.stage.show', 'uses' => 'Backend\StageController@getView']);
        Route::get('{id}/update', ['as' => 'backend.stage.edit', 'uses' => 'Backend\StageController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.stage.update', 'uses' => 'Backend\StageController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.stage.destroy', 'uses' => 'Backend\StageController@postDelete']);
    });

    // Schedule Management
    Route::group(['prefix' => 'schedules', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.schedule.index', 'uses' => 'Backend\ScheduleController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.schedule.index.json', 'uses' => 'Backend\ScheduleController@postIndexJson']);
        Route::get('create', ['as' => 'backend.schedule.create', 'uses' => 'Backend\ScheduleController@getCreate']);
        Route::post('create', ['as' => 'backend.schedule.store', 'uses' => 'Backend\ScheduleController@postCreate']);
        Route::get('{id}', ['as' => 'backend.schedule.show', 'uses' => 'Backend\ScheduleController@getView']);
        Route::get('{id}/update', ['as' => 'backend.schedule.edit', 'uses' => 'Backend\ScheduleController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.schedule.update', 'uses' => 'Backend\ScheduleController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.schedule.destroy', 'uses' => 'Backend\ScheduleController@postDelete']);
    });

    // Performer Schedule Management
    Route::group(['prefix' => 'performerschedule', 'middleware' => 'admins'], function () {
        Route::post('indexjson', ['as' => 'backend.performerschedule.index.json', 'uses' => 'Backend\PerformerScheduleController@postIndexJson']);
        Route::get('create', ['as' => 'backend.performerschedule.create', 'uses' => 'Backend\PerformerScheduleController@getCreate']);
        Route::post('create', ['as' => 'backend.performerschedule.store', 'uses' => 'Backend\PerformerScheduleController@postCreate']);
        Route::post('{id}/destroy', ['as' => 'backend.performerschedule.destroy', 'uses' => 'Backend\PerformerScheduleController@postDelete']);
    });

    // Performer Gallery Management
    Route::group(['prefix' => 'performergallery', 'middleware' => 'admins'], function () {
        Route::post('indexjson', ['as' => 'backend.performergallery.index.json', 'uses' => 'Backend\PerformerGalleryController@postIndexJson']);
        Route::get('create', ['as' => 'backend.performergallery.create', 'uses' => 'Backend\PerformerGalleryController@getCreate']);
        Route::post('create', ['as' => 'backend.performergallery.store', 'uses' => 'Backend\PerformerGalleryController@postCreate']);
        Route::post('{id}/destroy', ['as' => 'backend.performergallery.destroy', 'uses' => 'Backend\PerformerGalleryController@postDelete']);
    });

    // Performer Review Management
    Route::group(['prefix' => 'performerreview', 'middleware' => 'admins'], function () {
        Route::post('indexjson', ['as' => 'backend.performerreview.index.json', 'uses' => 'Backend\PerformerReviewController@postIndexJson']);
        Route::get('create', ['as' => 'backend.performerreview.create', 'uses' => 'Backend\PerformerReviewController@getCreate']);
        Route::post('create', ['as' => 'backend.performerreview.store', 'uses' => 'Backend\PerformerReviewController@postCreate']);
        Route::get('{id}/update', ['as' => 'backend.performerreview.edit', 'uses' => 'Backend\PerformerReviewController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.performerreview.update', 'uses' => 'Backend\PerformerReviewController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.performerreview.destroy', 'uses' => 'Backend\PerformerReviewController@postDelete']);
    });


    // Sponsor Management
    Route::group(['prefix' => 'sponsors', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.sponsor.index', 'uses' => 'Backend\SponsorController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.sponsor.index.json', 'uses' => 'Backend\SponsorController@postIndexJson']);
        Route::get('create', ['as' => 'backend.sponsor.create', 'uses' => 'Backend\SponsorController@getCreate']);
        Route::post('create', ['as' => 'backend.sponsor.store', 'uses' => 'Backend\SponsorController@postCreate']);
        Route::get('{id}', ['as' => 'backend.sponsor.show', 'uses' => 'Backend\SponsorController@getView']);
        Route::get('{id}/update', ['as' => 'backend.sponsor.edit', 'uses' => 'Backend\SponsorController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.sponsor.update', 'uses' => 'Backend\SponsorController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.sponsor.destroy', 'uses' => 'Backend\SponsorController@postDelete']);
    });

    // Gallery Management
    Route::group(['prefix' => 'galleries', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.gallery.index', 'uses' => 'Backend\GalleryController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.gallery.index.json', 'uses' => 'Backend\GalleryController@postIndexJson']);
        Route::get('create', ['as' => 'backend.gallery.create', 'uses' => 'Backend\GalleryController@getCreate']);
        Route::post('create', ['as' => 'backend.gallery.store', 'uses' => 'Backend\GalleryController@postCreate']);
        Route::get('{id}', ['as' => 'backend.gallery.show', 'uses' => 'Backend\GalleryController@getView']);
        Route::get('{id}/update', ['as' => 'backend.gallery.edit', 'uses' => 'Backend\GalleryController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.gallery.update', 'uses' => 'Backend\GalleryController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.gallery.destroy', 'uses' => 'Backend\GalleryController@postDelete']);
    });

    // Attraction Management
    Route::group(['prefix' => 'locations', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.attraction.index', 'uses' => 'Backend\AttractionController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.attraction.index.json', 'uses' => 'Backend\AttractionController@postIndexJson']);
        Route::get('create', ['as' => 'backend.attraction.create', 'uses' => 'Backend\AttractionController@getCreate']);
        Route::post('create', ['as' => 'backend.attraction.store', 'uses' => 'Backend\AttractionController@postCreate']);
        Route::get('{id}', ['as' => 'backend.attraction.show', 'uses' => 'Backend\AttractionController@getView']);
        Route::get('{id}/update', ['as' => 'backend.attraction.edit', 'uses' => 'Backend\AttractionController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.attraction.update', 'uses' => 'Backend\AttractionController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.attraction.destroy', 'uses' => 'Backend\AttractionController@postDelete']);
    });

    // Participant Management
    Route::group(['prefix' => 'participants', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.participant.index', 'uses' => 'Backend\ParticipantController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.participant.index.json', 'uses' => 'Backend\ParticipantController@postIndexJson']);
        Route::get('create', ['as' => 'backend.participant.create', 'uses' => 'Backend\ParticipantController@getCreate']);
        Route::post('create', ['as' => 'backend.participant.store', 'uses' => 'Backend\ParticipantController@postCreate']);
        Route::get('{id}', ['as' => 'backend.participant.show', 'uses' => 'Backend\ParticipantController@getView']);
        Route::get('{id}/update', ['as' => 'backend.participant.edit', 'uses' => 'Backend\ParticipantController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.participant.update', 'uses' => 'Backend\ParticipantController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.participant.destroy', 'uses' => 'Backend\ParticipantController@postDelete']);
    });

    // Participant Answer Management
    Route::group(['prefix' => 'participantanswers', 'middleware' => 'admins'], function () {
        Route::post('indexjson', ['as' => 'backend.participantanswer.index.json', 'uses' => 'Backend\ParticipantAnswerController@postIndexJson']);
        Route::get('optionsjson', ['as' => 'backend.participantanswer.options.json', 'uses' => 'Backend\ParticipantAnswerController@getListJson']);
        //Route::get('{id}', ['as' => 'backend.participantanswer.show', 'uses' => 'Backend\ParticipantAnswerController@getView']);
        //Route::get('{id}/update', ['as' => 'backend.participantanswer.edit', 'uses' => 'Backend\ParticipantAnswerController@getUpdate']);
        //Route::post('{id}/update', ['as' => 'backend.participantanswer.update', 'uses' => 'Backend\ParticipantAnswerController@postUpdate']);
    });

    // Survey Question Management
    Route::group(['prefix' => 'surveyquestions', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.surveyquestion.index', 'uses' => 'Backend\SurveyQuestionController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.surveyquestion.index.json', 'uses' => 'Backend\SurveyQuestionController@postIndexJson']);
        Route::get('optionsjson', ['as' => 'backend.surveyquestion.options.json', 'uses' => 'Backend\SurveyQuestionController@getListJson']);
        //Route::get('create', ['as' => 'backend.surveyquestion.create', 'uses' => 'Backend\SurveyQuestionController@getCreate']);
        //Route::post('create', ['as' => 'backend.surveyquestion.store', 'uses' => 'Backend\SurveyQuestionController@postCreate']);
        Route::get('{id}', ['as' => 'backend.surveyquestion.show', 'uses' => 'Backend\SurveyQuestionController@getView']);
        Route::get('{id}/update', ['as' => 'backend.surveyquestion.edit', 'uses' => 'Backend\SurveyQuestionController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.surveyquestion.update', 'uses' => 'Backend\SurveyQuestionController@postUpdate']);
        //Route::post('{id}/destroy', ['as' => 'backend.surveyquestion.destroy', 'uses' => 'Backend\SurveyQuestionController@postDelete']);
    });

    // Survey Answer Management
    Route::group(['prefix' => 'surveyanswers', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.surveyanswer.index', 'uses' => 'Backend\SurveyAnswerController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.surveyanswer.index.json', 'uses' => 'Backend\SurveyAnswerController@postIndexJson']);
        Route::get('create', ['as' => 'backend.surveyanswer.create', 'uses' => 'Backend\SurveyAnswerController@getCreate']);
        Route::post('create', ['as' => 'backend.surveyanswer.store', 'uses' => 'Backend\SurveyAnswerController@postCreate']);
        Route::get('{id}', ['as' => 'backend.surveyanswer.show', 'uses' => 'Backend\SurveyAnswerController@getView']);
        Route::get('{id}/update', ['as' => 'backend.surveyanswer.edit', 'uses' => 'Backend\SurveyAnswerController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.surveyanswer.update', 'uses' => 'Backend\SurveyAnswerController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.surveyanswer.destroy', 'uses' => 'Backend\SurveyAnswerController@postDelete']);
    });

    // Event Review Management
    Route::group(['prefix' => 'event-reviews', 'middleware' => 'admins'], function() {
        Route::get('index', ['as' => 'backend.eventreview.index', 'uses' => 'Backend\EventReviewController@getIndex']);
        Route::post('indexjson', ['as' => 'backend.eventreview.index.json', 'uses' => 'Backend\EventReviewController@postIndexJson']);
        Route::get('create', ['as' => 'backend.eventreview.create', 'uses' => 'Backend\EventReviewController@getCreate']);
        Route::post('create', ['as' => 'backend.eventreview.store', 'uses' => 'Backend\EventReviewController@postCreate']);
        Route::get('{id}', ['as' => 'backend.eventreview.show', 'uses' => 'Backend\EventReviewController@getView']);
        Route::get('{id}/update', ['as' => 'backend.eventreview.edit', 'uses' => 'Backend\EventReviewController@getUpdate']);
        Route::post('{id}/update', ['as' => 'backend.eventreview.update', 'uses' => 'Backend\EventReviewController@postUpdate']);
        Route::post('{id}/destroy', ['as' => 'backend.eventreview.destroy', 'uses' => 'Backend\EventReviewController@postDelete']);
    });
});

// Route API
include ("routes_api.php");

// Route Frontend
include ("routes_frontend.php");

// Plugins
Route::group(['middleware' => 'auth'], function() {
    Route::get('elfinder', 'Barryvdh\Elfinder\ElfinderController@showIndex');
    Route::any('elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
    Route::get('elfinder/tinymce', 'Barryvdh\Elfinder\ElfinderController@showTinyMCE4');
});
