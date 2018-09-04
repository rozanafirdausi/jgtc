<?php

if (! function_exists('tagStrong')) {
    function tagStrong($text)
    {
        return "<strong style=\"font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0\">{$text}</strong>";
    }
}

if (! function_exists('primaryButton')) {
    function primaryButton($link, $text)
    {
        return "<a href=\"{$link}\" class=\"btn-primary\" style=\"font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;\">{$text}</a>";
    }
}
