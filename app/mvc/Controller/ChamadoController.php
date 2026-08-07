<?php

class ChamadoController
{
    private $chamadoModel;
    private $categoriaModel;
    private $notificacaoModel;

    public function __construct()
    {
        $this->chamadoModel = new ChamadoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->notificacaoModel = new NotificacaoModel();
    }

    /**
     * RF02 - Listar chamados
     * RF05 - Pesquisa por palavra-chave
     * Também aceita ?status=aberto|em_andamento|resolvido|cancelado — usado
     * pelos cards clicáveis do dashboard para já chegar filtrado.
     * URL: /chamado/index (ou /chamado)
     */
    public function index()
    {
        $termoBusca = $_GET['busca'] ?? null;
        $statusFiltro = $_GET['status'] ?? null;

        if ($termoBusca) {
            $chamados = $this->chamadoModel->pesquisar($termoBusca);
        } elseif ($statusFiltro) {
            $chamados = $this->chamadoModel->listarPorStatus($statusFiltro);
        } else {
            $chamados = $this->chamadoModel->listarTodos();
        }

        require_once VIEW_PATH . '/chamados/index.php';
    }

    /**
     * Exibir o formulário de novo chamado
     * URL: /chamado/criar
     */
    public function criar()
    {
        $categorias = $this->categoriaModel->listarTodas();
        require_once VIEW_PATH . '/chamados/criar.php';
    }

    /**
     * RF02 - Cadastrar chamado
     */
    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=chamado/criar');
            exit;
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $categoria_id = $_POST['categoria_id'] ?? '';
        $prioridade = $_POST['prioridade'] ?? 'media';
        $descricao = trim($_POST['descricao'] ?? '');

        if (empty($titulo) || empty($categoria_id) || empty($descricao)) {
            $_SESSION['erro'] = 'Preencha todos os campos obrigatórios!';
            header('Location: ?url=chamado/criar');
            exit;
        }

        // Enquanto não existe login: busca o primeiro usuário cadastrado no sistema
        $usuarioModel = new UsuarioModel();
        $usuariosExistentes = $usuarioModel->listarTodos();

        if (empty($usuariosExistentes)) {
            $_SESSION['erro'] = 'Nenhum usuário cadastrado no sistema. Cadastre um usuário antes de abrir chamados.';
            header('Location: ?url=usuario/criar');
            exit;
        }

        $usuario_id = $usuariosExistentes[0]['id'];

        $novoId = $this->chamadoModel->salvar($titulo, $descricao, $categoria_id, $usuario_id, $prioridade);

        if ($novoId > 0) {
            $this->notificacaoModel->criar('novo_chamado', "Novo chamado aberto: \"{$titulo}\"", $novoId);
            $_SESSION['sucesso'] = 'Chamado aberto com sucesso!';
        } else {
            $_SESSION['erro'] = 'Não foi possível abrir o chamado. Tente novamente.';
        }

        header('Location: ?url=chamado/index');
        exit;
    }

    /**
     * Exibir formulário de edição com os dados do chamado
     * URL: /chamado/editar/5
     */
    public function editar($id = null)
    {
        if (!$id) {
            header('Location: ?url=chamado/index');
            exit;
        }

        $chamado = $this->chamadoModel->buscarPorId((int)$id);
        $categorias = $this->categoriaModel->listarTodas();

        if (!$chamado) {
            $_SESSION['erro'] = 'Chamado não encontrado!';
            header('Location: ?url=chamado/index');
            exit;
        }

        require_once VIEW_PATH . '/chamados/editar.php';
    }

    /**
     * RF02 - Editar chamado (Salvar alterações no banco)
     * Também dispara uma notificação quando o status muda.
     */
    public function atualizar($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $chamadoAntigo = $this->chamadoModel->buscarPorId((int)$id);

            $dados = [
                'id'           => (int)$id,
                'titulo'       => trim($_POST['titulo'] ?? ''),
                'descricao'    => trim($_POST['descricao'] ?? ''),
                'status'       => $_POST['status'] ?? 'aberto',
                'prioridade'   => $_POST['prioridade'] ?? 'media',
                'categoria_id' => $_POST['categoria_id'] ?? null,
            ];

            if (empty($dados['titulo']) || empty($dados['descricao']) || empty($dados['categoria_id'])) {
                $_SESSION['erro'] = 'Preencha todos os campos obrigatórios!';
                header("Location: ?url=chamado/editar/{$id}");
                exit;
            }

            $this->chamadoModel->atualizar($dados);

            if ($chamadoAntigo && $chamadoAntigo['status'] !== $dados['status']) {
                $labelStatus = str_replace('_', ' ', $dados['status']);
                $this->notificacaoModel->criar('status_alterado', "Chamado #{$id} agora está \"{$labelStatus}\"", (int)$id);
            }

            $_SESSION['sucesso'] = 'Chamado atualizado com sucesso!';
            header('Location: ?url=chamado/index');
            exit;
        }
    }

    /**
     * Ação rápida (sem abrir o formulário completo): marca o chamado como
     * resolvido direto pela listagem ou pelo dashboard.
     * URL: ?url=chamado/resolverRapido/5
     */
    public function resolverRapido($id = null)
    {
        if ($id) {
            $chamado = $this->chamadoModel->buscarPorId((int)$id);

            if ($chamado && $chamado['status'] !== 'resolvido') {
                $this->chamadoModel->atualizarStatus((int)$id, 'resolvido');
                $this->notificacaoModel->criar('status_alterado', "Chamado #{$id} agora está \"resolvido\"", (int)$id);
                $_SESSION['sucesso'] = "Chamado #{$id} marcado como resolvido!";
            }
        }

        $voltar = $_SERVER['HTTP_REFERER'] ?? '?url=chamado/index';
        header("Location: {$voltar}");
        exit;
    }

    /**
     * RF02 - Excluir chamado
     * URL: /chamado/excluir/5
     */
    public function excluir($id = null)
    {
        if ($id) {
            try {
                $this->chamadoModel->deletar((int)$id);
                $_SESSION['sucesso'] = 'Chamado excluído com sucesso!';
            } catch (Exception $e) {
                $_SESSION['erro'] = 'Não foi possível excluir o chamado.';
            }
        }
        header('Location: ?url=chamado/index');
        exit;
    }
}