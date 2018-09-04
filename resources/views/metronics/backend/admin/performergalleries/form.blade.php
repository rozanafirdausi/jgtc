<div class="form-body">
    <!-- Default Entry Form -->
    @foreach($baseObject->getBufferedAttributeSettings() as $key=>$val)
        @if( $val['formdisplay'] )
            {!! $baseObject->renderFormView($key, null, $errors, null, [
                'performer_id' => route("backend.performer.options.json")
            ]) !!}
        @endif
    @endforeach
</div>
