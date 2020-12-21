<?php

namespace Totvs;

use \Totvs\Controller\HttpProtheusRobot as HttpPR;
use \Totvs\Model\ProtheusRobot;
use \Totvs\Exceptions\ExceptionsPR;
use \Totvs\Util;

class AdvPR extends ProtheusRobot
{
    const RELEASE = 'rest/filtrosportal/releas/homolog';
    const RPOS = 'rest/filtrosportal/identi/homolog/'; // 12.1.023
    const PAIS = 'rest/filtrosportal/pais/homolog/'; // 12.1.023/RPO_D-1
    const DATAS = 'rest/filtrosportal/BRA/execDay/'; // 12.1.023/RPO_D-1/Todas
    const EXECUCAO = 'rest/acompanhamentoExecucaoD1/'; // 12.1.027/20200402/RPO_D-1/Todas

    public function __construct(string $rpo, string $release, string $squad_name, string $date = "")
    {
        parent::__construct($rpo, $release, $squad_name, $date);
    }

    public function __destruct()
    {
        $dir = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "logs";

        if (!file_exists($dir)) mkdir($dir);

        $name = "{$this->getSquadName()} - {$this->getRelease()} {$this->getDate()}";
        $dir .= DIRECTORY_SEPARATOR . $name . ".txt";

        $file = fopen($dir, 'w');
        if (!$file) {
            echo "<BR><BR>";
            echo "O arquivo de log não foi gerado. <BR>";
            echo "Info: {$name} <BR>";
            echo "<BR><BR>";
            return;
        }

        fwrite($file, "{$name}\n");
        fclose($file);
    }

    public function getErrors(): array
    {
        try {
            $errors = HttpPR::getExecution($this->getRelease(), $this->getDate(), $this->getRpo(), $this->getSquadNameURL());
        } catch(ExceptionsPR $e) {
            $errors = [];
            $e->curloptTimeOut();
        }

        $group = [];
        $len = 0;
        $dir = "";
        
        if (gettype($errors) === "array" && count($errors) > 0) {
            $len = count($errors);
            $dir = $this->saveErrors($errors);
            $group = $this->groupErrors($errors);
        }

        return array(
            "ERRORS" => $group,
			"TOTAL" => $len,
			"SUCCESS" => 0,
            "DIR" => $dir,
            "DATE" => Util::stringToDayMonthYear($this->getDate())
        );
    }

    private function groupErrors(array $errors): array
    {
        $len = count($errors);
        $group = array();

        for ($i = 0; $i < $len; $i++) {
            $source = $errors[$i]->rotina;
            
            if (!isset($group[$source]["CTS"])) {
                $group[$source] = array(
                    "CTS" => "",
                    "TOTAL" => 0
                );
            }

            $ct = explode("-", $errors[$i]->erro)[0];

            // se o caso de teste não for um erro comum, adicionará um CT na frente.
            // (ex de casos incomuns: TimeOut, Fail)
            if (is_numeric(trim($ct))) {
                $ct = 'CT' . $ct;
            }

            $group[$source]["CTS"] .= $ct;
            $group[$source]["TOTAL"] += 1;
        }
        
        return $group;
    }

    private function saveErrors(array $errors): string
    {
        if (count($errors) > 0) {
            $dir = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "csv";
    
            if (!file_exists($dir)) mkdir($dir);
    
            $name = "{$this->getSquadName()} - {$this->getRelease()} {$this->getDate()}";
            $dir .= DIRECTORY_SEPARATOR . $name . ".csv";
    
            $file = fopen($dir, 'w');
            if (!$file) {
                echo "<BR><BR>";
                echo "O arquivo de erros não foi gerado. <BR>";
                echo "Info: {$name} <BR>";
                echo "<BR><BR>";
    
                return "";
            }
    
            fwrite($file, "erro;rotina;dtProg;banco\n");
    
            for ($i = 0; $i < count($errors); $i++) {
                $line = $errors[$i];
                fwrite($file, "{$line->erro};{$line->rotina};{$line->dtProg};{$line->banco}\n");
            }
    
            fclose($file);
    
            return $dir;
        } else {
            return "";
        }
    }
}
