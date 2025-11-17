<?php

require_once 'conecta.php';

class Admin  {

    public static function atualizar($dados) {
        try {
            $pdo = conecta_bd::getInstance()->getConnection();
            
            $sql = "UPDATE clientes SET 
                        nome = ?, email = ?, endereco = ?, numero = ?, 
                        bairro = ?, cep = ?, cidade = ?, estado = ?, cpf = ?
                    WHERE id_cliente = ?";
            
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $dados['nome'], $dados['email'], $dados['telefone'], $dados['endereco'], $dados['numero'], 
                $dados['bairro'], $dados['cep'], $dados['cidade'], $dados['estado'], $dados['cpf'],
                (int)$dados['id_cliente'] 
            ]);

            return true;

        } catch (PDOException $e) {
            throw new PDOException("Erro ao atualizar cliente: " . $e->getMessage());
        }
    }

   public static function excluir($id) {
        try {
            $pdo = conecta_bd::getInstance()->getConnection();
            $sql = "DELETE FROM cliente WHERE id_cliente = ?"; 
            $stmt = $pdo->prepare($sql);
            $stmt->execute([(int)$id]);
            return true;
        } catch (PDOException $e) {
            throw new PDOException("Erro ao excluir cliente: " . $e->getMessage());
        }
   
 }
}


?>
 
 