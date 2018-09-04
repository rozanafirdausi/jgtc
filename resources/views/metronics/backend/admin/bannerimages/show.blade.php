@extends ('backend.admin.layouts.base')

@section('style-page')
<link href="{{ Theme::url('backend/pages/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ Theme::url('backend/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a>Transaction Management</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route($routeBaseName . '.index') }}">{{ $baseObject->_label }}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Detail</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- FLASH NOTIFICATION -->
@include('backend.admin.partials.flashnotification')

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"><span class="font-green sbold uppercase">{{ $baseObject }}</span>
    <small>{{ $baseObject->_label }} Detail</small>
    <div class="actions pull-right">
    </div>
</h3>
<!-- END PAGE TITLE-->
<!-- BEGIN CONTENT -->
<!-- BEGIN SPECIFY -->
<div class="profile">
    <!-- BEGIN BASIC DETIL  -->
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN Portlet PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-green-sharp">
                                <i class="fa fa-black-tie font-green-sharp"></i>&nbsp;
                                <span class="caption-subject bold uppercase">Base Information</span>
                            </div>
                            <div class="actions">
                                @if( Route::has($routeBaseName . '.show') )
                                    {!! App\SuitEvent\SuitMenu::navMenu(route($routeBaseName . ".edit", ['id'=>$baseObject->id]), '', 'icon-pencil', 'btn btn-circle btn-icon-only green tooltips', 'Update') !!}
                                @endif
                                @if( Route::has($routeBaseName . '.destroy') )
                                    {!! App\SuitEvent\SuitMenu::postNavMenu(route($routeBaseName . '.destroy', ['id' => $baseObject->id]), '', csrf_token(), 'Are you sure?', 'icon-trash', 'btn btn-circle btn-icon-only red tooltips', 'Delete') !!}
                                @endif
                                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row form-horizontal form-body">
                                <div class="col-md-12">
                                    @foreach($baseObject->attribute_settings as $key=>$val)
                                    @if( !in_array($key, [ 'id' ] ) )
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">{{ $val['label'] }} :</label>
                                                <div class="col-md-8">
                                                        <p class="form-control-static">
                                                        {!! $baseObject->renderAttribute($key, [
                                                            'type' => [
                                                                App\SuitEvent\Models\BannerImage::TYPE_MAIN => "<span class='label label-blue label-primary'>#type#</span>",
                                                                App\SuitEvent\Models\BannerImage::TYPE_SIDE => "<span class='label label--lime label-warning'>#type#</span>"
                                                            ],
                                                            'status' => [
                                                                App\SuitEvent\Models\BannerImage::STATUS_ACTIVE => "<span class='label label--green label-success'>#status#</span>",
                                                                App\SuitEvent\Models\BannerImage::STATUS_TIMED => "<span class='label label--blue label-info'>#status#</span>",
                                                                App\SuitEvent\Models\BannerImage::STATUS_INACTIVE => "<span class='label label--red label-danger'>#status#</span>"
                                                            ]
                                                        ]) !!}
                                                        </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END BASIC DETIL  -->
</div>
<!-- END SPECIFY -->
<!-- END CONTENT -->
@stop