<div class="form-body">
    <!-- Default Entry Form -->
    @foreach($baseObject->getBufferedAttributeSettings() as $key=>$val)
        @if( $val['formdisplay'] )
            {!! $baseObject->renderFormView($key, route('admin.uploadfile').'?_token='.csrf_token(), $errors) !!}
        @endif
    @endforeach
</div>
