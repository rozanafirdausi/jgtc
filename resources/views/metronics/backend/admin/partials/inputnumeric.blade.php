<!-- (3) Number Input -->
<div class="form-group form-md-line-input {{ $formSetting['errors'] ? 'has-error' : '' }}" id="{{ $formSetting['container_id'] }}">
    <label class="col-md-2 control-label" for="{{ $formSetting['id'] }}">{{ $formSetting['label'] }}</label>
    <div class="col-md-10">
        @if($formSetting['group'] && isset($formSetting['group']['type']))
        @if($formSetting['group']['type'] == 'icon')
        <div class="input-icon {!! isset($formSetting['group']['icon-position']) ? $formSetting['group']['icon-position'] : '' !!}">
            <input class='form-control' id='{{ $formSetting['id'] }}' type='number' name='{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}' value='{{ $formSetting['value'] }}' {{ $formSetting['required'] ? 'required' : '' }} {{ $formSetting['readonly'] ? 'readonly' : '' }}>
            @if($formSetting['errors'])
            <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
            @endif
            @if(isset($formSetting['group']['icon']))
            <i class="{{ $formSetting['group']['icon'] }}"></i>
            @endif
        </div>
        @elseif($formSetting['group']['type'] == 'addon')
        <div class="input-group">
            @if(isset($formSetting['group']['addon-left']))
            <span class="input-group-addon">{!! $formSetting['group']['addon-left'] !!}</span>
            @endif
            <input class='form-control' id='{{ $formSetting['id'] }}' type='number' name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" value='{{ $formSetting['value'] }}' {{ $formSetting['required'] ? 'required' : '' }} {{ $formSetting['readonly'] ? 'readonly' : '' }}>
            @if($formSetting['errors'])
            <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
            @endif
            @if(isset($formSetting['group']['addon-right']))
            <span class="input-group-addon">{!! $formSetting['group']['addon-right'] !!}</span>
            @endif
        </div>
        @elseif($formSetting['group']['type'] == 'button')
        <div class="input-group">
            @if(isset($formSetting['group']['button-left']))
            <span class="input-group-button btn-left">
                <button class="btn {!! isset($formSetting['group']['button-left-color']) ? $formSetting['group']['button-left-color'] : 'default' !!}" type="{!! $formSetting['group']['button-left-type'] ? $formSetting['group']['button-left-type'] : 'button' !!}">{!! $formSetting['group']['button-left-text'] ? $formSetting['group']['button-left-text'] : '' !!}</button>
            </span>
            @endif
            <input class='form-control' id='{{ $formSetting['id'] }}' type='number' name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" value='{{ $formSetting['value'] }}' {{ $formSetting['required'] ? 'required' : '' }} {{ $formSetting['readonly'] ? 'readonly' : '' }}>
            @if($formSetting['errors'])
            <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
            @endif
            @if(isset($formSetting['group']['button-right']))
            <span class="input-group-button btn-right">
                <button class="btn {!! isset($formSetting['group']['button-right-color']) ? $formSetting['group']['button-right-color'] : 'default' !!}" type="{!! $formSetting['group']['button-right-type'] ? $formSetting['group']['button-right-type'] : 'button' !!}">{!! $formSetting['group']['button-right-text'] ? $formSetting['group']['button-right-text'] : '' !!}</button>
            </span>
            @endif
        </div>
        @endif
        @else
        <input class='form-control' id='{{ $formSetting['id'] }}' type='number' name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" value='{{ $formSetting['value'] }}' {{ $formSetting['required'] ? 'required' : '' }} {{ $formSetting['readonly'] ? 'readonly' : '' }}>
        @if($formSetting['errors'])
        <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
        @endif
        @endif
    </div>
</div>
