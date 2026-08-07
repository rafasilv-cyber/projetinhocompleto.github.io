<?php
    // Espera receber (opcionalmente):
    // $activeMenu   -> 'dashboard' | 'chamados' | 'categorias' | 'usuarios'
    // $pageTitle    -> título exibido no topo do conteúdo (H1)
    // $pageSubtitle -> linha de apoio abaixo do H1
    $activeMenu = $activeMenu ?? '';

    // Reaproveita $configSistema já buscado pelo partials/head.php nesta mesma
    // requisição. Fallback de segurança caso esta view não tenha passado por lá.
    if (!isset($configSistema)) {
        $configuracaoModel = new ConfiguracaoModel();
        $configSistema = $configuracaoModel->obterTodas();
    }
    $nomeSistema = $configSistema['nome_sistema'] ?? 'HelpDesk';
    $adminNome   = $configSistema['admin_nome'] ?? 'Admin';
    $adminCargo  = $configSistema['admin_cargo'] ?? 'Administrador';
    $inicialAdmin = mb_strtoupper(mb_substr($adminNome, 0, 1));

    // Dados reais do sino de notificações (tabela `notificacoes`)
    $notificacaoModel = new NotificacaoModel();
    $notificacoesRecentes = $notificacaoModel->listarRecentes(6);
    $notificacoesNaoLidas = $notificacaoModel->contarNaoLidas();
?>
<div class="app-shell">

    <aside class="sidebar">
        <div class="sidebar-brand">
            <img class="brand-logo" src="img/helpdesk-logo.png" alt="<?= htmlspecialchars($nomeSistema) ?>">
            <div class="brand-text">
                <strong><?= htmlspecialchars($nomeSistema) ?></strong>
                <span>Sistema de Chamados</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="?url=home" class="nav-link <?= $activeMenu === 'dashboard' ? 'is-active' : '' ?>">
                <span class="nav-icon">&#9635;</span> <span>Dashboard</span>
            </a>

            <span class="nav-section">Gerenciamento</span>
            <a href="?url=chamado/index" class="nav-link <?= $activeMenu === 'chamados' ? 'is-active' : '' ?>">
                <span class="nav-icon">&#9673;</span> <span>Chamados</span>
            </a>
            <a href="?url=categoria/index" class="nav-link <?= $activeMenu === 'categorias' ? 'is-active' : '' ?>">
                <span class="nav-icon">&#9636;</span> <span>Categorias</span>
            </a>
            <a href="?url=usuario/index" class="nav-link <?= $activeMenu === 'usuarios' ? 'is-active' : '' ?>">
                <span class="nav-icon">&#9679;</span> <span>Usuários</span>
            </a>

            <span class="nav-section">Sistema</span>
            <a href="?url=configuracao/index" class="nav-link <?= $activeMenu === 'configuracoes' ? 'is-active' : '' ?>">
                <span class="nav-icon">&#9881;</span> <span>Configurações</span>
            </a>
        </nav>
    </aside>

    <div class="main">
        <header class="topbar">
            <form class="topbar-search" action="" method="GET">
                <span>&#8981;</span>
                <input type="hidden" name="url" value="chamado/index">
                <input type="text" name="busca" placeholder="Pesquisar chamados por título ou descrição..."
                       value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
            </form>

            <div class="topbar-actions">
                <details class="notif-dropdown">
                    <summary class="icon-btn" aria-label="Notificações">
                        &#128276;
                        <?php if ($notificacoesNaoLidas > 0): ?>
                            <span class="notif-badge"><?= $notificacoesNaoLidas > 9 ? '9+' : $notificacoesNaoLidas ?></span>
                        <?php endif; ?>
                    </summary>
                    <div class="notif-panel">
                        <div class="notif-panel-head">
                            <strong>Notificações</strong>
                            <?php if ($notificacoesNaoLidas > 0): ?>
                                <a href="?url=notificacao/marcarTodasLidas">Marcar todas como lidas</a>
                            <?php endif; ?>
                        </div>
                        <div class="notif-list">
                            <?php if (!empty($notificacoesRecentes)): ?>
                                <?php foreach ($notificacoesRecentes as $n): ?>
                                    <a href="?url=notificacao/marcarLida/<?= $n['id'] ?>" class="notif-item <?= !$n['lida'] ? 'is-unread' : '' ?>">
                                        <span class="notif-dot"></span>
                                        <div>
                                            <p><?= htmlspecialchars($n['mensagem']) ?></p>
                                            <span class="notif-time"><?= date('d/m \à\s H:i', strtotime($n['created_at'])) ?></span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="notif-empty">Nenhuma notificação ainda.<br>Elas aparecem aqui quando um chamado é aberto ou muda de status.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </details>

                <div class="user-chip">
                    <img class="user-avatar" src="img/nerdi-profile.png" alt="Foto de perfil de <?= htmlspecialchars($adminNome) ?>">
                    <div class="user-meta">
                        <strong><?= htmlspecialchars($adminNome) ?></strong>
                        <span><?= htmlspecialchars($adminCargo) ?></span>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            <?php if (!empty($pageTitle)): ?>
                <div class="page-head">
                    <h1><?= htmlspecialchars($pageTitle) ?></h1>
                    <?php if (!empty($pageSubtitle)): ?><p><?= htmlspecialchars($pageSubtitle) ?></p><?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['sucesso'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['sucesso']); unset($_SESSION['sucesso']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['erro'])): ?>
                <div class="alert alert-error"><?= htmlspecialchars($_SESSION['erro']); unset($_SESSION['erro']); ?></div>
            <?php endif; ?>
