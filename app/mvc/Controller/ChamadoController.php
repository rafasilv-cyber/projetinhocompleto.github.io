<?php

class ChamadoController
{
    private $chamadoModel;
    private $categoriaModel;

    public function __construct()
    {
        // Instancia as Models para consultar o banco de dados
        $this->chamadoModel = new ChamadoModel();
        $this->categoriaModel = new CategoriaModel();
    }

    /**
     * RF02 - Listar chamados
     * RF05 - Pesquisa por palavra-chave
     * URL: /chamado/index (ou /chamado)
     */
    public function index()
    {
        $termoBusca = $_GET['busca'] ?? null;

        // Se houver busca, filtra; senão, traz todos
        if ($termoBusca) {
            $chamados = $this->chamadoModel->pesquisar($termoBusca);
        } else {
            $chamados = $this->chamadoModel->listarTodos();
        }

        // Renderiza a tela de listagem
        require_once VIEW_PATH . '/chamados/index.php';
    }

    /**
     * Exibir o formulário de novo chamado
     * URL: /chamado/criar
     */
    public function criar()
    {
        // Busca as categorias para preencher o <select> da View
        $categorias = $this->categoriaModel->listarTodas();
        
        require_once VIEW_PATH . '/chamados/criar.php';
    }

    /**
     * RF02 - Cadastrar chamado
     * Recebe os dados via formulário POST
     */
    public function salvar()
    {
        // Pega os dados do formulário
    $titulo = $_POST['titulo'];
    $categoria_id = $_POST['categoria_id'];
    $prioridade = $_POST['prioridade'];
    $descricao = $_POST['descricao'];

    // Força temporariamente o ID do usuário como 1 (já que não temos login pronto)
    $usuario_id = 1; 

    // Chama o Model para salvar, passando o usuario_id
    $this->chamadoModel->salvar($titulo, $descricao, $categoria_id, $usuario_id, $prioridade);

    // Redireciona de volta para a lista (lembre-se do caminho absoluto com ?url=)
    header("Location: /PROJETINHOCOMPLETO.GITHUB.IO/public/index.php?url=chamado/index");
    exit;
    }

    /**
     * Exibir formulário de edição com os dados do chamado
     * URL: /chamado/editar/5
     */
    public function editar($id = null)
    {
        if (!$id) {
            header('Location: /chamado/index');
            exit;
        }

        $chamado = $this->chamadoModel->buscarPorId((int)$id);
        $categorias = $this->categoriaModel->listarTodas();

        if (!$chamado) {
            $_SESSION['erro'] = 'Chamado não encontrado!';
            header('Location: /chamado/index');
            exit;
        }

        require_once VIEW_PATH . '/chamados/editar.php';
    }

    /**
     * RF02 - Editar chamado (Salvar alterações no banco)
     */
    public function atualizar($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $dados = [
                'id'           => (int)$id,
                'titulo'       => trim($_POST['titulo'] ?? ''),
                'descricao'    => trim($_POST['descricao'] ?? ''),
                'status'       => $_POST['status'] ?? 'aberto',
                'prioridade'   => $_POST['prioridade'] ?? 'media',
                'categoria_id' => $_POST['categoria_id'] ?? null,
            ];

            if (empty($dados['titulo']) || empty($dados['descricao'])) {
                $_SESSION['erro'] = 'Preencha todos os campos obrigatórios!';
                header("Location: /chamado/editar/{$id}");
                exit;
            }

            $this->chamadoModel->atualizar($dados);
            $_SESSION['sucesso'] = 'Chamado atualizado com sucesso!';
            header('Location: /chamado/index');
            exit;
        }
    }

    /**
     * RF02 - Excluir chamado
     * URL: /chamado/excluir/5
     */
    public function excluir($id = null)
    {
        if ($id) {
            $this->chamadoModel->deletar((int)$id);
            $_SESSION['sucesso'] = 'Chamado excluído com sucesso!';
        }

        header('Location: /chamado/index');
        exit;
    }
}