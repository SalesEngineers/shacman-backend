<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactService
{
    const DEFAULT_CITY = 'Москва';

    private $location = ['name' => null, 'region' => null];

    public function __construct(Request $request)
    {
        $ip = $request->get('ip', $request->ip());
        $geo = \App\SypexGeo\SypexGeoFacade::get($ip);
     
        if (isset($geo['city']['name_ru'])) {
            $this->location['name'] = $geo['city']['name_ru'];
        }

        if (isset($geo['region']['name_ru'])) {
            $this->location['region'] = $geo['region']['name_ru'];
        }
    }

    /**
     * Динамический контакт
     */
    public function getDynamicContact(): ?Contact
    {
        $query = Contact::query();
        
        $query->where(function ($builder) {
            foreach ($this->location as $key => $value) {
                if ($value) {
                    $builder->orWhere($key, 'like', "%{$value}%");
                }
            }

            return $builder;
        })->orWhere('name', '=', self::DEFAULT_CITY);
        
        $contacts = $query->get();
        
        $contact = $contacts->firstWhere('name', '=', $this->location['name']);
        
        if (!$contact) {
            $contact = $contacts->firstWhere('region', '=', $this->location['region']);
        }

        if (!$contact) {
            $contact = $contacts->firstWhere('name', '=', self::DEFAULT_CITY);
        }

        return $contact;
    }
}
