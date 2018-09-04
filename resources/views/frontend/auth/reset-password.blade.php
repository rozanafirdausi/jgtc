@extends('frontend.layout.base')

@push('main-container-class')
site-main-inner-push
@endpush

@section('content')
    <section class="block--2 sign-in">
        <div class="container">

            <div class="user-entry">
                <div class="bzg bzg--no-gutter">
                    <div class="bzg_c" data-col="m6" data-offset="m3">
                        <div class="box text-center">
                            <div class="block">
                                <div class="block__head">
                                    <h3 class="title">
                                        Buat Password Baru
                                    </h3>
                                </div>
                                @if ($errors->count() > 0)
                                    <div class="flash-msg flash-msg--warn">
                                        Data yang Anda masukkan tidak valid, silahkan ulangi kembali!
                                    </div>
                                @endif
                                @if ($errorMessage = Session::get('message_error'))
                                    <div class="flash-msg flash-msg--warn">
                                        {!! $errorMessage !!}
                                    </div>
                                @endif
                                <div class="block__content">
                                    {!!Form::open(['route' => 'frontend.admin.resetpassword.post', 'class' => 'text-left'])!!}
                                    {!! Form::hidden('token', $token)  !!}
                                        <div class="block-half">
                                            <label for="resetEmail"><small>Email</small></label>
                                            <input class="form-input" id="resetEmail" type="email" name="email" required="required" placeholder="Masukkan email">
                                            <div><small>{{$errors->first('email')}}</small></div>
                                        </div>
                                        <div class="block-half">
                                            <label for="resetPassword"><small>Password</small></label>
                                            <input class="form-input" id="resetPassword" type="password" name="password" required="required" placeholder="Masukkan password">
                                            <div><small>{{$errors->first('password')}}</small></div>
                                        </div>
                                        <div class="block-half">
                                            <label for="resetPasswordConfirmation"><small>Password</small></label>
                                            <input class="form-input" id="resetPasswordConfirmation" type="password" name="password_confirmation" required="required" placeholder="Konfirmasi password baru">
                                            <div><small>{{$errors->first('password_confirmation')}}</small></div>
                                        </div>
                                        <button class="btn btn--block btn--orange block-half">Reset Password</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- sing-in -->
@stop

@section('js-script')
@endsection