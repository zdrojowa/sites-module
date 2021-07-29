<?php

namespace Selene\Modules\SitesModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Selene\Modules\SitesModule\Support\Enums\SiteStatus;

class SiteUpdateFirstStepRequest extends FormRequest
{
    public function rules()
    {
        return [
            'blade' => 'required|string',
            'slug' => 'required|string|unique:mongodb.sites,'.$this->site->slug,
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
            '*.required' => 'To pole jest wymagane.',
            //'blade.required' => 'To pole jest wymagane.',
            //'status.required' => 'Status jest wymagany.',
            //'slug.required' => 'To pole jest wymagane.',
            'blade.string' => 'Szablon jest wymagany.',
            'slug.string' => 'Link jest nieprawidłowy.',
            'slug.unique' => 'Link musi być unikalny.',
            'status.in' => 'Wybrany status nie istnieje.',
            'site_type_id.exists' => 'Wybrany rodzaj strony nie istnieje.',
            'structure' => 'Wystąpił błąd skontaktuj się z programistami.',

        ];
    }
}
