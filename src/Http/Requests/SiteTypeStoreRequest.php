<?php

namespace Selene\Modules\SitesModule\Http\Requests;

class SiteTypeStoreRequest extends SiteTypeRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:250|unique:mongodb.site_types,name',
            'blade' => 'nullable|string',
            'structure' => 'required|json',
        ];
    }

}
