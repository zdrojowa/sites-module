<?php

namespace Selene\Modules\SitesModule\Http\Requests;

/**
 * @property mixed siteType
 */
class SiteTypeUpdateRequest extends SiteTypeRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:250|unique:mongodb.site_types,' . $this->siteType->_id,
            'blade' => 'nullable|string',
            'structure' => 'required|json',
        ];
    }

}
