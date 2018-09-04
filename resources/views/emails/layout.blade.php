<!DOCTYPE html>
<html>

<head>
    <title>{{$subject or ''}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css" rel="stylesheet" media="all">
        p {
          margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;
        }
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<?php

$style = [
    /* Layout ------------------------------ */

    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #fafafa;',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #fafafa;',

    /* Masthead ----------------------- */

    'email-masthead' => 'padding: 25px 0; text-align: center; background-color:#f3f3f3',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',

    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #f5f5f5; border-bottom: 1px solid #f5f5f5; background-color: #FFF;',
    'email-body_inner' => 'width: auto; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 35px;',

    'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center; background-color:#f3f3f3',
    'email-footer_cell' => 'color: #000000; padding: 35px; text-align: center; background-color:#f3f3f3',

    /* Body ------------------------------ */

    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #f5f5f5;',

    /* Type ------------------------------ */

    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

    'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #e02b22; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #3869D4;',
    'button--black' => 'color: #ffffff; background-color: #1E1E1E;',

    'clear' => 'display:block; clear: both; height: 20px;',
];
?>

<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>

<body style="{{ $style['body'] }}">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="{{ $style['email-wrapper'] }}" align="center">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <!-- Logo -->
                    <tr>
                        <td style="{{ $style['email-masthead'] }}">
                            <a style="{{ $fontFamily }} {{ $style['email-masthead_name'] }}" href="{{ url('/') }}" target="_blank">
                                <img src="{{ isset($previewOnly) ? asset('frontend/assets/img/soundrenaline.gif') : $message->embed(public_path('frontend/assets/img/soundrenaline.gif')) }}" alt="{{ settings('site-name', 'SuitEvent') }}" height="40px" />
                            </a>
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td style="{{ $style['email-body'] }}" width="100%">
                            <table style="{{ $style['email-body_inner'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="{{ $fontFamily }} {{ $style['email-body_cell'] }} {{ $style['paragraph']  }}">
                                        <!-- Greeting -->
                                        <b>
                                        @if (! empty($greeting))
                                            {{ $greeting }}
                                        @endif
                                        </b>

                                        <!-- Intro -->
                                        @if (isset($introLines))
                                            @foreach ($introLines as $line)
                                                <p style="{{ $style['paragraph'] }}">
                                                    {!! htmlspecialchars_decode($line) !!}
                                                </p>
                                            @endforeach
                                        @elseif (isset($before_action_button))
                                            <p style="{{ $style['paragraph'] }}">
                                                {!! htmlspecialchars_decode($before_action_button) !!}
                                            </p>
                                        @endif

                                        @yield('emailcontent')

                                        <!-- Action Button -->
                                        @if (isset($actionText) || isset($action_button_text))
                                        <?php
                                            $buttonText = isset($actionText) ? $actionText : $action_button_text;
                                        ?>
                                            <table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="center">
                                                        <a href="{{ isset($actionUrl) ?  $actionUrl : '' }}"
                                                            style="{{ $fontFamily }} {{ $style['button'] }}"
                                                            class="button"
                                                            target="_blank">
                                                            {{ $buttonText }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif

                                        <!-- Outro -->
                                        @if (isset($outroLines))
                                            @foreach ($outroLines as $line)
                                                <p style="{{ $style['paragraph'] }}">
                                                    {!! htmlspecialchars_decode($line) !!}
                                                </p>
                                            @endforeach
                                        @elseif (isset($after_action_button))
                                            <p style="{{ $style['paragraph'] }}">
                                                {!! htmlspecialchars_decode($after_action_button) !!}
                                            </p>
                                        @endif

                                        <!-- Salutation -->
                                        {{-- <p style="{{ $style['paragraph'] }}">
                                            Regards,<br/>
                                            Soundrenaline 2017
                                        </p> --}}

                                        <!-- Sub Copy -->
                                        @if (isset($actionText) || isset($action_button_text) )
                                            <table style="{{ $style['body_sub'] }}">
                                                <tr>
                                                    <td style="{{ $fontFamily }}">
                                                        <p style="{{ $style['paragraph-sub'] }}">
                                                            If you’re having trouble clicking the "{{ isset($actionText) ? $actionText : $action_button_text }}" button,
                                                            copy and paste the URL below into your web browser:
                                                        </p>

                                                        <p style="{{ $style['paragraph-sub'] }}">
                                                            <a style="{{ $style['anchor'] }}" href="{{ isset($actionUrl) ?  $actionUrl : '' }}" target="_blank">
                                                                {{ isset($actionUrl) ?  $actionUrl : '' }}
                                                            </a>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="{{ $style['email-footer'] }}">
                            <tr>
                                <td style="{{ $fontFamily }} {{ $style['email-footer_cell'] }}">
                                    <p style="margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;">
                                        Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') . ' ' . settings('site-name', 'SuitEvent') }}, All rights reserved.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ isset($previewOnly) ? asset('frontend/assets/img/merokok-warning.png') : $message->embed(public_path('frontend/assets/img/merokok-warning.png')) }}" alt="{{ settings('site-name', 'SuitEvent') }}" />
                                </td>
                            </tr>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
