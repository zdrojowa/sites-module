<?php

namespace Selene\Modules\SitesModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core;

/**
 * @property mixed contentGroup
 */
class ContentTypeGroupUpdateRequest extends ContentTypeRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:250|unique:mongodb.content_groups,' . $this->contentGroup->_id,
            'structure' => 'required|json',
        ];
    }

}
