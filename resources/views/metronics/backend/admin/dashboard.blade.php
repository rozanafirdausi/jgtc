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
            <a href="{{ route('backend.home.index') }}">Overview</a>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- FLASH NOTIFICATION -->
@include('backend.admin.partials.flashnotification')

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Overview</h3>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    API Setting
                </div>
            </div>
            <div class="portlet-body form">
                The headers below have to be added in order to enable API usage.<br><br>
                X-PublicKey : <b>{{env('API_PUBLIC_KEY')}}</b> <br><br>
                X-HashKey   : <b>{!! md5(env('API_PUBLIC_KEY') . '+' . env('API_SECRET_KEY')) !!}</b>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE-->
@stop

@section('page_script')

@stop
