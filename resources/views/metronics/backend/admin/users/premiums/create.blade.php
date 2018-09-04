@extends('backend.admin.layouts.base')

@section('content')
    @include('layouts.premiumusers_nav')
    <br>
    <div class="row">
        <div class="col-sm-12">
            {!! Form::open() !!}

                <div class="form-group">
                    {!! Form::label('user_id', 'User Name') !!}
                    {!! Form::select('user_id', $users, null, ['class'=>'form-control']) !!}
                    {{$errors->first('user_id')}}
                </div>

                <div class="form-group">
                    {!! Form::label('premium_expired_date', 'Expired Date') !!}
                    {!! Form::text('premium_expired_date', null, ['class'=>'form-control', 'id'=>'datepick', 'data-date-format'=>'YYYY-MM-DD']) !!}
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
    });
</script>
@stop
