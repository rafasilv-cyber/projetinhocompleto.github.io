<?php
    $htmlTitle    = 'Editar categoria';
    $activeMenu   = 'categorias';
    $pageTitle    = 'Editar categoria';
    $pageSubtitle = 'Atualize os dados da categoria #' . $categoria['id'];
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
?>

<div class="form-card">
    <div class="form-card-head">
        <div class="stat-icon" style="--stat-color: var(--amber); --stat-bg: var(--amber-soft);">&#9998;</div>
        <h3>Editar categoria #<?= $categoria['id'] ?></h3>
    </div>
    <form class="form-card-body" action="?url=categoria/atualizar/<?= $categoria['id']; ?>" method="POST">
        <div class="field">
            <label for="nome">Nome da categoria *</label>
            <input type="text" id="nome" name="nome" class="input" value="<?= htmlspecialchars($categoria['nome']) ?>" required>
        </div>
        <div class="field">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" class="textarea" rows="3"><?= htmlspecialchars($categoria['descricao'] ?? '') ?></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Atualizar categoria</button>
            <a href="?url=categoria/index" class="btn btn-outline btn-block">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
