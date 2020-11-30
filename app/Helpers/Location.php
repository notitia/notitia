<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class Location {
    public function all() {
        return json_decode(Storage::disk('local')->get('countries.json'));
    }

    public function getByName(string $name) {
        $countries = json_decode(Storage::disk('local')->get('countries.json'));
        foreach ($countries as $country) {
            if($name === $country->name) {
                return $country;
            }
        }
    }

    public function getByNativeName(string $nativeName) {
        $countries = json_decode(Storage::disk('local')->get('countries.json'));
        foreach ($countries as $country) {
            if($nativeName === $country->nativeName) {
                return $country;
            }
        }
    }

    public function getByShortCode(string $shortCode) {
        $countries = json_decode(Storage::disk('local')->get('countries.json'));
        foreach ($countries as $country) {
            if($shortCode === $country->alpha2Code || $shortCode === $country->alpha3Code) {
                return $country;
            }
        }
    }

    public function getByShortCurrency(string $currency) {
        $countries = json_decode(Storage::disk('local')->get('countries.json'));
        $response = array();

        foreach ($countries as $country) {
            foreach($country->currencies as $currencies) {
                if($currency === $currencies->code) {
                    array_push($response, (array)$country);
                }
            }
        }
        return $response;
    }

    public function getByShortLanguages(string $language) {
        $countries = json_decode(Storage::disk('local')->get('countries.json'));
        $response = array();

        foreach ($countries as $country) {
            foreach($country->languages as $languages) {
                if($language === $languages->iso639_1) {
                    array_push($response, (array)$country);
                }
            }
        }
        return $response;
    }

    public function getByCapital(string $capital) {
        $countries = json_decode(Storage::disk('local')->get('countries.json'));
        foreach ($countries as $country) {
            if($capital === $country->capital) {
                return $country;
            }
        }
    }

    public function getByCallingCode(string $callingCode) {
        $countries = json_decode(Storage::disk('local')->get('countries.json'));
        foreach ($countries as $country) {
            foreach ($country->callingCodes as $callcodes) {
                if($callcodes === $callingCode) {
                    return $country;
                }
            }
        }
    }

    public function getByRegion(string $region) {
        $countries = json_decode(Storage::disk('local')->get('countries.json'));
        $response = array();

        foreach ($countries as $country) {
            if ($country->region === $region) {
                array_push($response, (array)$country);
            }
        }
        return $response;
    }
}
