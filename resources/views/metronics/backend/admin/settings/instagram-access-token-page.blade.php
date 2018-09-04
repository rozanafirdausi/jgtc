@extends('backend.admin.layouts.base')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a>Site Management</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Setting</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Get Instagram Access Token</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- FLASH NOTIFICATION -->
@include('backend.admin.partials.flashnotification')

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Instagram Access Token
    <!-- <small>subtitle</small> -->
</h3>
<!-- END PAGE TITLE-->
<!-- BEGIN CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <div class="note note-info">
                    <p> Please click the button below to get Instagram access token.</p>
                </div>
                {!! Form::open(['route' => 'backend.instagram-access-token.get', 'files'=> true, 'id'=>'form_setting', 'class' => 'form-horizontal']) !!}
                    <input type="hidden" name="instagram_client_id" value="{{ settings('instagram_client_id') }}">
                    <input type="hidden" name="instagram_client_secret" value="{{ settings('instagram_client_secret') }}">
                    <input type="hidden" name="instagram_redirect_uri" value="{{ settings('instagram_redirect_uri') }}">
                    <input type="hidden" name="code" value="{{ \Request::get('code') }}">
                    <button type="submit" class="btn blue-madison"><i class="fa fa-instagram"></i> Get Instagram Access Token</button>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- END FORM PORTLET-->
    </div>
</div>
<!-- END CONTENT -->
@stop

@section('page_script')
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    <script type="text/javascript">
        $('#map').locationpicker({
            location: {latitude: {{ empty(settings('latitude')) ? "-6.194288191779069" : settings('latitude')  }}, longitude: {{ empty(settings('longitude')) ? "106.92647360610965" : settings('longitude')  }} },
            radius: 200,
            inputBinding: {
                latitudeInput: $('#lat'),
                longitudeInput: $('#lng'),
                locationNameInput: $('#areaSearch')
            },
            enableAutocomplete: true
        });
        $('#areaSearch').on('keypress', function(e) {
            var code = e.keyCode || e.which;
            if(code == 13) return false;
        });
    </script>
@stop
