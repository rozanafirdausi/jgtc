<!-- (1) Readonly Input Text References -->
<div class="form-group form-md-line-input {{ $formSetting['errors'] ? 'has-error' : '' }}" id="{{ $formSetting['container_id'] }}">
    <label class="col-md-2 control-label" for="{{ $formSetting['id'] }}">{{ $formSetting['label'] }}</label>
    <div class="col-md-10">
        <input class='form-control' id='{{ $formSetting['masked_id'] }}' type='text' value='{{ $formSetting['masked_value'] }}' readonly>
        <input id='{{ $formSetting['id'] }}' type='hidden' name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" value='{{ $formSetting['value'] }}' {{ $formSetting['required'] ? 'required' : '' }}>
        @if($formSetting['errors'])
            <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
        @endif
    </div>
</div>
