@extends('backend.admin.layouts.base')

@section('content')
    @include('layouts.premiumusers_nav')
    <br>
    @if(Session::has('alert'))
      <div class="alert alert-success" role="alert">{{Session::get('alert')}}</div>
    @endif
    <table id="table" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
      <thead>
          <tr>
            <td><b>ID</b></td>
            <td><b>User Name</b></td>
            <td><b>Expired Date</b></td>
            <td><b>Menu</b></td>
          </tr>
      </thead>
      <tbody>
        @foreach($premiums as $premium)
          <tr>
            <td>{{$premium->id}}</td>
            <td>{{App\SuitEvent\Models\User::getName($premium->id)}}</td>
            <td>{{date("d F Y G:i:s", strtotime($premium->premium_expired_date))}}</td>
            <td>
              <a href="{{url('admin/premiums/update/'.$premium->id)}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
              <span style="display:inline-block;">
              {!! Form::open(['route' => ['backend.premiumuser.delete', $premium->id], 'method' => 'delete']) !!}
              {!! Form::button('<span class="glyphicon glyphicon-trash"></span>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure to delete premium status?")']) !!}
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
        $('#table').dataTable();
    });
</script>
@stop
