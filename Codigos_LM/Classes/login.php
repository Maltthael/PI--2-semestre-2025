<?php
class Login {
    private $pdo;

    private $emailAdmin = 'adminLM@gmail.com';
    private $senhaAdmin = 'Admin2025.';

        public function __construct() {
        $this->pdo = conecta_bd::getInstance()->getConnection(); 
    } // Puxa conexão pdo única 


    // Verifica as credenciais 
    public function verificar_credenciais($email, $senha) {
        if ($email === $this->emailAdmin && $senha === $this->senhaAdmin){
            $_SESSION["logged_in"]=true;
            $_SESSION["usuario_tipo"] = "admin";
            $_SESSION["usuario_email"] = $this->emailAdmin;

            return [
                'id'=> 0,
                'nome' =>'Administrador',
                'tipo' => 'admin',
            ]; //tipo fixo
        }
        return false;
    }
    // Verifica se o usuário está logado
     public function verificar_logado(){
       return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;
    }
        
      
      public function autenticar($email, $senha) {
          
        // Tenta como admin

           $admin = $this->verificar_credenciais($email, $senha);
        if ($admin) {
            return $admin;
        }
        // Tenta como cliente
        $stmt = $this->pdo->prepare("SELECT id, nome, email, senha FROM cliente WHERE email = ? AND senha = ?");
        $stmt->execute([$email, $senha]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if ($cliente) 
            { 
            $_SESSION["logged_in"] = true;
            $_SESSION["usuario_id"] = $cliente['id'];
            $_SESSION["usuario_nome"] = $cliente['nome'];
            $_SESSION["usuario_tipo"] = 'cliente';
            $_SESSION["usuario_email"] = $cliente['email'];


            return [
                'id' => $cliente['id'],
                'nome' => $cliente['nome'],
                'tipo' => 'cliente'
            ];
        }

        return false; // nenhum encontrado
    }

     public function logout() {
       session_destroy();
       header("Location:../Cliente/entrar.php");
       exit();
     } // Destrói a conexão 
   
}
?>
