<?php
require_once 'usuario.php';
require_once 'conecta.php';

class Admin extends Usuario {
    private $nivel;

    public function __construct($nome, $email, $senha, $nivel = 'geral') {
        parent::__construct($nome, $email, $senha);
     
   
    public function __construct($nome, $email, $senha, $nivel = 'geral') {
        parent::__construct($nome, $email, $senha); //Herda da classe usúario

        $this->nivel = $nivel;
    }

    public function cadastrar(conecta_bd $conecta) {
        try {
            $pdo = $conecta->getConnection();
            $stmt = $pdo->prepare("INSERT INTO admin (nome, email, senha, nivel) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$this->nome, $this->email, $this->senha, $this->nivel]);
        } catch (PDOException $e) {
            return "Erro ao cadastrar admin: " . $e->getMessage();
        }
    }
}
?>
