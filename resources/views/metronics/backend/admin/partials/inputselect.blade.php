<!-- (2) Dropdown List Options -->
<div class="form-group form-md-line-input {{ $formSetting['errors'] ? 'has-error' : '' }}" id="{{ $formSetting['container_id'] }}">
    <label class="col-md-2 control-label" for="{{ $formSetting['id'] }}">{{ $formSetting['label'] }}</label>
    <div class="col-md-10">
        <select name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" class='form-control select2'
            @if(isset($formSetting['data_url']) && !empty($formSetting['data_url']))
                metronics-select-autocomplete="{{ $formSetting['data_url'] }}"
                metronics-select-autocomplete-init-value="{{ $formSetting['value'] }}"
                metronics-select-autocomplete-init-text="{{ isset($formSetting['value_text']) ?  $formSetting['value_text'] : 'Unknown ' . ucfirst(strtolower($formSetting['label'])) }}"
                metronics-select-autocomplete-empty-text="-- select {{ strtolower($formSetting['label']) }} --"
            @endif
                id='{{ $formSetting['id'] }}' {{ $formSetting['required'] ? 'required' : '' }} {{ $formSetting['readonly'] ? 'readonly' : '' }}>
            <option value=''>-- select {{ strtolower($formSetting['label']) }} --</option>
        @if(isset($formSetting['data_url']) && !empty($formSetting['data_url']))
            <option value='{{ $formSetting['value'] }}' selected>{{ isset($formSetting['value_text']) ?  $formSetting['value_text'] : 'Unknown ' . ucfirst(strtolower($formSetting['label'])) }}</option>
        @endif
            @foreach($formSetting['options'] as $key=>$value)
            <option value='{{ $key }}' {{ $key == $formSetting['value'] ? "selected" : "" }}>{{ $value }}</option>
            @endforeach
        </select>
        @if($formSetting['errors'])
        <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
        @endif
    </div>
</div>