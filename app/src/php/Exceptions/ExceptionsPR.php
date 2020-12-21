<?php

namespace Totvs\Exceptions;

class ExceptionsPR extends \DomainException
{
    public function curloptTimeOut()
    {
        echo "<BR>";
        echo "Limite de tentativas atingido. <BR>";
        echo "Próxima execução... <BR>";
        echo "<BR>";
    }
}