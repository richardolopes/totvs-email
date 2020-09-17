<?php

namespace Totvs;

class Util
{
    public static function maiorData($range)
    {
        $aux = '';

        for ($i = 0; $i < count($range); $i++) {
            if ($range[$i]->value > $aux) {
                $aux = $range[$i]->value;
            }
        }

        return $aux;
    }

    public static function stringParaData($string)
    {
        return substr($string, 6, 8) . '/' . substr($string, 4, 2) . '/' . substr($string, 0, 4);
    }

}
