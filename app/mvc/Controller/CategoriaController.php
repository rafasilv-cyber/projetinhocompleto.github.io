<?php

class CategoriaController
{
    private $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        $categorias = $this->categoriaModel->listarTodas();
        require_once VIEW_PATH . '/categorias/index.php';
    }

    public function criar()
    {
        require_once VIEW_PATH . '/categorias/criar.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');

            if (empty($nome)) {
                $_SESSION['erro'] = 'O nome da categoria é obrigatório!';
                header('Location: /categoria/criar');
                exit;
            }

            $this->categoriaModel->cadastrar(['nome' => $nome, 'descricao' => $descricao]);
            $_SESSION['sucesso'] = 'Categoria cadastrada com sucesso!';
            header('Location: /categoria/index');

            // Redireciona para o Dashboard (home)
    header("Location: /projetinhocompleto.github.io/public/index.php?url=home");
    exit;
}
     
        
    }

    public function editar($id = null)
    {
        if (!$id) { header('Location: /categoria/index'); exit; }
        $categoria = $this->categoriaModel->buscarPorId((int)$id);
        require_once VIEW_PATH . '/categorias/editar.php';
    }

    public function atualizar($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');

            if (empty($nome)) {
                $_SESSION['erro'] = 'O nome da categoria é obrigatório!';
                header("Location: /categoria/editar/{$id}");
                exit;
            }

            $this->categoriaModel->atualizar(['id' => (int)$id, 'nome' => $nome, 'descricao' => $descricao]);
            $_SESSION['sucesso'] = 'Categoria atualizada!';
            header('Location: /categoria/index');
            exit;
        }
    }

    public function excluir($id = null)
    {
        if ($id) {
            try {
                $this->categoriaModel->deletar((int)$id);
                $_SESSION['sucesso'] = 'Categoria excluída!';
            } catch (Exception $e) {
                $_SESSION['erro'] = 'Não é possível excluir categorias com chamados vinculados.';
            }
        }
        header('Location: /categoria/index');
        exit;
    }
}