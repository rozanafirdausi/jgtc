@extends('frontend.layout.base')

@section('content')
        <p>
        @if ($errors->count() > 0)
            <div class="flash-msg flash-msg--warn" style="color: red;">
                Your data is invalid, please try again!
            </div>
        @endif
        @if ($errorMessage = Session::get('message_error'))
            <div class="flash-msg flash-msg--warn" style="color: red;">
                {!! $errorMessage !!}
            </div>
        @endif
        </p>
        {!!Form::open(['method' => 'post', 'route' => 'sessions.store', 'class' => 'text-left'])!!}
            <div class="inputs-w3ls">
                <i class="fa fa-user" aria-hidden="true"></i>
                {!!Form::text('email', null, ['class'=>'form-input form-input--block ', 'required' => 'true', 'id' => 'email', 'placeholder' => 'Masukkan email'])!!}
                <div><small style="color: red;">{{$errors->first('email')}}</small></div>
            </div>
            <div class="inputs-w3ls">
                    <i class="fa fa-key" aria-hidden="true"></i>
                    {!! Form::password('password', ['class'=>'form-input form-input--block', 'id' => 'password', 'required' => 'true', 'placeholder' => 'Masukkan password'])!!}
                    <div><small style="color: red;">{{$errors->first('password')}}</small></div>
            </div>
            <input type="submit" value="LOGIN">
            {!! Form::close() !!}
@stop