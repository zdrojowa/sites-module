<?php

namespace Selene\Modules\SitesModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Selene\Modules\SitesModule\Support\Enums\SiteStatus;

class SiteStoreFirstStepRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:250|unique:mongodb.sites,name',
            'blade' => 'required|string',
            'slug' => 'required|string|unique:mongodb.sites,slug',
            'status' => [
                'required',
                Rule::in(SiteStatus::toArray()),
            ],
            'structure' => 'nullable|json',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'To pole jest wymagane.',
            'name.string' => 'Nazwa jest nieprawidłowa.',
            'name.max' => 'Nazwa może mieć maksymalnie 250 znaków.',
            'name.unique' => 'Nazwa musi być unikalna.',
            'blade.required' => 'To pole jest wymagane.',
            'blade.string' => 'Szablon jest wymagany.',
            'slug.required' => 'To pole jest wymagane.',
            'slug.string' => 'Link jest nieprawidłowy.',
            'slug.unique' => 'Link musi być unikalny.',
            'status.required' => 'Status jest wymagany.',
            'status.in' => 'Wybrany status nie istnieje.',
            'site_type_id.exists' => 'Wybrany rodzaj strony nie istnieje.',
            'structure' => 'Wystąpił błąd skontaktuj się z programistami.',

        ];
    }
}
