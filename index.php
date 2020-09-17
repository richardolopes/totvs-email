<?php

require_once "src" . DIRECTORY_SEPARATOR . "mail.php";
require_once "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

set_time_limit(1000);

use \Totvs\AdvPR;
use \Totvs\Mailer;
use \Totvs\Page;
use \Totvs\Util;

$advpr = new AdvPR();

$rpo = 'RPO_D-1';

$data27 = $advpr->getDatas('12.1.027', $rpo);
$data25 = $advpr->getDatas('12.1.025', $rpo);
$data23 = $advpr->getDatas('12.1.023', $rpo);

for ($i = 0; $i < count($squads); $i++) {
    $quebras = array();
    $mensagens = array();
    $equipe = $squads[$i];
    $squad = rawurlencode(trim($squads[$i]["squad"]));

    $r27 = $advpr->retExecDiario('12.1.027', $rpo, $data27, $squad);
    $r25 = $advpr->retExecDiario('12.1.025', $rpo, $data25, $squad);
    $r23 = $advpr->retExecDiario('12.1.023', $rpo, $data23, $squad);

    $qtd27 = $advpr->getQtdTestes('12.1.027', $rpo, $data27);
    $qtd25 = $advpr->getQtdTestes('12.1.025', $rpo, $data25);
    $qtd23 = $advpr->getQtdTestes('12.1.023', $rpo, $data23);

    $key = function ($squads, $squad) {
        foreach ($squads as $key => $value) {
            if ($squad == trim($value)) {
                return $key;
            }
        }

        return -1;
    };

    $key27 = $key($qtd27->data[1], $squads[$i]["squad"]);
    $key25 = $key($qtd25->data[1], $squads[$i]["squad"]);
    $key23 = $key($qtd23->data[1], $squads[$i]["squad"]);

    // adiciona a qtd de falhas e sucessos
    $add = function ($key, $release, $qtd) {
        if ($key >= 0) {
            $release["QTD"] = array(
                "PASSOU" => $qtd->data[0][0]->data[$key],
                "FALHOU" => $qtd->data[0][1]->data[$key],
            );

            return $release;
        }
    };

    // adicionar os nomes das squads
    $hr = function ($quebras) use ($equipe) {
        if (isset($equipe["sources"])) {
            $res = [];
            foreach ($equipe["sources"] as $equipe => $fontes) {
                foreach ($fontes as $fonte) {
                    if (array_key_exists($fonte, $quebras)) {
                        $res[$equipe][$fonte] = $quebras[$fonte];
                        unset($quebras[$fonte]);
                    }
                }
            }

            if (count($quebras) > 0) {
                $res['Equipe não definida'] = $quebras;
            }

            ksort($res);
        } else {
            $res[$equipe["squad"]] = $quebras;
        }

        return $res;
    };

    $mensagem = function ($data, $qtd, $release) {
        return 'A execução do release ' . $release . ' (' . Util::stringParaData($data) . ') não foi finalizada ou não tiveram quebras. Até o momento, passaram "' . $qtd . '" casos de teste.';
    };

    $r27 = $add($key27, $r27, $qtd27);
    if (isset($r27["QUEBRAS"])) {
        $r27["QUEBRAS"] = $hr($r27["QUEBRAS"]);
        array_push($quebras, $r27);
    } else {
        array_push($mensagens, $mensagem($data27, $r27["QTD"]["PASSOU"], "12.1.27"));
    }

    $r25 = $add($key25, $r25, $qtd25);
    if (isset($r25["QUEBRAS"])) {
        $r25["QUEBRAS"] = $hr($r25["QUEBRAS"]);
        array_push($quebras, $r25);
    } else {
        array_push($mensagens, $mensagem($data25, $r25["QTD"]["PASSOU"], "12.1.25"));
    }

    $r23 = $add($key23, $r23, $qtd23);
    if (isset($r23["QUEBRAS"])) {
        $r23["QUEBRAS"] = $hr($r23["QUEBRAS"]);
        array_push($quebras, $r23);
    } else {
        array_push($mensagens, $mensagem($data23, $r23["QTD"]["PASSOU"], "12.1.23"));
    }

    $page = new Page(array(
        "header" => false,
        "scripts" => false,
        "footer" => false,
    ));
    $html = $page->setTpl("contents-email", array(
        "header" => "Automação de Testes - " . $rpo,
        "squad" => rawurldecode($squad),
        "releases" => $quebras,
        "mensagens" => $mensagens,
    ), true);

    $email = new Mailer("Automação de Testes - " . rawurldecode($squad), $html, $squads[$i]["email"], [$r27["CSV"], $r25["CSV"], $r23["CSV"]]);

    echo "E-mail Squad: " . rawurldecode($squad) . " enviado!<br>";
}
