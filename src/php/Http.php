<?php

namespace Totvs;

class Http
{
    const MESSAGE = "A conexão com o portal não foi realizada. Verifique a sua conectividade com a VPN ou se o portal está disponível.";

    public static function post(string $url): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'user' => '',
            ],
        ]);
        $response = json_decode(curl_exec($ch));

        if ($errno = curl_errno($ch)) {
            throw new Exception(Http::MESSAGE);
        }

        curl_close($ch);
        return $response;
    }

    public static function get(string $url): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
        ]);

        $response = json_decode(curl_exec($ch));

        if ($errno = curl_errno($ch)) {
            throw new Exception(Http::MESSAGE);
        }

        curl_close($ch);
        return $response;
    }
}
