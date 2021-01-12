<?php

namespace Selene\Modules\SitesModule\SimpleTypes;

use Selene\Modules\SitesModule\Contracts\SimpleTypes\SimpleType;

/**
 * Class Textarea
 * @package Selene\Modules\SitesModule\SimpleTypes
 */
class Textarea implements SimpleType
{
    /**
     *
     */
    private const blade = 'SitesModule::simple-types.partials.Textarea';
    /**
     * @var array
     */
    private $data;

    /**
     * Textarea constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return array|string
     * @throws \Throwable
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
