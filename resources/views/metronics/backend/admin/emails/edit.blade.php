@extends('backend.admin.layouts.base')

@section('content')
    @section('extra-navigation')
        @include('backend.admin.emails.nav-extra')
    @stop
    @include('layouts.emails_nav')
    <br>
    <div class="row">
        <div class="col-sm-12">
            {!! Form::model($email, ['route'=>['backend.email.update', $email->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="form-group">
                    {!! Form::label('email_subject', 'Subject') !!}
                    {!! Form::text('email_subject', null, array('class'=>'form-control')) !!}
                    {{$errors->first('email_subject')}}
                </div>

                <div class="form-group">
                    {!! Form::label('email_sender_name', 'Sender Name') !!}
                    {!! Form::text('email_sender_name', null, array('class'=>'form-control')) !!}
                    {{$errors->first('email_sender_name')}}
                </div>

                <div class="form-group">
                    {!! Form::label('email_body', 'Email Body') !!}
                    {!! Form::textarea('email_body', null, ['class'=>'form-control']) !!}
                    {{$errors->first('email_body')}}
                </div>

                <div class="form-group">
                    {!! Form::label('banner_top_image', 'Banner Top Image') !!}
                    {!! Form::file('banner_top_image', array('class'=>'form-control')) !!}
                    {{$errors->first('banner_top_image')}}
                </div>

                <div class="form-group">
                    {!! Form::label('banner_top_url', 'Banner Top URL') !!}
                    {!! Form::text('banner_top_url', null, array('class'=>'form-control')) !!}
                    {{$errors->first('banner_top_url')}}
                </div>

                <div class="form-group">
                    {!! Form::label('banner_top_title', 'Banner Top Title') !!}
                    {!! Form::text('banner_top_title', null, array('class'=>'form-control')) !!}
                    {{$errors->first('banner_top_title')}}
                </div>

                <div class="form-group">
                    {!! Form::label('banner_bottom_image', 'Banner Bottom Image') !!}
                    {!! Form::file('banner_bottom_image', array('class'=>'form-control')) !!}
                    {{$errors->first('banner_bottom_image')}}
                </div>

                <div class="form-group">
                    {!! Form::label('banner_bottom_url', 'Banner Bottom URL') !!}
                    {!! Form::text('banner_bottom_url', null, array('class'=>'form-control')) !!}
                    {{$errors->first('banner_bottom_url')}}
                </div>

                <div class="form-group">
                    {!! Form::label('banner_bottom_title', 'Banner Bottom Title') !!}
                    {!! Form::text('banner_bottom_title', null, array('class'=>'form-control')) !!}
                    {{$errors->first('banner_bottom_title')}}
                </div>

                <div class="form-group">
                    {!! Form::label('recipient', 'Recipient') !!}
                    {!! Form::select('recipient', array("all"=>"All","seller"=>"Seller Only","buyer"=>"Buyer Only"), null, ['class'=>'form-control']) !!}
                    {{$errors->first('recipient')}}
                </div>

                <div class="form-group">
                    {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
                    <a class="btn btn-info" onClick="return confirm('Are you sure to discard your changes?');" href="{{ route('backend.email.index') }}">
                        Back
                    </a>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('page_script')
<script>
    tinymce.init({
        selector:'textarea',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
          ],

          // ===========================================
          // PUT PLUGIN'S BUTTON on the toolbar
          // ===========================================

          toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link jbimages",
          file_browser_callback : function elFinderBrowser (field_name, url, type, win) {
              tinymce.activeEditor.windowManager.open({
                file: '{{url('elfinder/tinymce')}}',// use an absolute path!
                title: 'elFinder 2.0',
                width: 900,
                height: 450,
                resizable: 'yes'
              }, {
                setUrl: function (url) {
                  win.document.getElementById(field_name).value = url;
                }
              });
              return false;
            },
          // ===========================================
          // SET RELATIVE_URLS to FALSE (This is required for images to display properly)
          // ===========================================

          relative_urls: false,
    });
</script>
@stop
