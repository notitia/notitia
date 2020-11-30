<?php
namespace App\Engines\General;

use App\Engines\Engine;

class Qwant extends Engine
{
    public $name = "qwant";
    private $category = "general";
    private $paging = true;
    private $language_support = true;

    public static function fetchSupportedLanguages() {
        $crawler = Engine::file_get_html('https://qwant.com/region');
        $scrapped = $crawler->find('script',0)->innertext;
        $scrapped = strstr(substr($scrapped, strpos($scrapped, "config_set('project.regionalisation',") + 1), 'config_set', true);
        $scrapped = json_decode('{'.strstr(substr($scrapped, strpos($scrapped, "{") + 1), ');', true));
        $languages = array();

        foreach($scrapped->languages as $language) {
            foreach ($language->countries as $country) {
                $code_name = $language->code."-".$country;
                $long_name = $language->name;

                $languages[$code_name] = $long_name;
            }
        }
        return $languages;
    }
}
