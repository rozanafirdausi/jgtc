@extends('backend.admin.layouts.base')

@section('content')
    <nav>
        <h2 class="sr-only">You are here:</h2>
        <ul class="breadcrumb">
            <li><a href="#">Site Management</a></li>
            <li><a href="{{ route('backend.contenttype.index') }}">Content Type</a></li>
            <li>List</li>
        </ul>
    </nav>

    <div class="tabby-triggers">
        <a class="tabby-trigger active" href="{{ route('backend.contenttype.index') }}">Content Type</a>
        <a class="tabby-trigger" href="{{ route('backend.contentcategory.index') }}">Content Category</a>
    </div>
    <br>
    
    <h1 class="heading">Content Type List</h1>
    <hr />

    <div class="block text-right">
      {!! App\SuitEvent\SuitMenu::navMenu(route("backend.contenttype.create"), 'Create New', 'fa-plus') !!}
    </div>

    <table id="contentType" class="table table--zebra" data-enhance-ajax-table="{{ route('backend.contenttype.index.json') . "?_token=" . csrf_token() }}">
      <thead>
          <tr>
            @foreach($contentType->getBufferedAttributeSettings() as $key=>$val)
              @if( $val['visible'] )
                <td><b>{{ $val['label'] }}</b></td>
              @endif
            @endforeach
            <td><b>Menu</b></td>
          </tr>
      </thead>
    </table>
@stop

@section('page_script')
  <script>
  </script>
@stop