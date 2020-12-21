<?php

namespace Totvs;

use \Rain\Tpl;

class Page
{
    private $tpl; // Para ter acesso em outros metodos.
    private $options = array();
    private $defaults = array( // Variaveis 'padrao'
        "header" => false,
        "scripts" => false,
        "footer" => false,
        "data" => array(), // Variaveis do template.
    );

    public function __construct($opts = array(), $tpl_dir = "/views/")
    {
        // $opts -> Variaveis da rota.
        // $tpl_dir -> Pasta do template

        // Sobrescrever arrays
        $this->options = array_merge($this->defaults, $opts);

        // Configuração do RainTpl
        $config = array(
            "tpl_dir" => $_SERVER["DOCUMENT_ROOT"] . $tpl_dir,
            "cache_dir" => $_SERVER["DOCUMENT_ROOT"] . $tpl_dir . "cache/",
            "debug" => false, // set to false to improve the speed
        );

        Tpl::configure($config);

        $this->tpl = new Tpl;

        // Atribuir as variaveis do template.
        $this->setDataTemplate($this->options["data"]);

        if ($this->options["header"] === true) {
            $this->tpl->draw("header");
        }
    }

    private function setDataTemplate($data = array())
    {
        // Atribuir variaveis do template.
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($name, $data = array(), $returnHTML = false)
    {
        // $name -> Nome do template.
        // $data -> Variaveis
        // $returnHTML -> Retornar o HTML ou apenas executar.
        $this->setDataTemplate($data);
        return $this->tpl->draw($name, $returnHTML);
    }

    public function __destruct()
    {
        if ($this->options["scripts"] === true) {
            $this->tpl->draw("scripts");
        }

        if ($this->options["footer"] === true) {
            $this->tpl->draw("footer");
        }
    }
}
