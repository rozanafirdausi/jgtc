@extends('backend.admin.layouts.base')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a>Content Management</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('backend.content.index') }}">Content</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('backend.content.show', ['id'=>$baseObject->content_id]) }}">{{ ($baseObject->content ? $baseObject->content->getFormattedValue() : "Unknown Content") }}</a>
            <i class="fa fa-circle"></i>
        </li>
            <li>Add New {{ $baseObject->getLabel() }}</li>
        <li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- FLASH NOTIFICATION -->
@include('backend.admin.partials.flashnotification')

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Create {{ $baseObject->_label }}
    <!-- <small>subtitle</small> -->
</h3>
<!-- END PAGE TITLE-->
<!-- BEGIN CONTENT -->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-green-haze">
                    <i class="{{ $pageIcon or 'icon-badge'}} font-green-haze"></i>&nbsp;
                    <span class="caption-subject bold uppercase">{{ $baseObject->_label }} Form</span>
                </div>
                <div class="actions">
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($baseObject, ['files'=> true, 'id'=>class_basename($baseObject) . '_form', 'class' => 'form-horizontal']) !!}
                @include($viewBaseClosure . '.form')

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10">
                            <a onClick="return confirm('Your changes will be not saved! Are you sure?');" href="{{ route('backend.content.show', ['id' => $baseObject->content_id]) }}" class="btn default">Cancel</a>
                            <input type="submit" class="btn blue" value="Save"/>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- END FORM PORTLET-->
    </div>
</div>
<!-- END CONTENT -->
@stop

@section('page_script')
@stop