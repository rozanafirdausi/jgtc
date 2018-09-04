@extends('backend.admin.layouts.base')

@section('content')
    @section('extra-navigation')
        <li{!! Route::current()->getName() == 'backend.premiumuser.update' ? ' class="active"' : ''!!}><a href="{{route('backend.premiumuser.update', ['id'=>$user->id])}}">Update</a></li>
    @stop
    @include('layouts.premiumusers_nav')
    <br>
    <div class="row">
        <div class="col-sm-12">
            {!! Form::model($user, ['route'=>['backend.premiumuser.update.save', $user->id], 'method'=>'POST']) !!}

                <h2>Seller: {{App\SuitEvent\Models\User::getName($user->id)}}</h2>

                <div class="form-group">
                    {!! Form::label('premium_expired_date', 'Expired Date') !!}
                    {!! Form::text('premium_expired_date', null, ['class'=>'form-control', 'id'=>'datepick', 'data-date-format'=>'YYYY-MM-DD hh:mm:ss']) !!}
                    {{$errors->first('premium_expired_date')}}
                </div>

                {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('page_script')
<script>
    $('#datepick').datetimepicker({
        pickTime: true,
        format: "yyyy-mm-dd"
    });
</script>
@stop
