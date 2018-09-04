@extends('backend.admin.layouts.base')

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a>Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a>My Account</a>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->

<!-- FLASH NOTIFICATION -->
@include('backend.admin.partials.flashnotification')

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title">My Account
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
                    <span class="caption-subject bold uppercase">Account Information</span>
                </div>
                <div class="actions">
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body form">
                {!! Form::open(['route' => 'backend.useraccount.update', 'files'=> true, 'id'=>'form_setting', 'class' => 'form-horizontal']) !!}

                <br/>

                <div class="portlet-title">
                     <div class="caption font-green-sharp">
                        <i class="fa fa-address-book font-green-sharp"></i>&nbsp;
                        <span class="caption-subject bold uppercase">Update Profile</span>
                    </div>
                 </div>

                <div class="portlet-body">
                    <div class="row form-horizontal form-body">
                        <div class="col-md-12">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label">Full Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" id="inputName" type="text" name="name" value="{{ $user->name }}" required>
                                    @if ($errors->has('name'))
                                        <small class="text-red">{{ $errors->first('name') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label">Email</label>
                                <div class="col-md-10">
                                    <input class="form-control" id="inputEmail" type="email" name="email" value="{{ $user->email }}" required>
                                    @if ($errors->has('email'))
                                        <small class="text-red">{{ $errors->first('email') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label">Phone Number</label>
                                <div class="col-md-10">
                                    <input class="form-control" id="inputHP" type="text" name="phone_number" value="{{ $user->phone_number }}" required>
                                    @if ($errors->has('phone_number'))
                                        <small class="text-red">{{ $errors->first('phone_number') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10">
                            <input type="submit" class="btn blue" value="Update"/>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

                <br/>

                {!! Form::open(['route' => 'backend.useraccount.updatepassword', 'files'=> true, 'id'=>'form_setting', 'class' => 'form-horizontal']) !!}

                <br/>

                <div class="portlet-title">
                     <div class="caption font-green-sharp">
                        <i class="fa fa-key font-green-sharp"></i>&nbsp;
                        <span class="caption-subject bold uppercase">Update Password</span>
                    </div>
                 </div>

                <div class="portlet-body">
                    <div class="row form-horizontal form-body">
                        <div class="col-md-12">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label">Current Password</label>
                                <div class="col-md-10">
                                    <input class="form-control" id="inputOldPassword" name="old_password" type="password" required>
                                    @if ($errors->has('old_password'))
                                        <small class="text-red">{{ $errors->first('old_password') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label">Password</label>
                                <div class="col-md-10">
                                    <input class="form-control" id="inputPassword" name="password" type="password" required>
                                    @if ($errors->has('password'))
                                        <small class="text-red">{{ $errors->first('password') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label">Password Confirmation</label>
                                <div class="col-md-10">
                                    <input class="form-control" id="inputPasswordConfirmation" name="password_confirmation" type="password" required>
                                    @if ($errors->has('password_confirmation'))
                                        <small class="text-red">{{ $errors->first('password_confirmation') }}</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-10">
                            <input type="submit" class="btn blue" value="Update"/>
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
