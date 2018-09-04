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
            <a>Miscellaneous Management</a>
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
                                                        {!! $baseObject->renderAttribute($key, []) !!}
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
    <!-- BEGIN SPECIFY INLINE -->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN TAB PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-share font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Related Data</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#portlet_tab1" data-toggle="tab"> Related Performer </span></a></a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <br>
                            <div class="text-right">
                                <a class="btn blue" href="{{ route('backend.performergallery.create')."?gallery_id=".$baseObject->id }}">
                                    <span class="fa fa-fw fa-plus"></span>
                                    Add New
                                </a>
                            </div>

                            <br><br>
                            <table id="performergallery" class="table table--zebra"  data-enhance-ajax-table="{{ route('backend.performergallery.index.json') . "?_token=" . csrf_token() . "&gallery_id=" . $baseObject->id }}">
                              <thead>
                                  <tr>
                                    <td><b>Performer</b></td>
                                    <td><b>Last Update</b></td>
                                    <td><b>Menu</b></td>
                                  </tr>
                              </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TAB PORTLET-->
        </div>
    </div>
    <!-- END SPECIFY INLINE -->
</div>
<!-- END SPECIFY -->
<!-- END CONTENT -->
@stop