<?php
require_once 'conecta.php'; 

class Login {
    private $pdo;

    public function __construct() {
        $this->pdo = conecta_bd::getInstance()->getConnection(); 
    }

    public function autenticar($email, $senha) {
        
        $stmt = $this->pdo->prepare("SELECT * FROM adm WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            if (password_verify($senha, $admin['senha'])) {
                $this->criarSessao($admin['id_adm'], $admin['nome'], $admin['email'], 'admin');
                return true;
            }
            elseif ($senha === $admin['senha']) {
                $this->criarSessao($admin['id_adm'], $admin['nome'], $admin['email'], 'admin');
                return true;
            }
        }

        $stmt = $this->pdo->prepare("SELECT * FROM cliente WHERE email = ?");
        $stmt->execute([$email]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            if (password_verify($senha, $cliente['senha'])) {
                $this->criarSessao($cliente['id_cliente'], $cliente['nome'], $cliente['email'], 'cliente');
                return true;
            }
            elseif ($senha === $cliente['senha']) {
                $this->criarSessao($cliente['id_cliente'], $cliente['nome'], $cliente['email'], 'cliente');
                return true;
            }
        }

        return false; 
    }

    private function criarSessao($id, $nome, $email, $tipo) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION["logged_in"] = true;
        $_SESSION["usuario_id"] = $id;
        $_SESSION["usuario_nome"] = $nome;
        $_SESSION["usuario_email"] = $email;
        $_SESSION["usuario_tipo"] = $tipo;
        
        if ($tipo === 'cliente') {
            $_SESSION['cliente_nome'] = $nome;
            $_SESSION['cliente_id'] = $id;
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header("Location: ../Cliente/index.php"); 
        exit();
    } 
}
?>