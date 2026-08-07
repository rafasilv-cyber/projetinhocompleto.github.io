<?php

class NotificacaoController
{
    private $notificacaoModel;

    public function __construct()
    {
        $this->notificacaoModel = new NotificacaoModel();
    }

    /**
     * Marca uma notificação como lida e leva o usuário direto pro chamado
     * relacionado (se existir), já que é isso que ele provavelmente quer ver.
     * URL: ?url=notificacao/marcarLida/7
     */
    public function marcarLida($id = null)
    {
        if (!$id) {
            header('Location: ?url=home');
            exit;
        }

        $notificacao = $this->notificacaoModel->buscarPorId((int)$id);
        $this->notificacaoModel->marcarComoLida((int)$id);

        if (!empty($notificacao['chamado_id'])) {
            header("Location: ?url=chamado/editar/{$notificacao['chamado_id']}");
        } else {
            header('Location: ?url=home');
        }
        exit;
    }

    /**
     * URL: ?url=notificacao/marcarTodasLidas
     */
    public function marcarTodasLidas()
    {
        $this->notificacaoModel->marcarTodasComoLidas();
        $voltar = $_SERVER['HTTP_REFERER'] ?? '?url=home';
        header("Location: {$voltar}");
        exit;
    }
}