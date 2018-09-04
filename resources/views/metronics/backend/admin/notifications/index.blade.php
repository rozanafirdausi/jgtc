@extends('backend.admin.layouts.base')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a>Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a>Notification</a>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- FLASH NOTIFICATION -->
@include('backend.admin.partials.flashnotification')

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Notifications
    <!-- <small>subtitle</small> -->
</h3>
<!-- END PAGE TITLE-->
<!-- BEGIN CONTENT -->
<div class="row">
  <div class="col-md-12">
      <div class="col-md-12">
            {!! Form::open(['route' => 'backend.notification.readall']) !!}
            <!-- BEGIN PORTLET -->
            <div class="portlet light tasks-widget">
                <div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase"> <i class="fa fa-bell-o"></i> All Notification</span>
                        <span class="caption-helper">{{ notifCounter() }} unread</span>
                    </div>
                    <div class="actions">
                        @if ($notifications->count() > 0)
                            <button type="submit" class="btn btn-sm green">Mark as read</button>
                        @endif
                    </div>
                </div>
                <div class="portlet-body">
                    @if ($notifications->count() > 0)
                    <!--BEGIN TABS-->
                    <div class="tab-content">
                        <div class="tab-pane active">
                            @foreach ($notifications as $notification)
                            <ul class="task-list">
                                <li>
                                    <div class="task-checkbox">
                                         <input type="checkbox" class="liChild" id="notif_{{ $notification->id }}" name="id[]" value="{{ $notification->id }}">
                                    </div>
                                    <div class="task-title">
                                        <span class="task-title-sp">
                                            @if ($notification->is_read == 1)
                                                <span class="label label-sm label-default">Read</span>
                                            @else
                                                <span class="label label-sm label-info">Unread</span>
                                            @endif
                                            <a href="{{ route('backend.notification.click', ['id' => $notification->id]) }}"> {{$notification->message}} </a>
                                        </span>
                                        <span style="float: right; padding:4px 9px 5px 4px;text-align:right;font-style:italic;color:#c1cbd0;">
                                            {{date("d F Y G:i", strtotime($notification->created_at))}}
                                        </span>
                                    </div>
                                </li>
                            </ul>
                            @endforeach
                            <center>
                                {{ $notifications->render() }}
                            </center>
                        </div>
                    </div>
                    @else
                        <center>
                            <em>Currently you have not yet any notifications.</em>
                        </center>
                    @endif
                    <!--END TABS-->
                </div>
            </div>
            <!-- END PORTLET -->
            {!! Form::close() !!}
        </div>
  </div>
</div>
<!-- End: life time stats -->
</div>
</div>
<!-- END CONTENT -->
@stop

@section('page_script')
  <script>
  </script>
@stop


                                        