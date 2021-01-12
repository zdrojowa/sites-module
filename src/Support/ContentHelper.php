<?php

namespace Selene\Modules\SitesModule\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Selene\Modules\SitesModule\StructureManager\StructureManager;

/**
 * Class ContentHelper
 * @package Selene\Modules\SitesModule\Support
 */
class ContentHelper
{
    /**
     * @param array $items
     *
     * @param string $start
     *
     * @return string
     */
    public static function dotNotation(array $items, string $start = '')
    {
        if($start !== '') {
            if($start[strlen($start) - 1] !== '.') {
                $start .= '.';
            }
        }

        $string = $start;

        foreach ($items as $item) {
            if (!is_string($item)) continue;

            $string .= $item;

            if (next($items)) $string .= '.';
        }

        return $string;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public static function makeGroupItemContent(Request $request)
    {
        $groupItemContent = StructureManager::prepareContent($request);
        $groupItemContent['_name'] = $request->input('_name');
        $groupItemContent['_order'] = $request->input('_order');
        $groupItemContent['_active'] = $request->input('_active');

        return $groupItemContent;
    }

    public static function sortGroupItems(array $items) {
        return Arr::sort($items, function($value) {
            return $value['_order'];
        });
    }

}
