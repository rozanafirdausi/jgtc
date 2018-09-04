<div class="form-body">
    <!-- Default Entry Form -->
    @foreach($baseObject->getBufferedAttributeSettings() as $key=>$val)
        @if( $val['formdisplay'] )
            {!! $baseObject->renderFormView($key, null, $errors, null, [
                'user_id' => route("backend.user.options.json")
            ]) !!}
        @endif
    @endforeach
</div>
