<!-- (11) File Input -->
<div class="form-group {{ $formSetting['errors'] ? 'has-error' : '' }}" id="{{ $formSetting['container_id'] }}">
    <label class="col-md-2 control-label" for="{{ $formSetting['id'] }}">{{ $formSetting['label'] }}</label>
    <div class="col-md-6">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="input-group input-large">
                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                    <span class="fileinput-filename"></span>
                </div>
                <span class="input-group-addon btn default btn-file">
                    <span class="fileinput-new"> Select file </span>
                    <span class="fileinput-exists"> Change </span>
                    <input id='{{ $formSetting['id'] }}' name="{{ $formSetting['extended_model'] ?  'extended[' . $formSetting['name'] . ']' : $formSetting['name'] }}" type='file' {{ $formSetting['required'] ? 'required' : '' }}><br>
                </span>
            </div>
        </div>

        @if($formSetting['errors'])
            <div class="form-control-focus">{{ $formSetting['errors'] ? $formSetting['errors'] : "" }}</div>
        @endif

    </div>
</div>
<div class="form-group">
    <div class="col-md-2"></div>
    <div class="col-md-10">
        @if(empty($formSetting['value']))
            @if($formSetting['image_file_url'])
                <i>( No Image )</i>
            @else
                <i>( No File )</i>
            @endif
        @else
            @if($formSetting['image_file_url'])
                <figure>
                    <figcaption>
                        Current Image :
                        <a href='{{ $formSetting['value'] }}' target='_BLANK' id='selected{{ $formSetting['id'] }}'>{{ $formSetting['value'] }}</a>
                    </figcaption>
                    <br/>
                    <a href='{{ $formSetting['value'] }}' target='_BLANK'>
                        <img class='thumbnail' src='{{ $formSetting['image_file_url'] }}' style='max-height: 120px; max-width:120px;' alt=''>
                    </a>
                    <input type="checkbox" name="{{ $formSetting['extended_model'] ?  'extended[delete_file__' . $formSetting['name'] . ']' : $formSetting['name'] }}" id="delete_file__{{ $formSetting['name'] }}"> <label for="delete_file__{{ $formSetting['name'] }}">Delete Current File</label>
                </figure>
            @else
                <figure>
                    Current File : <br>
                    <a id='selected{{ $formSetting['id'] }}' href='{{ $formSetting['file_url'] }}' target='_BLANK'>{{ $formSetting['value'] }}</a>
                    <br><br>
                    <input type="checkbox" name="{{ $formSetting['extended_model'] ?  'extended[delete_file__' . $formSetting['name'] . ']' : $formSetting['name'] }}" id="delete_file__{{ $formSetting['name'] }}"> <label for="delete_file__{{ $formSetting['name'] }}">Delete Current File</label>
                </figure>
            @endif
        @endif
    </div>
</div>