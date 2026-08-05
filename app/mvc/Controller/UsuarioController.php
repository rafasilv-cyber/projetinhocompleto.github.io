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
            header("Location: ?url=modulo/acao");
            exit;
        }
    }

    public function editar($id = null)
    {
        if (!$id) { header('Location: /usuario/index'); exit; }
        $usuario = $this->usuarioModel->buscarPorId((int)$id);
        require_once VIEW_PATH . '/usuarios/editar.php';
    }

    public function atualizar($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome  = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        // LINHA 63: Passe as 4 variáveis separadas por vírgula nesta ordem exata
        $this->usuarioModel->atualizar($id, $nome, $email, $senha);

        // Redireciona para a lista
        header("Location: ?url=usuario/index");
        exit;
    }
}

public function excluir($id = null)
{
    if (!$id) {
        header("Location: ?url=usuario/index");
        exit;
    }

    $this->usuarioModel->excluir((int)$id);
    header("Location: ?url=usuario/index");
    exit;
}
}