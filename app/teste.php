<?php

require_once "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
require_once "functions-template.php";

use \Totvs\Page;
use \Totvs\Controller\HttpProtheusRobot;

$release = '12.1.027';
$date = '20200930';
$rpo = 'RPO_D-1';

$cases = HttpProtheusRobot::getAmountTestCases($release, $date, $rpo);

echo json_encode($cases->data[1]); // array das squads
echo json_encode($cases->data[0][0]); // quantidade de testcases que passaram
exit;


$errors = array(
	'12.1.027' =>
	array(
		'FINANCEIRO' =>
		array(
			'ERRORS' =>
			array(),
			'TOTAL' => 0,
			'DIR' => '',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - APLICACAO' =>
		array(
			'ERRORS' =>
			array(
				'FINR865' =>
				array(
					'CTS' => '012 ',
					'TOTAL' => 1,
				),
			),
			'TOTAL' => 1,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - APLICACAO - 12.1.027 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - COMPENSACAO' =>
		array(
			'ERRORS' =>
			array(
				'FINA460' =>
				array(
					'CTS' => '214 ',
					'TOTAL' => 1,
				),
			),
			'TOTAL' => 1,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - COMPENSACAO - 12.1.027 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - GRAVACAO' =>
		array(
			'ERRORS' =>
			array(),
			'TOTAL' => 0,
			'DIR' => '',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - TESOURARIA' =>
		array(
			'ERRORS' =>
			array(
				'FINA390' =>
				array(
					'CTS' => 'TimeOut ',
					'TOTAL' => 1,
				),
			),
			'TOTAL' => 1,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - TESOURARIA - 12.1.027 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
	),
	'12.1.025' =>
	array(
		'FINANCEIRO' =>
		array(
			'ERRORS' =>
			array(),
			'TOTAL' => 0,
			'DIR' => '',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - APLICACAO' =>
		array(
			'ERRORS' =>
			array(
				'FINR865' =>
				array(
					'CTS' => '012 ',
					'TOTAL' => 1,
				),
			),
			'TOTAL' => 1,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - APLICACAO - 12.1.025 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - COMPENSACAO' =>
		array(
			'ERRORS' =>
			array(
				'FINA460' =>
				array(
					'CTS' => '214 ',
					'TOTAL' => 1,
				),
			),
			'TOTAL' => 1,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - COMPENSACAO - 12.1.025 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - GRAVACAO' =>
		array(
			'ERRORS' =>
			array(),
			'TOTAL' => 0,
			'DIR' => '',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - TESOURARIA' =>
		array(
			'ERRORS' =>
			array(
				'FINA390' =>
				array(
					'CTS' => 'TimeOut ',
					'TOTAL' => 1,
				),
			),
			'TOTAL' => 1,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - TESOURARIA - 12.1.025 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
	),
	'12.1.023' =>
	array(
		'FINANCEIRO' =>
		array(
			'ERRORS' =>
			array(),
			'TOTAL' => 0,
			'DIR' => '',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - APLICACAO' =>
		array(
			'ERRORS' =>
			array(
				'FINR200' =>
				array(
					'CTS' => '001 001 001 001 001 001 001 001 001 001 001 001 ',
					'TOTAL' => 12,
				),
				'FINR865' =>
				array(
					'CTS' => '001 005 004 003 010 002 007 006 008 009 001 002 005 003 010 004 007 008 009 006 012 012 012 012 012 012 012 012 012 012 ',
					'TOTAL' => 30,
				),
				'FINA350' =>
				array(
					'CTS' => '001 003 002 003 002 001 ',
					'TOTAL' => 6,
				),
			),
			'TOTAL' => 48,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - APLICACAO - 12.1.023 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - COMPENSACAO' =>
		array(
			'ERRORS' =>
			array(
				'FINA460' =>
				array(
					'CTS' => '214 ',
					'TOTAL' => 1,
				),
				'FINA340' =>
				array(
					'CTS' => '025 026 027 029 034 063 064 063 064 063 064 063 064 ',
					'TOTAL' => 13,
				),
			),
			'TOTAL' => 14,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - COMPENSACAO - 12.1.023 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - GRAVACAO' =>
		array(
			'ERRORS' =>
			array(
				'FINA080' =>
				array(
					'CTS' => '082 081 082 081 082 081 081 082 ',
					'TOTAL' => 8,
				),
				'FINA050' =>
				array(
					'CTS' => '010 ',
					'TOTAL' => 1,
				),
			),
			'TOTAL' => 9,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - GRAVACAO - 12.1.023 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
		'FINANCEIRO - TESOURARIA' =>
		array(
			'ERRORS' =>
			array(
				'FINA677' =>
				array(
					'CTS' => '006 009 005 003 008 004 002 007 012 001 010 000 011 ',
					'TOTAL' => 13,
				),
				'FINA666' =>
				array(
					'CTS' => '000 001 003 007 013 005 016 008 014 ',
					'TOTAL' => 9,
				),
				'FINA667' =>
				array(
					'CTS' => '001 000 012 008 014 007 002 004 010 016 003 015 ',
					'TOTAL' => 12,
				),
				'FINA061' =>
				array(
					'CTS' => '044 042 039 043 ',
					'TOTAL' => 4,
				),
				'FINA665' =>
				array(
					'CTS' => '004 011 001 002 003 007 015 000 010 ',
					'TOTAL' => 9,
				),
				'FINA390' =>
				array(
					'CTS' => 'TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut TimeOut ',
					'TOTAL' => 14,
				),
				'FINA240' =>
				array(
					'CTS' => '011 011 011 011 ',
					'TOTAL' => 4,
				),
				'FINR300' =>
				array(
					'CTS' => '001 002 ',
					'TOTAL' => 2,
				),
				'WSFIN677' =>
				array(
					'CTS' => 'WSFIN67705 WSFIN67710 WSFIN67701 WSFIN67701 WSFIN67705 WSFIN67710 WSFIN67701 WSFIN67710 WSFIN67705 ',
					'TOTAL' => 9,
				),
			),
			'TOTAL' => 76,
			'DIR' => 'C:/xampp/htdocs\\csv\\FINANCEIRO - TESOURARIA - 12.1.023 20200929.csv',
			'SUCCESS' => 0,
			'DATE' => '20200929',
		),
	),
);

$rpo = 'RPO_D-1';
$releases = [
	'12.1.027',
	'12.1.025',
	'12.1.023',
];

$total = [];

foreach ($errors as $squad => $value) {
	$calc = 0;

	foreach ($value as $values) {
		$calc += $values["TOTAL"];
	}

	$total[$squad] = $calc;
}

$page = new Page();
$page->setTpl("email", array(
	"header" => "Automação de Testes - " . $rpo,
	"total" => $total,
	"errors" => $errors,
));
