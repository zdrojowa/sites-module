<?php

namespace Selene\Modules\SitesModule;

use Selene\Modules\Module;
use Selene\Modules\SitesModule\Models\Site;
use Selene\Modules\SitesModule\SimpleTypes\Image;
use Selene\Modules\SitesModule\SimpleTypes\Text;
use Selene\Modules\SitesModule\SimpleTypes\Textarea;

/**
 * Class SitesModule
 * @package Selene\Modules\SitesModule
 */
class SitesModule extends Module
{
    private const SIMPLE_TYPES = [
        'Text' => Text::class,
        'Image' => Image::class,
        'Textarea' => Textarea::class,
    ];

    /**
     * @return array
     */
    public static function getSimpleTypes(): array
    {
        return self::SIMPLE_TYPES;
    }

    public function menuItems()
    {
        $sitesData = Site::get(['slug', 'name']);

        return [
            [
                "type" => "Select",
                "name" => "Strona",
                "data" => $sitesData,
                "optionValue" => "slug",
                "optionName" => "name"
            ],
        ];
    }
}
