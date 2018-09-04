@extends('backend.admin.layouts.base')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a>User Management</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('backend.user.index') }}">User</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ route('backend.user.show', ['id'=>$baseObject->user_id]) }}">{{ ($baseObject->user ? $baseObject->user->getFormattedValue() : "Unknown User") }}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Update {{ $baseObject->getLabel() }}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- FLASH NOTIFICATION -->
@include('backend.admin.partials.flashnotification')

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">Update {{ $baseObject->_label }}
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
                    @if( Route::has($routeBaseName . '.show') )
                        {!! App\SuitEvent\SuitMenu::navMenu(route($routeBaseName . ".show", ['id'=>$baseObject->id]), '', 'icon-eye', 'btn btn-circle btn-icon-only green tooltips', 'Detail') !!}
                    @endif
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::model($baseObject, ['files'=> true, 'id'=>class_basename($baseObject) . '_form', 'class' => 'form-horizontal']) !!}
                @include($viewBaseClosure . '.form')

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10">
                            <a onClick="return confirm('Your changes will be not saved! Are you sure?');" href="{{ route('backend.user.show', ['id' => $baseObject->user_id]) }}" class="btn default">Cancel</a>
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
    <script>
        var initialCity = "{{ $baseObject->city_id }}";
        var initialKecamatan = "{{ $baseObject->kecamatan_id }}";
        var initialKelurahan = "{{ $baseObject->kelurahan_id }}";
        function inputProvinceChange(){
            if ($(this).val() != "") {
                $.get("{{ route('frontend.location.fetcher', ['type'=>'province']) }}", { id: $(this).val() },
                    function(data) {
                        var model = $('#inputCity_id');
                        model.empty();
                        $('#inputKecamatan_id').empty();
                        $('#inputKecamatan_id').append("<option value=''>-- empty, select kabupaten/kota first --</option>");
                        $('#inputKelurahan_id').empty();
                        $('#inputKelurahan_id').append("<option value=''>-- empty, select kecamatan first --</option>");

                        model.append("<option value=''>-- select kabupaten/kota --</option>");
                        $.each(data, function(index, element) {
                            model.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                        });

                        if (initialCity != "") {
                            model.val(initialCity).trigger("change");
                            initialCity = "";
                        } else {
                            model.val("").trigger("change");
                        }
                        $('#inputKecamatan_id').val("").trigger("change");
                        $('#inputKelurahan_id').val("").trigger("change");
                });
            } else {
                $('#inputCity_id').val("").trigger("change");
                $('#inputKecamatan_id').val("").trigger("change");
                $('#inputKelurahan_id').val("").trigger("change");
            }
        }

        function inputKabkotaChange(){
            if ($(this).val() != "") {
                $.get("{{route('frontend.location.fetcher', ['type'=>'city']) }}", { id: $(this).val() },
                    function(data) {
                        var model = $('#inputKecamatan_id');
                        model.empty();
                        $('#inputKelurahan_id').empty();
                        $('#inputKelurahan_id').append("<option value=''>-- empty, select kecamatan first --</option>");

                        model.append("<option value=''>-- select kecamatan --</option>");
                        $.each(data, function(index, element) {
                            model.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                        });

                        if (initialKecamatan != "") {
                            model.val(initialKecamatan).trigger("change");
                            initialKecamatan = "";
                        } else {
                            model.val("").trigger("change");
                        }
                        $('#inputKelurahan_id').val("").trigger("change");
                });
            } else {
                $('#inputKecamatan_id').val("").trigger("change");
                $('#inputKelurahan_id').val("").trigger("change");
            }
        }

        function inputKecamatanChange(){
            if ($(this).val() != "") {
                $.get("{{ route('frontend.location.fetcher', ['type'=>'kecamatan']) }}", { id: $(this).val() },
                    function(data) {
                        var model = $('#inputKelurahan_id');
                        model.empty();
                        model.append("<option value=''>-- select kelurahan --</option>");
                        $.each(data, function(index, element) {
                            model.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                        });

                        if (initialKelurahan != "") {
                            model.val(initialKelurahan).trigger("change");
                            initialKelurahan = "";
                        } else {
                            model.val("").trigger("change");
                        }
                });
            } else {
                $('#inputKelurahan_id').val("").trigger("change");
            }
        }

        $('#inputProvince_id').bind("change", inputProvinceChange);
        $('#inputCity_id').bind("change", inputKabkotaChange);
        $('#inputKecamatan_id').bind("change", inputKecamatanChange);
        // trigger of edit form
        $('#inputProvince_id').trigger("change");
    </script>
@stop