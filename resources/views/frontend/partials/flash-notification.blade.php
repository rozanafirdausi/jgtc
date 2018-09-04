<?php
    $tag = null;
    $message = null;
    if (Session::has('notif_success')) {
        $message = Session::get('notif_success');
        $tag = 'success';
    } elseif (Session::has('notif_warning')) {
        $message = Session::get('notif_warning');
        $tag = 'warning';
    } elseif (Session::has('notif_error')) {
        $message = Session::get('notif_error');
        $tag = 'error';
    }
?>

@if ($tag && $message)
<div class="flash-message {{ $tag }}">
    <div class="flash-message-container">
        <a href="" class="flash-message-close">
            <span class="fa fa-close fa-fw"></span>
        </a>
        <span class="flash-message-text">{{ $message }}</span>
    </div>
</div>
@endif
