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

    public static function buscarDadosPorId($pdo, $id) {
        $sql = "SELECT * FROM cliente WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function buscarUltimosPedidos($pdo, $id) {
        $sql = "SELECT * FROM vendas WHERE fk_cliente_id_cliente = ? ORDER BY data_venda DESC LIMIT 3";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function atualizarDados($pdo, $id, $dados) {
        try {
            $sql = "UPDATE cliente SET 
                    nome = ?, 
                    email = ?, 
                    telefone = ?, 
                    endereco = ?, 
                    numero = ?, 
                    bairro = ?, 
                    cidade = ?, 
                    estado = ?, 
                    cep = ?
                    WHERE id_cliente = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $dados['nome'],
                $dados['email'],
                $dados['telefone'],
                $dados['endereco'],
                $dados['numero'],
                $dados['bairro'],
                $dados['cidade'],
                $dados['estado'],
                $dados['cep'],
                $id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function verificarSenhaAtual($pdo, $id, $senhaDigitada) {
        $sql = "SELECT senha FROM cliente WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && $resultado['senha'] === $senhaDigitada) {
            return true;
        }
        return false;
    }

    public static function alterarSenha($pdo, $id, $novaSenha) {
        try {
            $sql = "UPDATE cliente SET senha = ? WHERE id_cliente = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$novaSenha, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function abrirOrdemServico($pdo, $idCliente, $assunto, $servico) {
        try {
            $prazo = date('Y-m-d H:i:s', strtotime('+7 days'));
            
            $tituloCompleto = "$servico - $assunto";

            $sql = "INSERT INTO ordem_servico (titulo, status, prazo, fk_cliente_id_cliente) 
                    VALUES (?, 'aberto', ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $tituloCompleto,
                $prazo,
                $idCliente
            ]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>