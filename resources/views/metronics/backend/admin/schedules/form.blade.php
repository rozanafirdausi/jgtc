<div class="form-body">
    <!-- Default Entry Form -->
    @foreach($baseObject->getBufferedAttributeSettings() as $key=>$val)
        @if( $val['formdisplay'] )
            {!! $baseObject->renderFormView($key, null, $errors, null, [
                'stage_id' => route("backend.stage.options.json")
            ]) !!}
        @endif
    @endforeach
</div>
