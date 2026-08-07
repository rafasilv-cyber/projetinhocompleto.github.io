<?php

class ConfiguracaoController
{
    private $configuracaoModel;

    public function __construct()
    {
        $this->configuracaoModel = new ConfiguracaoModel();
    }

    public function index()
    {
        $config = $this->configuracaoModel->obterTodas();
        require_once VIEW_PATH . '/configuracoes/index.php';
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=configuracao/index');
            exit;
        }

        $nomeSistema  = trim($_POST['nome_sistema'] ?? '');
        $adminNome    = trim($_POST['admin_nome'] ?? '');
        $adminCargo   = trim($_POST['admin_cargo'] ?? '');
        $limitePadrao = $_POST['limite_padrao_dashboard'] ?? '5';

        if (empty($nomeSistema) || empty($adminNome) || empty($adminCargo)) {
            $_SESSION['erro'] = 'Preencha todos os campos obrigatórios!';
            header('Location: ?url=configuracao/index');
            exit;
        }

        if (!in_array($limitePadrao, ['5', '10', '20'], true)) {
            $limitePadrao = '5';
        }

        $this->configuracaoModel->salvar('nome_sistema', $nomeSistema);
        $this->configuracaoModel->salvar('admin_nome', $adminNome);
        $this->configuracaoModel->salvar('admin_cargo', $adminCargo);
        $this->configuracaoModel->salvar('limite_padrao_dashboard', $limitePadrao);

        $_SESSION['sucesso'] = 'Configurações atualizadas com sucesso!';
        header('Location: ?url=configuracao/index');
        exit;
    }
}