<?php
    $htmlTitle    = 'Editar chamado';
    $activeMenu   = 'chamados';
    $pageTitle    = 'Editar chamado';
    $pageSubtitle = 'Atualize os dados do chamado #' . $chamado['id'];
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
?>

<div class="form-card" style="max-width: 640px;">
    <div class="form-card-head">
        <div class="stat-icon" style="--stat-color: var(--amber); --stat-bg: var(--amber-soft);">&#9998;</div>
        <h3>Editar chamado #<?= $chamado['id'] ?></h3>
    </div>
    <form class="form-card-body" action="?url=chamado/atualizar/<?= $chamado['id'] ?>" method="POST">
        <div class="field">
            <label for="titulo">Título *</label>
            <input type="text" id="titulo" name="titulo" class="input" value="<?= htmlspecialchars($chamado['titulo']) ?>" required>
        </div>

        <div class="field">
            <label for="categoria_id">Categoria *</label>
            <select id="categoria_id" name="categoria_id" class="select" required>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $chamado['categoria_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label for="prioridade">Prioridade</label>
            <select id="prioridade" name="prioridade" class="select">
                <option value="baixa" <?= $chamado['prioridade'] == 'baixa' ? 'selected' : '' ?>>Baixa</option>
                <option value="media" <?= $chamado['prioridade'] == 'media' ? 'selected' : '' ?>>Média</option>
                <option value="alta" <?= $chamado['prioridade'] == 'alta' ? 'selected' : '' ?>>Alta</option>
                <option value="urgente" <?= $chamado['prioridade'] == 'urgente' ? 'selected' : '' ?>>Urgente</option>
            </select>
        </div>

        <div class="field">
            <label for="status">Status</label>
            <select id="status" name="status" class="select">
                <option value="aberto" <?= $chamado['status'] == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                <option value="em_andamento" <?= $chamado['status'] == 'em_andamento' ? 'selected' : '' ?>>Em andamento</option>
                <option value="resolvido" <?= $chamado['status'] == 'resolvido' ? 'selected' : '' ?>>Resolvido</option>
                <option value="cancelado" <?= $chamado['status'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
            </select>
        </div>

        <div class="field">
            <label for="descricao">Descrição *</label>
            <textarea id="descricao" name="descricao" class="textarea" rows="4" required><?= htmlspecialchars($chamado['descricao']) ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Atualizar chamado</button>
            <a href="?url=chamado/index" class="btn btn-outline btn-block">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
