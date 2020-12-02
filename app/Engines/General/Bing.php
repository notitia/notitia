<?php

namespace App\Engines\General;

use App\Engines\Engine;

class Bing extends Engine
{
    public $name = "bing";
    #TODO: Make aliases for some languages.
    private $category = "general";
    private $paging = true;
    private $language_support = true;

    public static function fetchSupportedLanguages()
    {
        $crawler = Engine::file_get_html('https://www.bing.com/account/general');

        if ($crawler) {
            $scrapped = $crawler->find('li > a[href*=setmkt]');
            $languages = array();

            foreach ($scrapped as $language) {
                preg_match_all('@<a href=".*?" h=".*?">([^<]+)</a>@i', $language->outertext, $out);
                parse_str(parse_url($language->href)['query'], $query);

                $long_name = $out[1][0];
                $code_name = $query["setmkt"];

                $languages[$code_name] = $long_name;
            }

            return array_keys($languages);
        }
    }
}
