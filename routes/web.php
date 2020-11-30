<?php

use App\Engines\Engine;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Support\Facades\Route;
use App\Engines\General\Google;
use Goutte\Client;
use Illuminate\Support\Str;
use Symfony\Component\HttpClient\HttpClient;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $classes = ClassFinder::getClassesInNamespace('App\Engines\General');
    $engines_languages = array();

    foreach (glob(app_path()."/Engines/*", GLOB_ONLYDIR) as $folders) {
        foreach (glob($folders."/*.php") as $file) {
            $engines[basename($file, ".php")] = $file;
        }
    }

    foreach ($engines as $item) {
        include_once($item);
        foreach ($classes as $class) {
            if(Str::contains($class, basename($item, '.php'))) {
                $name = $class;
            }
        }
        if (class_exists($name))
        {
            $obj = new $name;
            $engines_languages[$obj->name] = $obj->fetchSupportedLanguages();
        }
    }

    Storage::disk('data')->put('engines_languages.json', json_encode($engines_languages, JSON_UNESCAPED_UNICODE));
});
Route::get('/loc', function () {
    dd(\Location::getByNativeName('Afrikaans'));
});
