@extends('backend.admin.layouts.base')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a>Interaction Management</a>
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
          {{-- <p>Daftar participant (volunteer, attendee, committee, etc.)</a> </p> --}}
          <p>Daftar volunteer</a> </p>
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
            <div class="toggles block">
              <div class="block">
                  <a class="toggles__trigger btn btn--sm btn--plain text-left" data-target="#filterColumn">
                      Filter
                      <span class="fa fa-fw fa-caret-down"></span>
                  </a>
              </div>
              <div class="toggles__content hide-element" id="filterColumn">
                <?php
                  $yadcfContainer = [];
                  $yadcfIdx = 0;
                ?>
                @foreach($baseObject->getBufferedAttributeSettings() as $key=>$val)
                  @if( isset($val['visible']) && $val['visible'] )
                    @if( isset($val['filterable']) && $val['filterable'] )
                      <div class="form-group form-md-line-input">
                        <label class="col-md-2 control-label">Filter by {{ $val['label'] }}</label>
                          <div class="col-md-8">
                              <span id="{{$key}}Filter"
                                data-filter-column="{{ $yadcfIdx }}"
                                data-filter-type="{{ in_array($val['type'], ['datetime', 'date']) ? $val['type'] : 'select' }}"
                                @if($key == 'user_id')
                                  data-filter-url-ajax="{{ route('backend.user.options.json') }}"
                                @endif
                                @if($key == 'city_id')
                                  data-filter-url-ajax="{{ route('backend.city.options.json') }}"
                                @endif
                                data-filter-default-label="-- select {{ strtolower($val['label']) }} --"></span>
                          </div>
                      </div>
                      <?php $yadcfContainer[] = $key . "Filter"; ?>
                    @endif
                    <?php $yadcfIdx++; ?>
                  @endif
                @endforeach
              </div>
            </div><br><br>

            <table id="{{ class_basename($baseObject) }}" class="table table-striped table-bordered table-hover"
              data-datatable-yadcf="{{ route($routeBaseName . '.index.json') . "?_token=" . csrf_token() }}"
              data-datatable-yadcf-container="{{ implode(',', $yadcfContainer) }}"
              data-start="{{ session()->get('datatable['.$pageId.'][iDisplayStart]', 0) }}"
              data-length="{{ session()->get('datatable['.$pageId.'][iDisplayLength]', 10) }}">
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
