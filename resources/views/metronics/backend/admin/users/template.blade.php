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
                <span>Import Data</span>
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
    <h3 class="page-title">Import Data {{ $baseObject->getLabel() }}
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
                      <span class="caption-subject font-dark sbold uppercase">Import {{ $baseObject->_label }} Data From XLS</span>
                  </div>
            </div>
            <div class="portlet-body">
            <div class="table-container">
                <div class="note note-info">
                  <p>Fitur ini hanya dapat digunakan untuk import data pengguna dengan role <b>"user"</b>. Untuk menambahkan pengguna selain role <b>"user"</b>, silahkan tambahkan pada form <a href="{{ route('backend.user.create') }}">berikut</a>.</p>
                </div>
                <ol>
                    <li>
                        <p>Download and fill the {{ strtolower( $baseObject->_label ) }} data in the following template.</p>
                        <a class="btn btn-sm blue btn-outline active" href="{{route($routeBaseName . '.downloadtemplate')}}">
                            <i class="fa fa-download">&nbsp;</i> Download template
                        </a>
                        <br><br>
                    </li>
                    <li>
                        <p>Upload {{ strtolower( $baseObject->_label ) }} data.</p>
                        {!! Form::model($baseObject, ['files'=> true, 'id'=>class_basename($baseObject) . '_import_form', 'route' => $routeBaseName . '.importfromtemplate', 'class' => 'form-horizontal']) !!}
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="file_url">File (*.xls)</label>
                                    <div class="col-md-6">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                <span class="input-group-addon btn default btn-file">
                                                    <span class="fileinput-new"> Select file </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="hidden" value="" name="..."><input type="file" id="file_url" name="file_url" required="required"> </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Option</label>
                                    <div class="col-md-10">
                                        <?php
                                            $keyBaseName = "";
                                            $objAttrSettings = $baseObject->getBufferedAttributeSettings();
                                        ?>
                                        @if(is_array($baseObject->getImportExcelKeyBaseName()))
                                            @foreach($baseObject->getImportExcelKeyBaseName() as $value)
                                                <?php
                                                    $keyBaseName .= $objAttrSettings[$value]['label'] . ",&nbsp;";
                                                ?>
                                            @endforeach
                                        @else
                                            <?php
                                                $keyBaseName = $objAttrSettings[$baseObject->getImportExcelKeyBaseName()]['label'];
                                            ?>
                                        @endif
                                        <div class="md-radio-list">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" name="method" value="ignore" id="method-ignore" checked="checked">
                                                <label for="method-ignore">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Do not replace existing user data with the new user who have same identity number (KTP) in *.xls file.</label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" name="method" value="replace" id="method-replace">
                                                <label for="method-replace">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Replace existing user data with the new user who have same identity number (KTP) in *.xls file.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button class="btn btn-sm green-jungle active" type="submit">
                                            <i class="fa fa-upload">&nbsp;</i> Import
                                        </button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </li>
                </ol>
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
