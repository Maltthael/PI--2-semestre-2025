<?php

class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarComFiltros($filtros) {
        $sql = "SELECT * FROM estoque WHERE status = 'disponivel'";
        $params = [];

        if (isset($filtros['categorias']) && !empty($filtros['categorias'])) {
            $placeholders = implode(',', array_fill(0, count($filtros['categorias']), '?'));
            $sql .= " AND fk_id_categoria IN ($placeholders)";
            
            foreach ($filtros['categorias'] as $cat) {
                $params[] = $cat;
            }
        }

        if (isset($filtros['preco_max']) && !empty($filtros['preco_max'])) {
            $sql .= " AND preco_venda <= ?";
            $params[] = $filtros['preco_max'];
        }

        if (isset($filtros['busca']) && !empty($filtros['busca'])) {
            $sql .= " AND nome_produto LIKE ?";
            $params[] = '%' . $filtros['busca'] . '%';
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt;
    }
    
    public function buscarTodasCategorias() {
        $sql = "SELECT * FROM categorias ORDER BY nome_categoria ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM estoque WHERE id_produto = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>