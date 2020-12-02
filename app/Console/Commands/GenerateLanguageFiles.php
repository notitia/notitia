<?php

namespace App\Console\Commands;

use App\Facades\LocationFacade as Location;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateLanguageFiles extends Command
{
    protected $signature = 'generate:languages';
    protected $description = 'Generate languages and language-engine files.';
    protected $directory = 'app/Engines/';
    private $minimum_engine_count = 2;

    public function __construct()
    {
        parent::__construct();
    }

    public function getLanguages(int $minimum_engine_count) {
        $json = json_decode(Storage::disk('data')->get('engines_languages.json'));
        $languages = array();
        $locations = array();

        foreach ($json as $item) {
            foreach ($item as $value) {
                $shortCode = Str::contains($value, '-') ? $shortCode = Str::after($value, '-') : $shortCode = $value;
                    array_push($languages, strtoupper($shortCode));
                }
        }

        foreach (array_unique($languages) as $item) {
            if (Location::getByShortCode(strtoupper($item)) != NULL && count(array_keys($languages, $item)) >= $minimum_engine_count) {
                $location = Location::getByShortCode(strtoupper($item));
                array_push($locations, ["country_code" => $location->alpha2Code, "language_code" => $location->languages[0]->iso639_1, "country_name" => $location->name, "country_native_name" => $location->nativeName, "language_name" => $location->languages[0]->name, "language_native_name" => $location->languages[0]->nativeName]);
            }
        }

        return $locations;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $classes = ClassFinder::getClassesInNamespace('App\Engines', ClassFinder::RECURSIVE_MODE);

        foreach (glob(app_path() . "/Engines/*", GLOB_ONLYDIR) as $folders) {
            foreach (glob($folders . "/*.php") as $file) {
                $engines[basename($file, ".php")] = $file;
            }
        }

        foreach ($engines as $item) {
            include_once($item);
            foreach ($classes as $class) {
                if (Str::endsWith($class, basename($item, '.php'))) {
                    $name = $class;
                }
            }
            if (class_exists($name)) {
                $obj = new $name;
                $engines_languages[$obj->name] = $obj->fetchSupportedLanguages();

                //$this->getLocale($obj->fetchSupportedLanguages());
            }
        }
        Storage::disk('data')->put('engines_languages.json', json_encode($engines_languages, JSON_UNESCAPED_UNICODE));
        $this->info('Languages-engines file generated!');

        Storage::disk('data')->put('languages.json', json_encode(self::getLanguages($this->minimum_engine_count), JSON_UNESCAPED_UNICODE));
        $this->info('Languages file generated!');
    }
}
