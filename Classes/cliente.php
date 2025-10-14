<?php

require_once 'conecta.php';
require_once 'usuario.php';

/*Herda da classe usuário*/
class cliente extends usuario{

    
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;
    private $cpf;

    public function __construct($nome, $email, $senha,$endereco,$numero,$bairro,$cidade,$estado,$cep,$cpf) {
    parent::__construct($nome,$email,$senha); /* Puxando a herança*/
    $this->endereco = $endereco;
    $this->numero = $numero;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
    $this->estado = $estado;
    $this->cep = $cep;
    $this->cpf = $cpf;}

    public function cadastrar(conecta_bd $conecta) {
        try{
        $pdo = $conecta->getConnection();


      
        $stmt = $pdo->prepare("INSERT INTO cliente (nome,email,senha,endereco,numero,bairro,cidade,estado,cep,cpf)VALUES(?,?,?,?,?,?,?,?,?,?)");
        $resultado = $stmt->execute([$this->nome,$this->email,$this->senha,$this->endereco,$this->numero,$this->bairro,$this->cidade,$this->estado,$this->cep,$this->cpf]);
        return $resultado;
    } catch (PDOException $e){
        return "Erro ao cadastrar: ".$e->getMessage();
    }
  }
}
?>