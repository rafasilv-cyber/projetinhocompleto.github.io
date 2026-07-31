<?php

class UsuarioController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $usuarios = $this->usuarioModel->listarTodos();
        require_once VIEW_PATH . '/usuarios/index.php';
    }

    public function criar()
    {
        require_once VIEW_PATH . '/usuarios/criar.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome  = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';

            if (empty($nome) || empty($email) || empty($senha)) {
                $_SESSION['erro'] = 'Preencha todos os campos!';
                header('Location: /usuario/criar');
                exit;
            }

            $this->usuarioModel->cadastrar(['nome' => $nome, 'email' => $email, 'senha' => $senha]);
            $_SESSION['sucesso'] = 'Usuário cadastrado com sucesso!';
            header('Location: projetinhocompleto.github.io/public/index.php?url=usuario/index');
            exit;
        }
    }

    public function editar($id = null)
    {
        if (!$id) { header('Location: /usuario/index'); exit; }
        $usuario = $this->usuarioModel->buscarPorId((int)$id);
        require_once VIEW_PATH . '/usuarios/editar.php';
    }

    public function atualizar($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $nome  = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';

            if (empty($nome) || empty($email)) {
                $_SESSION['erro'] = 'Nome e e-mail são obrigatórios!';
                header("Location: /usuario/editar/{$id}");
                exit;
            }

            $this->usuarioModel->atualizar([
                'id'    => (int)$id,
                'nome'  => $nome,
                'email' => $email,
                'senha' => $senha
            ]);

            $_SESSION['sucesso'] = 'Usuário atualizado com sucesso!';
            header('Location: /usuario/index');
            exit;
        }
    }

    public function excluir($id = null)
    {
        if ($id) {
            $this->usuarioModel->deletar((int)$id);
            $_SESSION['sucesso'] = 'Usuário excluído!';
        }
        header('Location: /usuario/index');
        exit;
    }
}