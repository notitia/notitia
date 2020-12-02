<?php

namespace App\Engines;

use Faker;
use GuzzleHttp\Client;
use simplehtmldom\HtmlDocument;
use GuzzleHttp\Psr7\Request;

abstract class Engine
{
    public static function file_get_html(string $url) {
        try {
            $client = new Client();
            $response = $client->request('GET', $url, [
                'http_errors' => false,
                'headers' => [
                    'User-Agent' => Faker\Factory::create()->useragent,
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            return false;
        }

        $dom = new HtmlDocument();
        return $dom->load($response->getBody());
    }

    public static function file_get_json(string $url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, Faker\Factory::create()->useragent);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        } else {
            return ($result);
        }
        curl_close($ch);
    }
}
