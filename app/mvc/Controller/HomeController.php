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
        // Coleta todos os dados para o Dashboard (RF04)
        $totais               = $this->homeModel->getTotais();
        $chamadosPorCategoria = $this->homeModel->getChamadosPorCategoria();
        $chamadosPorPrioridade = $this->homeModel->getChamadosPorPrioridade();
        $ultimosChamados      = $this->homeModel->getUltimosChamados(5);

        // Envia os dados para a View do Dashboard
        require_once VIEW_PATH . '/home/dashboard.php';
    }
}
