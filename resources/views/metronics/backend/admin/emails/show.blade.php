@extends ('backend.admin.layouts.base')

@section('content')
    @section('extra-navigation')
        @include('backend.admin.emails.nav-extra')
    @stop
    @include('layouts.emails_nav')
    <div class="row">
        <h2><b>{{$email->email_subject}}</b> &nbsp;&nbsp;&nbsp;<a href="{{route('backend.email.destroy',['id'=>$email->id])}}" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a></h2>
    </div>
    <div class="row">
        <table id="article-head" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
          <tbody>
              <tr>
                <td> ID </td>
                <td>{{$email->id}}</td>
              </tr>
              <tr>
                <td> Sender Name </td>
                <td>{{$email->email_sender_name}}</td>
              </tr>
              <tr>
                <td> Recipient </td>
                <td>{{$email->recipient}}</td>
              </tr>
          </tbody>
    </table>
    </div>
    <div class="row">
        <h3>Banner Top</h3>
        <div style="background-color: #fefefe; border: solid 1px #ddd; padding: 16px;">
        	<img src="{{$email->banner_top_image_small_cover}}"><br><br>
        	<ul>
        		<li>Title : {{$email->banner_top_title}}</li>
        		<li>URL : <a href="{{$email->banner_top_url}}">{{ucfirst($email->banner_top_url)}}</a></li>
        	</ul>
        </div>
    </div>
    <div class="row">
        <h3>Message Body</h3>
        <div style="background-color: #fefefe; border: solid 1px #ddd; padding: 16px;">
        	{!! $email->email_body !!}
        </div>
    </div>
    <div class="row">
        <h3>Banner Bottom</h3>
        <div style="background-color: #fefefe; border: solid 1px #ddd; padding: 16px;">
        	<img src="{{$email->banner_bottom_image_small_cover}}"><br><br>
        	<ul>
        		<li>Title : {{$email->banner_bottom_title}}</li>
        		<li>URL : <a href="{{$email->banner_bottom_url}}">{{ucfirst($email->banner_bottom_url)}}</a></li>
        	</ul>
        </div>
    </div>
@stop

