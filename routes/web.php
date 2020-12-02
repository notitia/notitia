<?php

use App\Engines\Images\GoogleImages;
use App\Facades\LocationFacade as Location;
use Goutte\Client;
use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Support\Facades\Route;
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
    $json = json_decode(\Illuminate\Support\Facades\Storage::disk('data')->get('languages.json'));

    dd($json);

});
Route::get('/loc', function () {
    dd(\App\Engines\General\Bing::fetchSupportedLanguages());
});
