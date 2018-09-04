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
                                        Reset Password
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
                                    {!!Form::open(['route' => 'frontend.admin.forgetpassword.post', 'class' => 'text-left'])!!}
                                        <div class="block-half">
                                            <label for="forgetEmail"><small>Email</small></label>
                                            <input class="form-input" id="forgetEmail" type="email" name="email" required="required" placeholder="Masukkan Email">
                                        </div>
                                        <button class="btn btn--block btn--orange block-half">Kirim</button>
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
