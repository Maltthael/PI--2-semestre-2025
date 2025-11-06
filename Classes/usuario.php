<?php 
 class usuario {
    protected $nome;
    protected $email;
    protected $senha;

    public function __construct($nome, $email,$senha){
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }
    public function getNome() {
        return $this->nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }
 }


?>