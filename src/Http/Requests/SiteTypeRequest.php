<?php

namespace Selene\Modules\SitesModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteTypeRequest extends FormRequest
{

    public function messages()
    {
        return [
            'name.required' => 'To pole jest wymagane.',
            'name.max' => 'Nazwa może mieć maksymalnie 250 znaków.',
            'name.string' => 'Nazwa jest nieprawidłowa.',
            'name.unique' => 'Nazwa musi być unikalna',
            'structure.required' => 'To pole jest wymagane.',
            'structure.json' => 'Wystąpił błąd skryptu skontaktuj się z programistami.',
            'blade.string' => 'Szablon jest nieprawidłowy',
        ];
    }
}
