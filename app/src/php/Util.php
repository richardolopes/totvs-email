<?php

namespace Totvs;

class Util
{
    public static function recentDate(array $range): string
    {
        $aux = '';

        for ($i = 0; $i < count($range); $i++) {
            if ($range[$i]->value > $aux) {
                $aux = $range[$i]->value;
            }
        }

        return $aux;
    }

    public static function stringToDayMonthYear(string $string): string
    {
        return substr($string, 6, 8) . '/' . substr($string, 4, 2) . '/' . substr($string, 0, 4);
    }

}
