<?php

require_once 'conecta.php';
require_once 'usuario.php';

/* Herda da classe usuário */
class Cliente extends Usuario {

    private $telefone; // <--- NOVO
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;
    private $cpf;

    // Construtor atualizado recebendo $telefone na 3ª posição
    public function __construct($nome, $email, $telefone, $senha, $endereco, $numero, $bairro, $cidade, $estado, $cep, $cpf) {
        parent::__construct($nome, $email, $senha); /* Puxando a herança */
        $this->telefone = $telefone; // <--- NOVO
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

            // Query atualizada com a coluna telefone
            $sql = "INSERT INTO cliente (nome, email, telefone, senha, endereco, numero, bairro, cidade, estado, cep, cpf) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            
            // Array de execução atualizado com $this->telefone
            $resultado = $stmt->execute([
                $this->nome,
                $this->email,
                $this->telefone, // <--- NOVO
                $this->senha,
                $this->endereco,
                $this->numero,
                $this->bairro,
                $this->cidade,
                $this->estado,
                $this->cep,
                $this->cpf
            ]);
            
            return $resultado;

        } catch (PDOException $e) {
            return "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>