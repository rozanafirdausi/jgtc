<?php

namespace App\SuitEvent\Repositories;

use App\SuitEvent\Models\DynamicMenu;
use Cache;
use Suitcore\Repositories\SuitRepository;

class MenuRepository extends SuitRepository
{
    public function __construct()
    {
        $this->mainModel = new DynamicMenu;
    }

    public function getActiveMenu($position)
    {
        $status = DynamicMenu::STATUS_ACTIVE;
        return Cache::rememberForever('dynamic_menus_' . $position, function () use ($position, $status) {
            $menus = $this->mainModel->where(compact('position', 'status'))
            ->orderBy('position_order')->orderBy('label')->get()->keyBy('id');
            $sorted = collect($menus)->map(function ($item, $key) use (&$menus) {
                if ($parent = $item['parent_id']) {
                    $menus[$parent]->menus = $item;
                    unset($menus[$key]);
                }
                return $item;
            });
            return $menus;
        });
    }
}
