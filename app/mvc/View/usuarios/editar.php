<?php
    $htmlTitle    = 'Editar usuário';
    $activeMenu   = 'usuarios';
    $pageTitle    = 'Editar usuário';
    $pageSubtitle = 'Atualize os dados do usuário #' . $usuario['id'];
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
?>

<div class="form-card">
    <div class="form-card-head">
        <div class="stat-icon" style="--stat-color: var(--amber); --stat-bg: var(--amber-soft);">&#9998;</div>
        <h3>Editar usuário #<?= $usuario['id']; ?></h3>
    </div>
    <form class="form-card-body" action="?url=usuario/atualizar/<?= $usuario['id']; ?>" method="POST">
        <div class="field">
            <label for="nome">Nome completo *</label>
            <input type="text" id="nome" name="nome" class="input" value="<?= htmlspecialchars($usuario['nome'] ?? ''); ?>" required>
        </div>
        <div class="field">
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" class="input" value="<?= htmlspecialchars($usuario['email'] ?? ''); ?>" required>
        </div>
        <div class="field">
            <label for="senha">Nova senha</label>
            <input type="password" id="senha" name="senha" class="input" placeholder="Deixe em branco para manter a atual">
            <span class="hint">Preencha apenas se desejar redefinir a senha deste usuário.</span>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Atualizar dados</button>
            <a href="?url=usuario/index" class="btn btn-outline btn-block">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
