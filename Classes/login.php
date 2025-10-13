<?php
class Login {
    private $pdo;

    public function __construct(conecta_bd $conecta) {
        $this->pdo = $conecta->getConnection();
    }

    public function autenticar($email, $senha) {
        // Tenta como admin
        $stmt = $this->pdo->prepare("SELECT id, nome, email, senha FROM adm WHERE email = ? AND senha = ?");
        $stmt->execute([$email, $senha]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            return [
                'id' => $admin['id'],
                'nome' => $admin['nome'],
                'tipo' => 'admin'
            ];
        }

        // Tenta como cliente
        $stmt = $this->pdo->prepare("SELECT id, nome, email, senha FROM cliente WHERE email = ? AND senha = ?");
        $stmt->execute([$email, $senha]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            return [
                'id' => $cliente['id'],
                'nome' => $cliente['nome'],
                'tipo' => 'cliente'
            ];
        }

        return false; // nenhum encontrado
    }
}
?>
