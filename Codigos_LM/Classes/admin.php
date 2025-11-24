<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'conecta.php';

class Admin {
    
    private static function getPdo(): PDO {
        return conecta_bd::getInstance()->getConnection();
    }
    
    private static function formatPrice(string $preco): float {
        return (float)str_replace(['R$', '.', ','], ['', '', '.'], $preco);
    }
    
    private static function handleImageUpload(array $file, string $oldFileName = null): array {
        $novo_nome_imagem = null;
        $erro_upload = "";
        
        $pasta_destino = dirname(__DIR__) . "/admin/img/produtos/"; 

        if (isset($file) && $file['size'] > 0 && $file['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'])) {
                $novo_nome = "prod_" . uniqid() . "." . $extensao;

                if (!is_dir($pasta_destino)) {
                    mkdir($pasta_destino, 0777, true);
                }

                if (move_uploaded_file($file['tmp_name'], $pasta_destino . $novo_nome)) {
                    $novo_nome_imagem = $novo_nome; 
                    
                    if ($oldFileName && $oldFileName !== 'padrao.png') {
                        $caminho_antigo = $pasta_destino . $oldFileName;
                        if (file_exists($caminho_antigo)) {
                            unlink($caminho_antigo);
                        }
                    }
                    
                } else {
                    $erro_upload = "Falha ao mover a foto para a pasta: " . $pasta_destino;
                }
            } else {
                $erro_upload = "Formato de imagem inválido (Use JPG, PNG ou WEBP).";
            }
        } else if (isset($file) && $file['error'] !== UPLOAD_ERR_NO_FILE && $file['error'] !== UPLOAD_ERR_OK) {
             $erro_upload = "Erro no envio do arquivo. Código: " . $file['error'];
        }

        return ['nome' => $novo_nome_imagem, 'erro' => $erro_upload];
    }
    
    public static function salvarCategoria(string $nome_categoria): array {
        $redirect = '../admin/produtos.php';
        try {
            $pdo = self::getPdo();
            $nome_categoria = trim($nome_categoria);

            if (empty($nome_categoria)) {
                return ['success' => false, 'message' => 'O nome da categoria não pode ser vazio.', 'redirect' => $redirect];
            }

            $stmt = $pdo->prepare("SELECT id_categoria FROM categorias WHERE nome_categoria = ?");
            $stmt->execute([$nome_categoria]);
            
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => "A categoria \"$nome_categoria\" já existe!", 'redirect' => $redirect];
            }

            $sql = "INSERT INTO categorias (nome_categoria) VALUES (?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome_categoria]);

            return ['success' => true, 'message' => 'Categoria cadastrada com sucesso!', 'redirect' => $redirect];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao salvar: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }

    public static function salvarProduto(array $data, array $file): array {
        $redirect = '../admin/produtos.php';
        try {
            $pdo = self::getPdo();

            $quantidade = (int)($data['quantidade'] ?? 0);
            $preco_custo = self::formatPrice($data['preco_custo'] ?? '0,00');
            $preco_venda = self::formatPrice($data['preco_venda'] ?? '0,00');
            $status = ($quantidade > 0) ? 'disponivel' : 'esgotado';

            $upload = self::handleImageUpload($file['foto_produto'] ?? []);
            $nome_imagem = $upload['nome'] ?? 'padrao.png';
            $erro_upload = $upload['erro'];
            
            $sql = "INSERT INTO estoque (nome_produto, fk_id_categoria, quantidade, preco_custo, preco_venda, status, foto, descricao) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data['nome'], (int)$data['categoria_id'], $quantidade, $preco_custo, $preco_venda, $status, $nome_imagem, $data['descricao']]);

            $mensagem = 'Produto cadastrado com sucesso!';
            $sucesso = true;

            if (!empty($erro_upload)) {
                 $mensagem = "Produto salvo, mas a imagem falhou: $erro_upload";
                 $sucesso = false; 
            }

            return ['success' => $sucesso, 'message' => $mensagem, 'redirect' => $redirect];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao cadastrar: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }

    public static function editarProduto(array $data, array $file): array {
        $redirect = '../admin/produtos.php';
        try {
            $pdo = self::getPdo();

            $id = (int)$data['id_produto'];
            $preco_custo = self::formatPrice($data['preco_custo'] ?? '0,00');
            $preco_venda = self::formatPrice($data['preco_venda'] ?? '0,00');

            $stmt = $pdo->prepare("SELECT foto FROM estoque WHERE id_produto = ?");
            $stmt->execute([$id]);
            $produto_antigo = $stmt->fetch(PDO::FETCH_ASSOC);
            $foto_antiga = $produto_antigo['foto'] ?? null;
            
            $upload = self::handleImageUpload($file['nova_foto_produto'] ?? [], $foto_antiga);
            $novo_nome_imagem = $upload['nome'];
            $erro_upload = $upload['erro'];

            $sql = "UPDATE estoque SET nome_produto = ?, fk_id_categoria = ?, quantidade = ?, preco_custo = ?, preco_venda = ?, status = ?, descricao = ?";
            $params = [$data['nome'], (int)$data['categoria_id'], (int)$data['quantidade'], $preco_custo, $preco_venda, $data['status'], $data['descricao']];

            if ($novo_nome_imagem) {
                $sql .= ", foto = ?";
                $params[] = $novo_nome_imagem;
            }

            $sql .= " WHERE id_produto = ?";
            $params[] = $id;

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            $mensagem = "Produto atualizado com sucesso!";
            if (!empty($erro_upload)) {
                $mensagem = "Erro na imagem ao atualizar: $erro_upload";
                return ['success' => false, 'message' => $mensagem, 'redirect' => $redirect];
            }

            return ['success' => true, 'message' => $mensagem, 'redirect' => $redirect];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao editar: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }
    
    public static function excluirProduto(int $id): array {
        $redirect = '../admin/produtos.php';
        try {
            $pdo = self::getPdo();

            $stmt = $pdo->prepare("SELECT foto FROM estoque WHERE id_produto = ?");
            $stmt->execute([$id]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $pdo->prepare("DELETE FROM estoque WHERE id_produto = ?");
            $stmt->execute([$id]);

            if ($produto && !empty($produto['foto']) && $produto['foto'] != 'padrao.png') {
                $caminho_foto = dirname(__DIR__) . "/admin/img/produtos/" . $produto['foto'];
                if (file_exists($caminho_foto)) {
                    unlink($caminho_foto); 
                }
            }

            return ['success' => true, 'message' => 'Produto excluído com sucesso!', 'redirect' => $redirect];

        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                return ['success' => false, 'message' => 'Não é possível excluir: Este produto já possui vendas registradas. Mude o status para "Descontinuado".', 'redirect' => $redirect];
            } else {
                return ['success' => false, 'message' => 'Erro ao excluir: ' . $e->getMessage(), 'redirect' => $redirect];
            }
        }
    }
    
    public static function editarCliente(array $data): array {
        $redirect = '../admin/clientes.php';
        try {
            $pdo = self::getPdo();

            $sql = "UPDATE cliente SET 
                        nome = ?, email = ?, telefone = ?, cpf = ?, cep = ?, 
                        endereco = ?, numero = ?, bairro = ?, cidade = ?, estado = ? 
                    WHERE id_cliente = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $data['nome'], $data['email'], $data['telefone'], $data['cpf'], $data['cep'], 
                $data['endereco'], $data['numero'], $data['bairro'], $data['cidade'], $data['estado'], 
                $data['id_cliente']
            ]);

            return ['success' => true, 'message' => 'Cliente atualizado com sucesso!', 'redirect' => $redirect];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao atualizar cliente: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }
    
    public static function excluirCliente(int $id): array {
        $redirect = '../admin/clientes.php';
        try {
            $pdo = self::getPdo();
            
            $sql = "DELETE FROM cliente WHERE id_cliente = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            return ['success' => true, 'message' => 'Cliente excluído com sucesso.', 'redirect' => $redirect];

        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                 return ['success' => false, 'message' => 'Não é possível excluir: Este cliente possui registros associados (vendas, etc).', 'redirect' => $redirect];
            }
            return ['success' => false, 'message' => 'Erro ao excluir cliente: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }
    
    public static function buscarClientes(string $termo = ''): array {
        try {
            $pdo = self::getPdo();
            
            if (!empty($termo)) {
                $sql = "SELECT * FROM cliente 
                        WHERE nome LIKE :termo 
                           OR email LIKE :termo 
                           OR cpf LIKE :termo
                        ORDER BY nome ASC";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':termo', "%$termo%");
                $stmt->execute();
            } else {
                $sql = "SELECT * FROM cliente ORDER BY nome ASC";
                $stmt = $pdo->query($sql);
            }
            
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return ['success' => true, 'data' => $clientes];

        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function buscarOrdens(string $termo = ''): array {
        try {
            $pdo = self::getPdo();

            $sql = "SELECT o.*, c.nome AS nome_cliente 
                    FROM ordem_servico os
                    INNER JOIN cliente c ON o.fk_cliente_id_cliente = c.id_cliente";
            
            if (!empty($termo)) {
                $sql .= " WHERE o.titulo LIKE :t OR c.nome LIKE :t";
            }
            
            $sql .= " ORDER BY o.prazo ASC";

            $stmt = $pdo->prepare($sql);
            if (!empty($termo)) $stmt->bindValue(':t', "%$termo%");
            $stmt->execute();

            return ['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function salvarOrdem(array $data): array {
        $redirect = '../admin/servicos.php'; 
        try {
            $pdo = self::getPdo();

            if (empty($data['titulo']) || empty($data['id_cliente']) || empty($data['prazo'])) {
                return ['success' => false, 'message' => 'Preencha todos os campos obrigatórios!', 'redirect' => $redirect];
            }

            $sql = "INSERT INTO ordem_servico (titulo, fk_cliente_id_cliente, prazo, status) 
                    VALUES (?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $data['titulo'],
                (int)$data['id_cliente'],
                $data['prazo'],
                $data['status']
            ]);

            return ['success' => true, 'message' => 'Ordem de serviço criada com sucesso!', 'redirect' => $redirect];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao criar ordem: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }

    public static function editarOrdem(array $data): array {
        $redirect = '../admin/servicos.php';
        try {
            $pdo = self::getPdo();
            
            $sql = "UPDATE ordem_servico SET titulo = ?, fk_cliente_id_cliente = ?, prazo = ?, status = ? 
                    WHERE id_ordem = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $data['titulo'],
                (int)$data['id_cliente'],
                $data['prazo'],
                $data['status'],
                (int)$data['id_ordem']
            ]);

            return ['success' => true, 'message' => 'Ordem de serviço atualizada!', 'redirect' => $redirect];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao editar: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }

    public static function excluirOrdem(int $id): array {
        $redirect = '../admin/servicos.php';
        try {
            $pdo = self::getPdo();
            
            $stmt = $pdo->prepare("DELETE FROM ordem_servico WHERE id_ordem = ?");
            $stmt->execute([$id]);

            return ['success' => true, 'message' => 'Ordem de serviço excluída.', 'redirect' => $redirect];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao excluir: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }

    public static function buscarDadosAdmin(int $id): array {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare("SELECT nome, email FROM adm WHERE id_adm = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    public static function atualizarPerfil(array $data, int $id_adm): array {
        $redirect = '../admin/perfil.php';
        
        try {
            $pdo = self::getPdo();
            
            $nome = trim($data['nome']);
            $email = trim($data['email']);
            $senha = $data['senha'] ?? '';
            $confirmar = $data['confirmar_senha'] ?? '';

            if (empty($nome) || empty($email)) {
                return ['success' => false, 'message' => 'Nome e Email são obrigatórios.', 'redirect' => $redirect];
            }

            if (!empty($senha)) {
                if (isset($data['confirmar_senha']) && $senha !== $confirmar) {
                    return ['success' => false, 'message' => 'As senhas não coincidem!', 'redirect' => $redirect];
                }

                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("UPDATE adm SET nome = ?, email = ?, senha = ? WHERE id_adm = ?");
                $stmt->execute([$nome, $email, $senhaHash, $id_adm]);
            } else {
                $stmt = $pdo->prepare("UPDATE adm SET nome = ?, email = ? WHERE id_adm = ?");
                $stmt->execute([$nome, $email, $id_adm]);
            }

            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['usuario_nome'] = $nome;

            return ['success' => true, 'message' => 'Perfil atualizado com sucesso!', 'redirect' => $redirect];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erro ao atualizar: ' . $e->getMessage(), 'redirect' => $redirect];
        }
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['action']) && $_GET['action'] == 'busca_cliente')) {
    
    $action = $_REQUEST['action'] ?? '';
    $result = null;

    if ($action === 'busca_cliente') {
        header('Content-Type: application/json');
        $termo = $_GET['termo'] ?? '';
        $result = Admin::buscarClientes($termo);
        if ($result['success']) {
            echo json_encode($result['data']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => $result['message']]);
        }
        exit;
    }

    switch ($action) {
        case 'salvar_categoria':
            $result = Admin::salvarCategoria($_POST['nome_categoria'] ?? '');
            break;
        
        case 'salvar_produto':
            $result = Admin::salvarProduto($_POST, $_FILES);
            break;

        case 'editar_produto':
            $result = Admin::editarProduto($_POST, $_FILES);
            break;

        case 'excluir_produto':
            $id = (int)($_POST['id'] ?? 0);
            $result = Admin::excluirProduto($id);
            break;
            
        case 'editar_cliente':
            $result = Admin::editarCliente($_POST);
            break;
            
        case 'excluir_cliente':
            $id = (int)($_POST['id_cliente'] ?? 0);
            $result = Admin::excluirCliente($id);
            break;

        case 'salvar_ordem':
            $result = Admin::salvarOrdem($_POST);
            break;
        
        case 'editar_ordem':
            $result = Admin::editarOrdem($_POST);
            break;

        case 'excluir_ordem':
            $id = (int)($_POST['id_ordem'] ?? 0);
            $result = Admin::excluirOrdem($id);
            break;

            case 'atualizar_perfil':
            $id_adm = $_SESSION['usuario_id'] ?? 0;
            $result = Admin::atualizarPerfil($_POST, $id_adm);
            break;

        default:
            $result = ['success' => false, 'message' => 'Ação inválida.', 'redirect' => '../admin/dashboard.php'];
            break;
    }
    
    if ($result) {
        $_SESSION['alert'] = [
            'icon'    => $result['success'] ? 'success' : 'error',
            'title'   => $result['success'] ? 'Sucesso!' : 'Atenção!',
            'message' => $result['message']
        ];
        
        $url = $result['redirect'] ?? '../admin/dashboard.php';
        header("Location: " . $url);
        exit;
    }

    
}



?>