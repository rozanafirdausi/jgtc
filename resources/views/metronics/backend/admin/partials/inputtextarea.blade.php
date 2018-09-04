<!-- (9) Textarea Input -->
<div class="form-group form-md-line-input {{ $formSetting['errors'] ? 'has-error' : '' }}" id="{{ $formSetting['container_id'] }}">
    <label class="col-md-2 control-label" for="{{ $formSetting['id'] }}">{{ $formSetting['label'] }}</label>
    <div class="col-md-10">
        <textarea rows='5' data-autosize class='form-control' id='{{ $formSetting['id'] }}' name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" {{ $formSetting['required'] ? 'required' : '' }} {{ $formSetting['readonly'] ? 'readonly' : '' }} placeholder="type your {{ strtolower($formSetting['label']) }}">{{ $formSetting['value'] }}</textarea>
        @if($formSetting['errors'])
            <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
        @endif
    </div>
</div>
