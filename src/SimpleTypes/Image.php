<?php

namespace Selene\Modules\SitesModule\SimpleTypes;

use Illuminate\Support\Facades\Hash;
use Selene\Modules\SitesModule\Contracts\SimpleTypes\SimpleType;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use function MongoDB\is_string_array;

/**
 * Class Image
 * @package Selene\Modules\SitesModule\SimpleTypes
 */
class Image implements SimpleType
{

    private const blade = 'SitesModule::simple-types.partials.Image';
    /**
     * @var array
     */
    private $data;

    /**
     * Image constructor.
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
        if (!$value) return [$name => ''];

        if(is_string($value)) return [$name => $value];

        $filename = md5(uniqid($value->getClientOriginalName(), true));
        $path = $value->move('storage/sites/', $filename.'.'.$value->getClientOriginalExtension())->getPathName();

        return [$name => $path];
    }
}

