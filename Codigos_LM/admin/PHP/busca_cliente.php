<?php
require_once '../../Classes/conecta.php';

header('Content-Type: application/json'); // Avisa que o retorno é JSON

try {
    $pdo = conecta_bd::getInstance()->getConnection();
    
    $termo = $_GET['termo'] ?? '';

    if (!empty($termo)) {
        // Busca por Nome, Email ou CPF
        $sql = "SELECT * FROM cliente 
                WHERE nome LIKE :termo 
                   OR email LIKE :termo 
                   OR cpf LIKE :termo
                ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':termo', "%$termo%");
        $stmt->execute();
    } else {
        // Se vazio, traz os últimos 20 (para não pesar) ou todos
        $sql = "SELECT * FROM cliente ORDER BY nome ASC";
        $stmt = $pdo->query($sql);
    }
    
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($clientes);

} catch (Exception $e) {
    // Retorna erro em JSON para o JS tratar
    http_response_code(500);
    echo json_encode(['erro' => $e->getMessage()]);
}
?>