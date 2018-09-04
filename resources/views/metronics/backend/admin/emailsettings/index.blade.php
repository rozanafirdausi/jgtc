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
            <a href="{{ route($routeBaseName . '.index') }}">{{ $baseObject->_label }}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>List</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- FLASH NOTIFICATION -->
@include('backend.admin.partials.flashnotification')

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">{{ $baseObject->_label }} List
    <!-- <small>subtitle</small> -->
</h3>
<!-- END PAGE TITLE-->
<!-- BEGIN CONTENT -->
<div class="row">
  <div class="col-md-12">
      <div class="note note-info">
          <p>Pengaturan email yang dikirimkan pada user (admin, customer, dll.) </p>
      </div>
      <!-- Begin: life time stats -->
      <div class="portlet light portlet-fit portlet-datatable bordered">
          <div class="portlet-title">
              <div class="caption">
                  <i class="{{ $pageIcon or 'icon-badge'}} font-dark"></i>&nbsp;
                  <span class="caption-subject font-dark sbold uppercase">Master {{ $baseObject->_label }}</span>
              </div>
              <div class="actions">
                @if( Route::has($routeBaseName . '.create') )
                  {!! App\SuitEvent\SuitMenu::navMenu(route($routeBaseName . ".create"), 'Create New', 'fa fa-sw fa-plus', 'btn btn-sm green btn-outline active') !!}
                @endif
                @if( Route::has($routeBaseName . '.exportxls') )
                  {!! App\SuitEvent\SuitMenu::navMenu(route($routeBaseName . ".exportxls"), 'Export to XLS', 'fa-download', 'btn btn-sm blue btn-outline active') !!}
                @endif
            </div>
        </div>
        <div class="portlet-body">
          <div class="table-container">
              <table id="{{ class_basename($baseObject) }}" class="table table-striped table-bordered table-hover" data-enhance-ajax-table="{{ route($routeBaseName . '.index.json') . "?_token=" . csrf_token() }}">
                <thead>
                    <tr>
                      @foreach($baseObject->getBufferedAttributeSettings() as $key=>$val)
                        @if( $val['visible'] )
                          <th>{{ $val['label'] }}</th>
                        @endif
                      @endforeach
                      <th><b>Menu</b></th>
                  </tr>
              </thead>
          </table>
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
