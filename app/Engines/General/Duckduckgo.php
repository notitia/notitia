<?php
namespace App\Engines\General;

use App\Engines\Engine;
use Illuminate\Support\Str;

class Duckduckgo extends Engine
{
    public $name = "duckduckgo";
    #TODO: Make aliases for some languages.
    private $category = "general";
    private $paging = false;
    private $language_support = true;

    public static function fetchSupportedLanguages() {
        $crawler = Engine::file_get_json('https://duckduckgo.com/util/u172.js');
        $scrapped = substr($crawler, strpos($crawler, "regions:{") + 8);
        $countries = explode(',', ltrim(strstr($scrapped, '}', true), '{'));
        $languages = array();

        foreach($countries as $country) {
            $country = str_replace('"', '', explode(':', $country));
            $code_name = Str::after($country[0], '-').'-'.Str::before($country[0], '-');
            $long_name = $country[1];

            $languages[$code_name] = $long_name;
        }

        return array_keys($languages);
    }
}
