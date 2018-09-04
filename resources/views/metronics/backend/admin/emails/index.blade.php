@extends('backend.admin.layouts.base')

@section('content')
    @include('layouts.emails_nav')
    <br>
    <div style="padding: 8px; background-color: white; border: solid 1px #cccccc;">
        <a>[Click On Subject]</a> <i>Preview Newsletter</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class='btn btn-info btn-sm'><span class='glyphicon glyphicon-check'></span></a> <i>Execute Newsletter</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-pencil'></span></a> <i>Update Newsletter</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></a> <i>Delete Newsletter</i>
    </div>
    <br>
    <table id="email" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
      <thead>
          <tr>
            <td><b>ID</b></td>
            <td><b>Subject</b></td>
            <td><b>Sender Name</b></td>
            <td><b>Recipient</b></td>
            <td><b>Menu</b></td>
          </tr>
      </thead>
      <tbody>
        @foreach($emails as $email)
          <tr>
            <td><a href="{{route('backend.email.show',['id'=>$email->id])}}">{{$email->id}}</a></td>
            <td><a href="{{route('backend.email.show',['id'=>$email->id])}}">{{$email->email_subject}}</a></td>
            <td>{{$email->email_sender_name}}</td>
            <td>{{ucfirst($email->recipient)}}</td>
            <td>
              <span style="display:inline-block;">
                {!! Form::open(['route' => ['backend.email.execute', $email->id], 'method' => 'post']) !!}
                {!! Form::button('<span class="glyphicon glyphicon-check"></span>', ['type' => 'submit', 'class' => 'btn btn-info btn-sm', 'onclick' => 'return confirm("Are you sure to send this email?")', 'title' => 'Send Email']) !!}
                {!! Form::close() !!}
              </span>
              <a href="{{route('backend.email.edit',['id'=>$email->id])}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil" title="Edit Email"></span></a>
              <span style="display:inline-block;">
                {!! Form::open(['route' => ['backend.email.destroy', $email->id], 'method' => 'delete']) !!}
                {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure to delete this email?")', 'title' => 'Delete Email']) !!}
                {!! Form::close() !!}
              </span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

@stop

@section('page_script')
<script>
  $(document).ready(function() {
    $('#email').dataTable({
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 4 ] }
        ]
    });
  });
</script>
@stop
