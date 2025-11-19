<?php

require_once 'conecta.php';
require_once 'usuario.php';

class Cliente extends Usuario {

    private $telefone;
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;
    private $cpf;

    public function __construct($nome, $email, $telefone, $senha, $endereco, $numero, $bairro, $cidade, $estado, $cep, $cpf) {
        parent::__construct($nome, $email, $senha); 
        $this->telefone = $telefone; 
        $this->endereco = $endereco;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
        $this->cpf = $cpf;
    }

    public function cadastrar(conecta_bd $conecta) {
        try {
            $pdo = $conecta->getConnection();

            $verificarEmail = $pdo->prepare("SELECT id_cliente FROM cliente WHERE email = ?");
            $verificarEmail->execute([$this->email]);

            if ($verificarEmail->rowCount() > 0) {
                return "Este e-mail já está cadastrado em nosso sistema. Tente fazer login.";
            }

            $verificarCpf = $pdo->prepare("SELECT id_cliente FROM cliente WHERE cpf = ?");
            $verificarCpf->execute([$this->cpf]);

            if ($verificarCpf->rowCount() > 0) {
                return "O CPF informado já possui cadastro.";
            }

            $sql = "INSERT INTO cliente (nome, email, telefone, senha, endereco, numero, bairro, cidade, estado, cep, cpf) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $this->nome,
                $this->email,
                $this->telefone,
                $this->senha, 
                $this->endereco,
                $this->numero,
                $this->bairro,
                $this->cidade,
                $this->estado,
                $this->cep,
                $this->cpf
            ]);
            
            return true;

        } catch (PDOException $e) {
            return "Erro técnico ao cadastrar: " . $e->getMessage();
        }
    }
}
?>