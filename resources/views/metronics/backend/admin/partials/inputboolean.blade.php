<!-- (5) Boolean Input -->
<div class="form-group form-md-line-input {{ $formSetting['errors'] ? 'has-error' : '' }}" id='{{ $formSetting['container_id'] }}'>
    <label class="col-md-2 control-label" for="{{ $formSetting['id'] }}">{{ $formSetting['label'] }}</label>
    <div class="col-md-10">
        <div class="md-radio-inline">
            <div class="md-radio">
                <input type="radio" value='1' id="{{ $formSetting['id'] }}_yes" name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" class="md-radiobtn" {{ $formSetting['value'] ? 'checked' : '' }} {{ $formSetting['required'] ? 'required' : '' }} {{ $formSetting['readonly'] ? 'readonly' : '' }}>
                <label for="{{ $formSetting['id'] }}_yes">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span> Yes </label>
            </div>
            <div class="md-radio has-error">
                <input type="radio" value='0' id="{{ $formSetting['id'] }}_no" name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" class="md-radiobtn" {{ !$formSetting['value'] ? 'checked' : '' }} {{ $formSetting['required'] ? 'required' : '' }} {{ $formSetting['readonly'] ? 'readonly' : '' }}>
                <label for="{{ $formSetting['id'] }}_no">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span> No </label>
            </div>
        </div>
        @if($formSetting['errors'])
            <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
        @endif
    </div>
</div>
