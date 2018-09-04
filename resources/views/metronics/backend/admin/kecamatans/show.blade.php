@extends ('backend.admin.layouts.base')

@section('content')

    <nav>
        <h2 class="sr-only">You are here:</h2>
        <ul class="breadcrumb">
            <li><a>Master Data Management</a></li>
            <li><a href="{{ route($routeBaseName . '.index') }}">{{ $baseObject->getLabel() }}</a></li>
            <li>Detail</li>
        </ul>
    </nav>

    <h1 class="heading">Detail of "{{ $baseObject->getFormattedValue() }}"</h1>
    <hr />

    <div class="block text-right">
        @if( Route::has($routeBaseName . '.show') )
            {!! App\SuitEvent\SuitMenu::navMenu(route($routeBaseName . ".edit", ['id'=>$baseObject->id]), 'Update', 'fa-pencil') !!}
        @endif
        @if( Route::has($routeBaseName . '.destroy') )
            {!! App\SuitEvent\SuitMenu::postNavMenu(route($routeBaseName . '.destroy', ['id' => $baseObject->id]), 'Delete', csrf_token(), 'Are you sure?', 'fa-remove') !!}
        @endif
    </div>

    <div class="bzg">
        <div class="bzg_c" data-col="l12">
            <table id="{{ class_basename($baseObject) }}_detail" class="table table--zebra">
                <tbody>
                @foreach($baseObject->getBufferedAttributeSettings() as $key=>$val)
                    @if($key != 'password')
                    <tr>
                        <td><b>{{ $val['label'] }}</b></td>
                        <td>{{ $baseObject->renderAttribute($key) }}</td>
                    </tr>
                    @endif
                @endforeach
              </tbody>
            </table>
        </div>
    </div>

@stop
