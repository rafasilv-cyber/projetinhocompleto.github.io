<?php
    // Espera receber (opcionalmente):
    // $activeMenu   -> 'dashboard' | 'chamados' | 'categorias' | 'usuarios'
    // $pageTitle    -> título exibido no topo do conteúdo (H1)
    // $pageSubtitle -> linha de apoio abaixo do H1
    $activeMenu = $activeMenu ?? '';
?>
<div class="app-shell">

    <aside class="sidebar">
        <div class="sidebar-brand">
            <span class="brand-mark">HD</span>
            <div class="brand-text">
                <strong>HelpDesk</strong>
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
            <a href="#" class="nav-link is-disabled" title="Ainda não implementado neste projeto">
                <span class="nav-icon">&#9881;</span> <span>Configurações</span>
            </a>
        </nav>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-search">
                <span>&#8981;</span>
                <input type="text" placeholder="Pesquisar chamados, categorias...">
            </div>
            <div class="topbar-actions">
                <button class="icon-btn" type="button" aria-label="Notificações">&#128276;</button>
                <div class="user-chip">
                    <span class="user-avatar"><img src="img/nerdi.png" alt="Avatar do usuário"></span>
                    <div class="user-meta">
                        <strong>Admin</strong>
                        <span>Administrador</span>
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
