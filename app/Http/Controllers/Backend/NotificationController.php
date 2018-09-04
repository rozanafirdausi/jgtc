<?php

namespace App\Http\Controllers\Backend;

use App;
use App\SuitEvent\Controllers\BackendController;
use App\SuitEvent\Models\Notification;
use App\SuitEvent\Repositories\NotificationRepository;
use Auth;
use Illuminate\Http\Request;
use Redirect;
use View;

class NotificationController extends BackendController
{
    /**
     * Override Default Constructor
     * @param  NotificationRepository $_baseRepo
     * @param  Notification $_baseModel
     * @return void
     */
    public function __construct(NotificationRepository $_baseRepo, Notification $_baseModel)
    {
        parent::__construct($_baseRepo, $_baseModel);
        $this->routeBaseName = "backend.notification";
        $this->routeDefaultIndex = "backend.notification.index";
        $this->viewBaseClosure = "backend.admin.notifications";
        $this->viewInstanceName = 'baseObject';
        // page ID
        $this->pageId = 'A2';
        View::share('pageId', $this->pageId);
        View::share('pageTitle', 'Notification');
        View::share('pageIcon', 'fa fa-bell-o');
        View::share('routeBaseName', $this->routeBaseName);
        View::share('routeDefaultIndex', $this->routeDefaultIndex);
        View::share('viewBaseClosure', $this->viewBaseClosure);
    }

    /**
     * Remove an item from notification list
     *
     * @param $id ID of notification item
     * @return Redirect
     **/
    public function deleteRemove($id)
    {
        $user = Auth::user();
        if ($user == null) {
            App::abort(404);
        }
        $notification = Notification::find($id);
        if ($notification && $notification->user_id == $user->id) {
            // only authorized user can delete a notification item
            $notification->delete();
        }
        return Redirect::route('frontend.notification.list');
    }

    /**
     * Show list of notification from certain users
     *
     * @return View of table that contains notification item list
     **/
    public function getList()
    {
        $user = auth()->user();
        if (!$user) {
            App::abort(404);
        }
        $input = \Input::all();
        $param = [];
        $param['_user_id'] = $user->id;
        $param['orderBy'] = (isset($input['orderBy']) ? $input['orderBy'] : 'created_at');
        $param['orderType'] = (isset($input['orderType']) ? $input['orderType'] : 'desc');
        $param['paginate'] = true;
        $param['perPage'] = (isset($input['perPage']) ? $input['perPage'] : 15);
        $currentSetting = 'allnewest';
        if ($param['orderType'] == 'asc') {
            $currentSetting = 'alloldest';
        }
        if (isset($input['is_read'])) {
            $param['is_read'] = intval($input['is_read']);
            if ($param['is_read'] == 0) {
                if ($param['orderType'] == 'desc') {
                    $currentSetting = 'unreadnewest';
                } else {
                    $currentSetting = 'unreadoldest';
                }
            }
        }
        // render
        $notifications = $this->baseRepository->getByParameter($param);

        return view('backend.admin.notifications.index')
        ->with(['notifications' => $notifications, 'user' => $user, 'currentSetting' => $currentSetting]);
    }

    public function deleteSelected(Request $request)
    {
        $user = Auth::user();
        if ($user == null) {
            App::abort(404);
        }
        $param['id'] = implode(',', $request->get('id'));
        $notifications = $this->baseRepository->getByParameter($param);
        $ids = $notifications->pluck('id')->toArray();
        $this->baseRepository->deleteSelected($ids);
        \Session::flash('SUCCESS_MESSAGE', 'Successfully delete selected notifications');
        return redirect(route('frontend.notification.list'));
    }

    public function getClick($id)
    {
        $notification = $this->baseRepository->get($id)['object'];
        $notification->update(['is_read' => true]);

        return redirect()->to($notification->url ?: route('frontend.notification.list'));
    }

    public function setRead(Request $request)
    {
        if (isset($request->id)) {
            $user = auth()->user();
            $param['_user_id'] = $user->id;
            $param['id'] = implode(',', $request->get('id'));
            $notifications = $this->baseRepository->getByParameter($param);
            $ids = $notifications->pluck('id')->toArray();
            $this->baseRepository->read($ids);

            $this->showNotification(
                self::
                NOTICE_NOTIFICATION,
                'Set as read notification',
                'Notifications has been set as read'
            );
        } else {
            $this->showNotification(
                self::
                WARNING_NOTIFICATION,
                'Set as read notification',
                'Check a notification which will be set as read'
            );
        }

        return redirect()->back();
    }
}
