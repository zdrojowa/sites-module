<?php

namespace Selene\Modules\SitesModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

/**
 * @property string structure
 * @property string name
 */
class ContentTypeGroupStoreRequest extends ContentTypeRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:250|unique:mongodb.content_groups,name',
            'structure' => 'required|json',
        ];
    }

}
