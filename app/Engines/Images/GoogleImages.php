<?php
namespace App\Engines\Images;

use App\Engines\Engine;
use App\Engines\General\Google;

class GoogleImages extends Engine
{
    public $name = "google-images";
    private $category = "images";
    private $paging = true;
    private $language_support = true;

    public function _construct() {
        $this->google_domains = Google::getGoogleDomains();
    }

    public static function fetchSupportedLanguages() {
        return Google::fetchSupportedLanguages();
    }
}
