<?php
    $htmlTitle    = 'Novo usuário';
    $activeMenu   = 'usuarios';
    $pageTitle    = 'Novo usuário';
    $pageSubtitle = 'Cadastre uma nova pessoa com acesso ao sistema';
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
?>

<div class="form-card">
    <div class="form-card-head">
        <div class="stat-icon" style="--stat-color: var(--accent); --stat-bg: var(--accent-soft);">&#9679;</div>
        <h3>Cadastrar novo usuário</h3>
    </div>
    <form class="form-card-body" action="?url=usuario/salvar" method="POST">
        <div class="field">
            <label for="nome">Nome completo *</label>
            <input type="text" id="nome" name="nome" class="input" placeholder="Ex: João da Silva" required>
        </div>
        <div class="field">
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" class="input" placeholder="joao@empresa.com.br" required>
        </div>
        <div class="field">
            <label for="senha">Senha de acesso *</label>
            <input type="password" id="senha" name="senha" class="input" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Salvar usuário</button>
            <a href="?url=usuario/index" class="btn btn-outline btn-block">Cancelar e voltar</a>
        </div>
    </form>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
