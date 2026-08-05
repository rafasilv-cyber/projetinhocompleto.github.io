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

        if (!empty($nome)) {
            $this->categoriaModel->cadastrar($nome, $descricao);
            $_SESSION['sucesso'] = "Categoria cadastrada com sucesso!";
        } else {
            $_SESSION['erro'] = "O nome da categoria é obrigatório!";
        }

        header("Location: ?url=categoria/index");
        exit;
    }
}

   public function editar($id = null)
{
    if (!$id) {
        header("Location: ?url=categoria/index");
        exit;
    }
    $categoria = $this->categoriaModel->buscarPorId((int)$id);
    require_once VIEW_PATH . '/categorias/editar.php';
}

public function atualizar($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');

        $this->categoriaModel->atualizar($id, $nome, $descricao);

        $_SESSION['sucesso'] = "Categoria atualizada com sucesso!";
        header("Location: ?url=categoria/index");
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