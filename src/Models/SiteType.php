<?php

namespace Selene\Modules\SitesModule\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static find(array|string|null $input)
 * @method get(array $array)
 */
class SiteType extends Model
{
    protected $fillable = ['name', 'structure'];

    protected $connection = 'mongodb';

    public function prepareRequest(): array
    {
        request()->merge(['structure' => json_decode(request()->structure)]);

        return request()->all();
    }

    public function sites() {
        return $this->hasMany('Selene\Modules\SitesModule\Models\Site');
    }
}
