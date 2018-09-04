<!-- (14) Table Menu -->
<div style="display: table-cell;">
    @if(isset($menuSetting['url_detail']) && !empty($menuSetting['url_detail']))
        <a href="{{ $menuSetting['url_detail'] }}" class="btn btn-xs yellow"><i class="icon-info"></i>&nbsp;View&nbsp;</a>
    @endif
</div>
<div style="display: table-cell;">
    @if(isset($menuSetting['url_edit']) && !empty($menuSetting['url_edit']))
        <a href="{{ $menuSetting['url_edit'] }}" class="btn btn-xs green"><i class="icon-pencil"></i>&nbsp;Edit&nbsp;</a>
    @endif
</div>
<div style="display: table-cell;">
    @if(isset($menuSetting['url_delete']) && !empty($menuSetting['url_delete']) &&isset($menuSetting['session_token']) && !empty($menuSetting['session_token']))
        <form method='post' action="{{ $menuSetting['url_delete'] }}">
            <input type='hidden' name='_token' value="{{ $menuSetting['session_token'] }}" />
            <a onClick='return (confirm("Are you sure?") ? $(this).closest("form").submit() : false);' class="btn btn-xs red"><i class="icon-trash"></i>&nbsp;Delete&nbsp;</a>
        </form>
    @endif
</div>