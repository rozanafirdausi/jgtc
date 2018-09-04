<?php

namespace App\SuitEvent;

class SuitMenu
{
    public static function navLink($routes, $text)
    {
        $link = explode('/', Request::path());

        foreach ($routes as $route) {
            if ($link[1] == $route) {
                $active = "class = 'active'";
                break;
            } else {
                $active = '';
            }
        }

        return '<li ' . $active . '>
        <a href="' . url('admin/' . $route . '') . '"><i class="fa fa-folder"></i><span>' . $text . '</span></a></li>';
    }

    public static function navMenu($url, $text, $iconString = null, $class = "btn btn--blue", $title = '')
    {
        return '<a class="' . $class . '" href="' . $url . '" title="' . $title . '">' . ($iconString != null ?
        '<span class="fa fa-fw ' . $iconString . '"></span>' : '') . ' ' . $text . '</a>';
    }

    public static function postNavMenu($url, $text, $token, $confirmText = null, $iconString =
    null, $class = "btn btn--red", $title = '')
    {
        return '<form style="display:inline;" method="post" action="' . $url . '">
        <input type="hidden" name="_token" value="' . $token . '">
        <button type="submit" title="' . $title . '" class="' . $class . '" ' . (!empty($confirmText) ?
        'onClick="return confirm(\'' . $confirmText . '\');"' : '') . '>' . ($iconString != null ?
        '<span class="fa fa-fw ' . $iconString . '">
        </span>' : '') . ' ' . $text . '</button></form>';
    }

    /* Menu items macro in frontend */
    public static function menuItemsByType($type)
    {
        $result = "";

        foreach (MenuItem::getActiveMenus($type) as $menu) {
            $result . "<li><a href='" . url($menu->url) . "'>" . $menu->title . "</a></li>";
        }

        return $result;
    }
}
