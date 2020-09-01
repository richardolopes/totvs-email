<?php

$url = 'http://10.171.78.41:8006/rest/filtrosportal/BRA/execDay/12.1.023/RPO_D-1/Todas';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch));
// Verifica se houve erros e exibe a mensagem de erro
if ($errno = curl_errno($ch)) {
    $error_message = curl_strerror($errno);
    echo "cURL error ({$errno}):\n {$error_message}";
}

curl_close($ch);

echo gettype($response);
exit;

// echo base64_encode(openssl_random_pseudo_bytes(30));

// curl_exec($ch);
// // Fecha o manipulador
// curl_close($ch);
