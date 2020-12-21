<?php

namespace Totvs\Controller;

use Exception;
use Totvs\Exceptions\ExceptionsPR;

class Http
{
    const URL = "http://10.171.78.41:8006/";

    public static function get($url) {
        return self::http(self::URL . $url, 'GET');
    }

    public static function post($url) {
        return self::http(self::URL . $url, 'POST');
    }

    private static function http(string $url, string $type, int $x = 0)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);

        switch ($type) {
            case 'GET':
                curl_setopt($ch, CURLOPT_HTTPGET, true);
            break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                    'user' => '',
                ));
            break;
        }

        $response = json_decode(curl_exec($ch));
        $x++;

        if (isset($response->message)) {
            throw new \Exception($response->message);
        }

        if (curl_errno($ch)) {
            $err = curl_errno($ch);

            echo "<br>";
            echo "CURL NUMBER ERROR: $err";

			if ($x <= 3) {
				echo "<br>";
				echo "TimeOut atingido ($x). Executando novamente. <br>";
				echo "URL: $url <br>";
				echo "TIPO: $type <br>";
				echo "<br>";
				return self::http($url, $type, $x);
			} else {
				throw new ExceptionsPR();
			}
        }

        curl_close($ch);
        return $response;
    }
}