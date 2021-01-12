<?php

namespace Selene\Modules\SitesModule\SimpleTypes;

use Selene\Modules\SitesModule\Contracts\SimpleTypes\SimpleType;
use Throwable;

/**
 * Class Text
 * @package Selene\Modules\SitesModule\SimpleTypes
 */
class Text implements SimpleType
{

    private const blade = 'SitesModule::simple-types.partials.Text';
    /**
     * @var array
     */
    private $data;

    /**
     * Text constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return array|string
     * @throws Throwable
     */
    public function getHtml()
    {
        return view(self::blade, $this->data)->render();
    }

    /**
     * @param string $name
     * @param null $value
     *
     * @return array
     */
    public static function handle(string $name, $value = null): array
    {
        return [$name => $value];
    }
}
