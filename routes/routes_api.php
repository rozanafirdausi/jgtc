<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'api/v1', 'middleware' => 'api'], function() {
    // Authentication
    Route::post('login', ['as' => 'api.v1.login', 'uses' => 'Api\AuthController@login']);
    Route::post('logout', ['as' => 'api.v1.logout', 'uses' => 'Api\AuthController@logout', 'middleware' => 'authenticatedapi']);

    // Menu API
    Route::get('menus', ['as' => 'api.v1.menus.index', 'uses' => 'Api\DynamicMenuController@getIndex']);

    // Content API
    Route::get('contents', ['as' => 'api.v1.contents.index', 'uses' => 'Api\ContentController@getIndex']);
    Route::get('contents/{id}', ['as' => 'api.v1.contents.index', 'uses' => 'Api\ContentController@getDetail']);

    // Setting API
    Route::get('settings', ['as' => 'api.v1.settings.index', 'uses' => 'Api\SettingController@getIndex']);

    // Performer Candidate API
    Route::get('performer-candidates/supporting-artists/{mainId?}', ['as' => 'api.v1.performer-candidates.supporting-artist.index', 'uses' => 'Api\PerformerCandidateController@getSupportingArtist']);
    Route::get('performer-candidates/{type?}', ['as' => 'api.v1.performer-candidates.index', 'uses' => 'Api\PerformerCandidateController@getIndex']);
    Route::post('performer-candidates', ['as' => 'api.v1.performer-candidates.vote', 'uses' => 'Api\PerformerCandidateController@postVote']);

    // Performer Group API
    Route::get('performer-groups', ['as' => 'api.v1.performer-groups.index', 'uses' => 'Api\PerformerGroupController@getIndex']);
    Route::post('performer-groups/vote', ['as' => 'api.v1.performer-groups.vote', 'uses' => 'Api\PerformerGroupController@postVote']);

    // Performer API
    Route::get('performers', ['as' => 'api.v1.performers.index', 'uses' => 'Api\PerformerController@getIndex']);
    Route::get('performers/{id}', ['as' => 'api.v1.performers.show', 'uses' => 'Api\PerformerController@getDetail']);

    // Performer Review API
    Route::post('performer-reviews', ['as' => 'api.v1.performerreview.store', 'uses' => 'Api\PerformerReviewController@postCreate']);

    // Stage API
    Route::get('stages', ['as' => 'api.v1.stages.index', 'uses' => 'Api\StageController@getIndex']);
    Route::get('stages/{id}', ['as' => 'api.v1.stages.show', 'uses' => 'Api\StageController@getDetail']);

    // Schedule API
    Route::get('schedules', ['as' => 'api.v1.schedules.index', 'uses' => 'Api\ScheduleController@getIndex']);
    Route::get('schedules/{id}', ['as' => 'api.v1.schedules.show', 'uses' => 'Api\ScheduleController@getDetail']);

    // Banner API
    Route::get('banner-images', ['as' => 'api.v1.banner-images.index', 'uses' => 'Api\BannerImageController@getIndex']);
    Route::get('banner-images/{id}', ['as' => 'api.v1.banner-images.show', 'uses' => 'Api\BannerImageController@getDetail']);

    // Sponsor API
    Route::get('sponsors', ['as' => 'api.v1.sponsors.index', 'uses' => 'Api\SponsorController@getIndex']);

    // Gallery API
    Route::get('galleries', ['as' => 'api.v1.galleries.index', 'uses' => 'Api\GalleryController@getIndex']);
    Route::get('galleries/{id}', ['as' => 'api.v1.galleries.index', 'uses' => 'Api\GalleryController@getDetail']);

    // Attraction API
    Route::get('locations', ['as' => 'api.v1.attractions.index', 'uses' => 'Api\AttractionController@getIndex']);
    Route::post('locations', ['as' => 'api.v1.attractions.store', 'uses' => 'Api\AttractionController@postCreate']);

    // Event Review API
    Route::get('event-reviews', ['as' => 'api.v1.event-reviews.index', 'uses' => 'Api\EventReviewController@getIndex']);
    Route::post('event-reviews', ['as' => 'api.v1.event-reviews.store', 'uses' => 'Api\EventReviewController@postCreate']);

    // City API
    Route::get('cities', ['as' => 'api.v1.cities.index', 'uses' => 'Api\CityController@getIndex']);

    // Discussion API
    Route::get('discussions', ['as' => 'api.v1.discussions.index', 'uses' => 'Api\DiscussionController@getIndex']);
    Route::post('discussions', ['as' => 'api.v1.discussions.store', 'uses' => 'Api\DiscussionController@postCreate']);

    // Discussion Category API
    Route::get('discussion-categories', ['as' => 'api.v1.discussions.index', 'uses' => 'Api\DiscussionCategoryController@getIndex']);

    /// CUSTOM API (SPECIFIC PER PAGE)
    // Home API
    Route::get('home-page', ['as' => 'api.v1.home-page', 'uses' => 'Api\HomeController@getHomePage']);
    // Vote Page API
    Route::get('vote-page', ['as' => 'api.v1.vote-page', 'uses' => 'Api\PerformerCandidateController@getVotePage']);
    // Ticket Page API
    Route::get('ticket-page', ['as' => 'api.v1.ticket-page', 'uses' => 'Api\BannerImageController@getTicketPage']);
    // Volunteer API
    Route::post('volunteers', ['as' => 'api.v1.volunteer.register', 'uses' => 'Api\ParticipantController@postVolunteerRegistration']);
});

Route::group(['prefix' => 'v2', 'middleware' => 'api'], function() {
    // Volunteer API
    Route::post('volunteers', ['as' => 'api.v2.volunteer.register', 'uses' => 'Api\ParticipantController@postVolunteerRegistrationV2']);
});