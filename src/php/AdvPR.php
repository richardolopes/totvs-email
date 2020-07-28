<?php

namespace Totvs;

class AdvPR
{
    const RELEASE = 'http://10.171.78.41:8006/rest/filtrosportal/releas/homolog';
    const RPOS = 'http://10.171.78.41:8006/rest/filtrosportal/identi/homolog/'; // 12.1.023
    const PAIS = 'http://10.171.78.41:8006/rest/filtrosportal/pais/homolog/'; // 12.1.023/RPO_D-1
    const DATAS = 'http://10.171.78.41:8006/rest/filtrosportal/BRA/execDay/'; // 12.1.023/RPO_D-1/Todas
    const EXECUCAO = 'http://10.171.78.41:8006/rest/acompanhamentoExecucaoD1/'; // 12.1.027/20200402/RPO_D-1/Todas

    public function getExec($release, $data, $rpo, $squad)
    {
        try {
            $ch = curl_init(Advpr::EXECUCAO . 'Detail/' . $squad . '/BRA/' . $release . '/' . $data . '/' . $rpo . '/Todas');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'user' => '',
                ],
            ]);
            $response = json_decode(curl_exec($ch));
            curl_close($ch);

            return $response;
        } catch (Exception $e) {
            return [""];
        }
    }

    public function getQtdTestes($release, $rpo, $data)
    {
        try {
            $ch = curl_init(Advpr::EXECUCAO . 'BRA/2/' . $release . '/' . $data . '/' . $rpo . '/Todas');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'user' => '',
                ],
            ]);
            $response = json_decode(curl_exec($ch));
            curl_close($ch);

            return $response;
        } catch (Exception $e) {
            return [""];
        }
    }

    public function getRpos($release)
    {
        $ch = curl_init(Advpr::RPOS . $release);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;
    }

    public function getDatas($release, $rpo)
    {
        $ch = curl_init(Advpr::DATAS . $release . '/' . $rpo . '/Todas');
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $this->maiorData($response);
    }

    public function getReleases()
    {
        $ch = curl_init(Advpr::RELEASE);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;
    }

    public function maiorData($range)
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

    public function getQuebras($erros)
    {
        $exec = [];
        !empty($erros) ? $total = count($erros) : $total = 0;

        for ($i = 0; $i < $total; $i++) {
            $rotina = $erros[$i]->rotina;

            if (!isset($exec[$rotina])) {
                $exec[$rotina] = array(
                    "CTS" => "",
                    "TOTAL" => 0,
                );
            }

            $erro = explode('-', $erros[$i]->erro)[0];

            if (stripos($erro, "TimeOut") === false) {
                $erro = 'CT' . $erro;
            }

            $exec[$rotina]["CTS"] .= $erro;
            $exec[$rotina]["TOTAL"] += 1;
        }

        return array(
            "QUEBRAS" => $exec,
            "TOTAL" => $total,
        );
    }

    public function retExecDiario($release, $rpo, $data, $squad)
    {
        $execucao = $this->getExec($release, $data, $rpo, $squad);

        if (isset($execucao->message)) {
            die("Portal do AdvPR indisponível");
        }

        if (count($execucao) > 0) {
            $nome = "$squad - $release $data.csv";

            (!file_exists($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "csv")) ? mkdir($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "csv") : "";

            $dir = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "csv" . DIRECTORY_SEPARATOR . $nome;
            $fp = fopen($dir, 'w');

            fwrite($fp, "erro;rotina;dtProg;banco\n");
            for ($i = 0; $i < count($execucao); $i++) {
                fwrite($fp, $execucao[$i]->erro . ";" . $execucao[$i]->rotina . ";" . $execucao[$i]->dtProg . ";" . $execucao[$i]->banco . "\n");
            }
            fclose($fp);

            $erros = $this->getQuebras($execucao);

            $return = array(
                "RELEASE" => $release,
                "DATA" => $this->stringParaData($data),
                "QUEBRAS" => $erros["QUEBRAS"],
                "TOTAL_QUEBRAS" => $erros["TOTAL"],
                "TOTAL_FONTES" => count($erros["QUEBRAS"]),
                "CSV" => array(
                    "NOME" => $nome,
                    "LOCAL" => $dir,
                ),
            );

            return $return;
        } else {
            return $execucao;
        }
    }
}
