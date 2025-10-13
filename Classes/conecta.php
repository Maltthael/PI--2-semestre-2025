<?php
class conecta_bd {
    private static $instance = null;
    private $pdo;

    // Construtor privado 
    private function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost:3306;dbname=loja_informatica", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    // Instância única
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new conecta_bd();
        }
        return self::$instance;
    }

    // Retorna a conexão PDO
    public function getConnection() {
        return $this->pdo;
    }

}
?>
