<?php

$cep = $_POST['cep'];

$url = $url = "https://viacep.com.br/ws/{$cep}/json/";
$json1 = file_get_contents($url);

$json = json_decode($json1);

        $cep_f = $json->cep;
        $logradouro = $json->logradouro;
        $bairro = $json->bairro;
        $cidade = $json->localidade;
        $estado = $json->uf;


        echo $cep_f."<br>".$logradouro."<br>".$bairro."<br>".$cidade."<br>".$estado;
       