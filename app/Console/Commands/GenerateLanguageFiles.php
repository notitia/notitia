<?php

namespace App\Console\Commands;

use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\ClassLoader\ClassMapGenerator;

class GenerateLanguageFiles extends Command
{
    protected $signature = 'generate:languages';
    protected $description = 'Generate languages and language-engine files.';
    protected $directory = 'app/Engines/';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $classes = ClassFinder::getClassesInNamespace('App\Engines\General');

        foreach (glob(app_path() . "/Engines/*", GLOB_ONLYDIR) as $folders) {
            foreach (glob($folders . "/*.php") as $file) {
                $engines[basename($file, ".php")] = $file;
            }
        }

        foreach ($engines as $item) {
            include_once($item);
            foreach ($classes as $class) {
                if (Str::contains($class, basename($item, '.php'))) {
                    $name = $class;
                }
            }
            if (class_exists($name)) {
                $obj = new $name;
                $engines_languages[$obj->name] = $obj->fetchSupportedLanguages();
            }
        }
        Storage::disk('data')->put('engines_languages.json', json_encode($engines_languages, JSON_UNESCAPED_UNICODE));
        $this->info('Languages-engines file generated!');
    }
}
