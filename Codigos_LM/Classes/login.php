<?php
class Login {
    private $pdo;

    public function __construct() {
        $this->pdo = conecta_bd::getInstance()->getConnection(); 
    }

    public function verificar_logado(){
        return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;
    }

    public function autenticar($email, $senha) {
        
        $stmt = $this->pdo->prepare("SELECT id_adm, nome, email FROM adm WHERE email = ? AND senha = ?");
        $stmt->execute([$email, $senha]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $_SESSION["logged_in"] = true;
            $_SESSION["usuario_id"] = $admin['id_adm']; 
            $_SESSION["usuario_nome"] = $admin['nome'];
            $_SESSION["usuario_email"] = $admin['email'];
            $_SESSION["usuario_tipo"] = "admin";

            return [
                'id' => $admin['id_adm'],
                'nome' => $admin['nome'],
                'tipo' => 'admin',
            ];
        }

        $stmt = $this->pdo->prepare("SELECT id_cliente, nome, email FROM cliente WHERE email = ? AND senha = ?");
        $stmt->execute([$email, $senha]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) { 
            $_SESSION["logged_in"] = true;
            $_SESSION["usuario_id"] = $cliente['id_cliente'];
            $_SESSION["usuario_nome"] = $cliente['nome'];
            $_SESSION["usuario_email"] = $cliente['email'];
            $_SESSION["usuario_tipo"] = 'cliente'; 

            return [
                'id' => $cliente['id_cliente'],
                'nome' => $cliente['nome'],
                'tipo' => 'cliente'
            ];
        }

        return false; 
    }

    public function logout() {
        session_destroy();
        header("Location:../Cliente/entrar.php");
        exit();
    } 
}
?>