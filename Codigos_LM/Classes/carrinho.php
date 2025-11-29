<?php
class Carrinho {
    
    public function __construct() {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
    }

    public function adicionar($id, $qtd) {
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id] += $qtd;
        } else {
            $_SESSION['carrinho'][$id] = $qtd;
        }
    }

    public function atualizarQuantidade($id, $qtd) {
        if (isset($_SESSION['carrinho'][$id])) {
            if ($qtd > 0) {
                $_SESSION['carrinho'][$id] = $qtd;
            } else {
                $this->remover($id); 
            }
        }
    }

    public function remover($id) {
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
    }

    public function getItens() {
        return $_SESSION['carrinho'];
    }

    public function limpar() {
        $_SESSION['carrinho'] = [];
    }
    
    public function getTotalItens() {
        return count($_SESSION['carrinho']);
    }
}
?>