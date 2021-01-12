<?php

namespace Selene\Modules\SitesModule\Models;

use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method select(string $string, string $string1)
 * @property mixed structure
 */
class ContentGroup extends Model
{
    protected $fillable = ['name', 'structure'];

    protected $connection = 'mongodb';

    public function prepareRequest(): array
    {
        request()->merge(['structure' => json_decode(request()->structure)]);

        return request()->all();
    }
}
