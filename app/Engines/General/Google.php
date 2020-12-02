<?php
namespace App\Engines\General;

use App\Engines\Engine;

class Google extends Engine
{
    public $name = "google";
    private $category = "general";
    private $paging = true;
    private $language_support = true;
    static private $aliases = [
        'ja' => 'jp'
    ];

    static private $google_domains = [
    'BG' => 'google.bg',      # Bulgaria
    'CZ' => 'google.cz',      # Czech Republic
    'DE' => 'google.de',      # Germany
    'DK' => 'google.dk',      # Denmark
    'AT' => 'google.at',      # Austria
    'CH' => 'google.ch',      # Switzerland
    'GR' => 'google.gr',      # Greece
    'AU' => 'google.com.au',  # Australia
    'CA' => 'google.ca',      # Canada
    'GB' => 'google.co.uk',   # United Kingdom
    'ID' => 'google.co.id',   # Indonesia
    'IE' => 'google.ie',      # Ireland
    'IN' => 'google.co.in',   # India
    'MY' => 'google.com.my',  # Malaysia
    'NZ' => 'google.co.nz',   # New Zealand
    'PH' => 'google.com.ph',  # Philippines
    'SG' => 'google.com.sg',  # Singapore
    # 'US': 'google.us',    # United States, redirect to .com
    'ZA' => 'google.co.za',   # South Africa
    'AR' => 'google.com.ar',  # Argentina
    'CL' => 'google.cl',      # Chile
    'ES' => 'google.es',      # Spain
    'MX' => 'google.com.mx',  # Mexico
    'EE' => 'google.ee',      # Estonia
    'FI' => 'google.fi',      # Finland
    'BE' => 'google.be',      # Belgium
    'FR' => 'google.fr',      # France
    'IL' => 'google.co.il',   # Israel
    'HR' => 'google.hr',      # Croatia
    'HU' => 'google.hu',      # Hungary
    'IT' => 'google.it',      # Italy
    'JP' => 'google.co.jp',   # Japan
    'KR' => 'google.co.kr',   # South Korea
    'LT' => 'google.lt',      # Lithuania
    'LV' => 'google.lv',      # Latvia
    'NO' => 'google.no',      # Norway
    'NL' => 'google.nl',      # Netherlands
    'PL' => 'google.pl',      # Poland
    'BR' => 'google.com.br',  # Brazil
    'PT' => 'google.pt',      # Portugal
    'RO' => 'google.ro',      # Romania
    'RU' => 'google.ru',      # Russia
    'SK' => 'google.sk',      # Slovakia
    'SI' => 'google.si',      # Slovenia
    'SE' => 'google.se',      # Sweden
    'TH' => 'google.co.th',   # Thailand
    'TR' => 'google.com.tr',  # Turkey
    'UA' => 'google.com.ua',  # Ukraine
    # 'CN': 'google.cn',    # China, only from China ?
    'HK' => 'google.com.hk',  # Hong Kong
    'TW' => 'google.com.tw'   # Taiwan
    ];

    public static function getGoogleDomains() {
        return self::$google_domains;
    }

    public static function fetchSupportedLanguages() {
        $crawler = Engine::file_get_html('https://www.google.com/preferences#languages');
        $scrapped = $crawler->find('*[id="langSec"]', 0)->find('input[name=lr]');
        $languages = array();

        if ($scrapped) {
            foreach ($scrapped as $language) {
                $code_name = explode('_', $language->attr['value'])[1];
                $long_name = $language->attr['data-name'];

                foreach (self::$aliases as $key => $alias) {
                    if($code_name === $key) {
                        $code_name = $alias;
                    }
                }

                array_push($languages, $code_name);
                //$languages[$code_name] = $long_name;
            }
        }

        return $languages;
    }
}
