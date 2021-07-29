<?php

namespace Selene\Modules\SitesModule\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method where(string $string, $null)
 * @method static get(array $properties)
 * @property mixed structure
 * @property mixed siteType
 * @property mixed content
 * @property mixed active
 */
class Site extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'blade',
        'slug',
        'site_type_id',
        'structure',
        'content',
        'active',
        'parent_id',
        'language_short_name',
    ];

    /**
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * @return BelongsTo
     */
    public function siteType()
    {
        return $this->belongsTo('Selene\Modules\SitesModule\Models\SiteType');
    }

    /**
     * @return Collection
     */
    public function getStructureAttribute()
    {
        if ($this->attributes['structure'] !== null) {
            return collect($this->attributes['structure']);
        }

        return collect($this->siteType->structure);
    }

    /**
     * @return bool
     */
    public function hasContentGroups(): bool
    {
        return $this->structure->has('ContentGroup');
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasContentGroup(string $name): bool
    {
        return Arr::has($this->structure, 'ContentGroup.' . $name);
    }

    /**
     * @return mixed
     */
    public function getContentGroups()
    {
        return $this->structure->get('ContentGroup');
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getContentGroup(string $name)
    {
        return Arr::get($this->structure, 'ContentGroup.' . $name);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getContent(string $name)
    {
        return Arr::get($this->content, $name);
    }

    public function hasContent(string $key): bool
    {
        return Arr::has($this->content, $key);
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return bool
     */
    public function updateContent(string $key, $value)
    {
        $content = $this->content;
        Arr::set($content, $key, $value);

        return $this->update(['content' => $content]);
    }

    public function deleteContent(string $key)
    {
        $content = $this->content;
        Arr::forget($content, $key);

        return $this->update(['content' => $content]);
    }

}
