<?php

require_once "src" . DIRECTORY_SEPARATOR . "mail.php";
require_once "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

ini_set('max_execution_time', 1200);

use \Totvs\AdvPR;
use \Totvs\Page;
use \Totvs\Util;
use \Totvs\Controller\HttpProtheusRobot;

$rpo = 'RPO_D-1';
$releases = [
	'12.1.027',
	'12.1.025',
	'12.1.023',
];

$errors = array();

for ($i_squad = 0; $i_squad < count($squads); $i_squad++) {
	// definindo a squad que será executada, ex: primeiro indice do array de squads.
	$squad = $squads[$i_squad];

	for ($i_release = 0; $i_release < count($releases); $i_release++) {
		// definindo a release que vai ser trabalhada, ex: 12.1.023.
		$release = $releases[$i_release];
		echo "RELEASE: $release <BR>";

		$date = HttpProtheusRobot::getDates($release, $rpo);
		$cases = HttpProtheusRobot::getAmountTestCases($release, $date, $rpo);

		for ($i_small_squad = 0; $i_small_squad < count($squad["squads"]); $i_small_squad++) {
			// definindo o nome da squad, ex: FINANCEIRO - APLICACAO.
			$small_squad = $squad["squads"][$i_small_squad];
			echo "SMALL SQUAD: $small_squad <BR>";

			$advpr = new AdvPR($rpo, $release, $small_squad, $date);
			$err = $advpr->getErrors();
			$errors[$release][$small_squad] = $err;

			if (count($err) > 0) {
				array_push($mensagens, "A execução do release $release ($date) não foi finalizada ou não tiveram quebras. Até o momento, passaram $qtd casos de teste.");
			}
		}

		// $page = new Page();
		// $html = $page->setTpl("email", array(
		//     "header" => "Automação de Testes - " . $rpo,
		//     "errors" => $errors,
		// ), true);
	}

	echo json_encode($errors);
	echo "<br>";
	$errors = array();
}
