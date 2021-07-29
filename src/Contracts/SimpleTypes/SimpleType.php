<?php

namespace Selene\Modules\SitesModule\Contracts\SimpleTypes;

/**
 * Interface SimpleType
 * @package Selene\Modules\SitesModule\Contracts\SimpleTypes
 */
interface SimpleType
{
    /**
     * SimpleType constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = []);

    /**
     * @return mixed
     */
    public function getHtml();

    /**
     * @param string $name
     * @param null $value
     *
     * @return array
     */
    public static function handle(string $name, $value = null): array;
}
