@extends('backend.admin.layouts.base')

@section ('style-head')
	<link type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
@stop

@section('content')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a>User Management</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ route($routeBaseName . '.index') }}">{{ $baseObject->_label }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Get last visit</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->

    <!-- FLASH NOTIFICATION -->
    @include('backend.admin.partials.flashnotification')

    @if (Session::has('error'))
        <div class="isa_error"><i class="fa fa-close"></i> {{ Session::get('error') }}</div>
    @endif
    @if (Session::has('success'))
        <div class="isa_success"><i class="fa fa-check"></i> {{ Session::get('success') }}</div>
    @endif

    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title">Last Visit Report
        <!-- <small>subtitle</small> -->
    </h3>
    <!-- END PAGE TITLE-->
    <!-- BEGIN CONTENT -->
    <div class="row">
      <div class="col-md-12">
          <!-- Begin: life time stats -->
          <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                  <div class="caption">
                      <i class="{{ $pageIcon or 'icon-badge'}} font-dark"></i>&nbsp;
                      <span class="caption-subject font-dark sbold uppercase">Get last visit user</span>
                  </div>
            </div>
            <div class="portlet-body">
            <div class="table-container">
                {!! Form::open(['route' => 'backend.user.postlastvisit', 'files'=> true, 'id'=>'form_setting', 'class' => 'form-horizontal']) !!}
                <div class="form-group form-md-line-input">
                <label class="col-md-2 control-label">Date Range</label>
                    <div class="col-md-5">
                        <label class="col-md-5 control-label">Start Date (WIB)</label>
                        <div class="col-md-7">
                            <input data-datetime-input class="form-control" name="start_date" required>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label class="col-md-5 control-label">End Date (WIB)</label>
                        <div class="col-md-7">
                            <input data-datetime-input class="form-control" name="end_date" required>
                        </div>
                    </div>
                </div>

                 <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-10">
                            <input type="submit" class="btn blue" value="Download"/>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
          </div>
      </div>
    </div>
    <!-- End: life time stats -->
    </div>
    </div>
    <!-- END CONTENT -->
@stop

@section('script-footer')
@stop
