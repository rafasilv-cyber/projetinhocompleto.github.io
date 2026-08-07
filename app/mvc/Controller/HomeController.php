<?php

class HomeController
{
    private $homeModel;

    public function __construct()
    {
        $this->homeModel = new HomeModel();
    }

    public function index()
    {
        // Limite de linhas em "Últimos chamados": usa o valor configurado em
        // Configurações como padrão, mas o seletor da própria tela pode sobrepor.
        $configuracaoModel = new ConfiguracaoModel();
        $limitePadrao = (int) $configuracaoModel->obter('limite_padrao_dashboard', '5');
        if (!in_array($limitePadrao, [5, 10, 20], true)) {
            $limitePadrao = 5;
        }

        $limite = (int)($_GET['limite'] ?? $limitePadrao);
        if (!in_array($limite, [5, 10, 20], true)) {
            $limite = $limitePadrao;
        }

        // Coleta todos os dados para o Dashboard (RF04)
        $totais                = $this->homeModel->getTotais();
        $chamadosPorCategoria  = $this->homeModel->getChamadosPorCategoria();
        $chamadosPorPrioridade = $this->homeModel->getChamadosPorPrioridade();
        $ultimosChamados       = $this->homeModel->getUltimosChamados($limite);
        $limiteAtual            = $limite;

        // Envia os dados para a View do Dashboard
        require_once VIEW_PATH . '/home/dashboard.php';
    }
}