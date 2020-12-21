<?php

namespace Totvs\Controller;

use Totvs\Util;
use Totvs\Controller\Http;
use Totvs\Exceptions\ExceptionsPR;

class HttpProtheusRobot extends Http
{
    const MESSAGE_VPN = "A conexão com o portal não foi realizada. Verifique a sua conectividade com a VPN ou se o portal está disponível.";
    const MESSAGE_TIMEOUT = "O tempo máximo de execução foi atingido.";

    const RELEASE = 'rest/filtrosportal/releas/homolog';
    const RPOS = 'rest/filtrosportal/identi/homolog/';
    const PAIS = 'rest/filtrosportal/pais/homolog/';
    const DATAS = 'rest/filtrosportal/BRA/execDay/';
    const EXECUCAO = 'rest/acompanhamentoExecucaoD1/';

    public static function getDates(string $release, string $rpo): string
    {
        $response = self::get(self::DATAS . $release . '/' . $rpo . '/Todas');
        return Util::recentDate($response);
    }

    public static function getRpos(string $release)
    {
        $response = self::get(self::RPOS . $release);
        return $response;
    }

    public static function getReleases()
    {
        $response = self::get(self::RELEASE);
        return $response;
    }

    public static function getExecution(string $release, string $data, string $rpo, string $squad)
    {
        $response = self::post(self::EXECUCAO . 'Detail/' . $squad . '/BRA/' . $release . '/' . $data . '/' . $rpo . '/Todas');
        return $response;
    }
    
    public static function getAmountTestCases(string $release, string $data, string $rpo)
    {
        $response = self::post(self::EXECUCAO . 'BRA/2/' . $release . '/' . $data . '/' . $rpo . '/Todas');
        return $response;
    }

}
