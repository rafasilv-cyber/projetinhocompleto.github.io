<?php
    $htmlTitle    = 'Configurações';
    $activeMenu   = 'configuracoes';
    $pageTitle    = 'Configurações';
    $pageSubtitle = 'Preferências gerais do sistema';
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';

    $limiteAtual = $config['limite_padrao_dashboard'] ?? '5';
?>

<div class="form-card" style="max-width: 560px;">
    <div class="form-card-head">
        <div class="stat-icon" style="--stat-color: var(--accent); --stat-bg: var(--accent-soft);">&#9881;</div>
        <h3>Preferências gerais</h3>
    </div>
    <form class="form-card-body" action="?url=configuracao/salvar" method="POST">

        <div class="field">
            <label for="nome_sistema">Nome do sistema</label>
            <input type="text" id="nome_sistema" name="nome_sistema" class="input"
                   value="<?= htmlspecialchars($config['nome_sistema'] ?? 'HelpDesk') ?>" required>
            <span class="hint">Aparece na barra lateral e na aba do navegador.</span>
        </div>

        <div class="field">
            <label for="admin_nome">Nome exibido no topo (canto direito)</label>
            <input type="text" id="admin_nome" name="admin_nome" class="input"
                   value="<?= htmlspecialchars($config['admin_nome'] ?? 'Admin') ?>" required>
        </div>

        <div class="field">
            <label for="admin_cargo">Cargo / função exibido junto ao nome</label>
            <input type="text" id="admin_cargo" name="admin_cargo" class="input"
                   value="<?= htmlspecialchars($config['admin_cargo'] ?? 'Administrador') ?>" required>
            <span class="hint">
                O sistema ainda não tem login — esse é um texto fixo de exibição,
                não uma conta de usuário de verdade.
            </span>
        </div>

        <div class="field">
            <label for="limite_padrao_dashboard">Chamados exibidos por padrão no dashboard</label>
            <select id="limite_padrao_dashboard" name="limite_padrao_dashboard" class="select">
                <option value="5" <?= $limiteAtual == '5' ? 'selected' : '' ?>>5</option>
                <option value="10" <?= $limiteAtual == '10' ? 'selected' : '' ?>>10</option>
                <option value="20" <?= $limiteAtual == '20' ? 'selected' : '' ?>>20</option>
            </select>
            <span class="hint">Você ainda pode trocar isso manualmente no seletor do próprio dashboard — aqui é só o valor inicial.</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Salvar configurações</button>
            <a href="?url=home" class="btn btn-outline btn-block">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
