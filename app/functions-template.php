<?php

require_once "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use \Totvs\Util;

function convertDate(string $date) {
	return Util::stringToDayMonthYear($date);
}