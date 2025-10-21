<?php

$cep = '13606690';//$_POST['cep'];
function consultarCep($cep) {

    // Monta a URL para a API do ViaCEP
    $url = "https://viacep.com.br/ws/{$cepLimpo}/json/";

    // Faz a requisição e obtém o conteúdo JSON
    $json = file_get_contents($url);

    // Decodifica o JSON em um objeto PHP
    $endereco = json_decode($json);

    // Verifica se houve algum erro (o ViaCEP retorna um campo 'erro' se não encontrar)
    if (isset($endereco->erro)) {
        return false; // Retorna false se o CEP não for encontrado ou houver erro
    }

    return $endereco; // Retorna o objeto com os dados do endereço
}

// Exemplo de uso
if (isset($_POST['cep'])) {
    $cepBuscado = $_POST['cep'];
    $resultado = consultarCep($cepBuscado);

    
        echo "<h2>Resultado da Pesquisa</h2>";
        echo "<p>";
        echo "<br>CEP:</b> " . $resultado->cep . "<br>";
        echo "<br>Logradouro:</b> " . $resultado->logradouro . "<br>";
        echo "<br>Bairro:</b> " . $resultado->bairro . "<br>";
        echo "<br>Localidade:</b> " . $resultado->localidade . "<br>";
        echo "<br>UF:</b> " . $resultado->uf . "<br>";
        echo "</p>";

}

?>