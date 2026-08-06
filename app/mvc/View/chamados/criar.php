<?php
    $htmlTitle    = 'Novo chamado';
    $activeMenu   = 'chamados';
    $pageTitle    = 'Abrir novo chamado';
    $pageSubtitle = 'Descreva o problema para que a equipe possa atender';
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
?>

<div class="form-card" style="max-width: 640px;">
    <div class="form-card-head">
        <div class="stat-icon" style="--stat-color: var(--accent); --stat-bg: var(--accent-soft);">&#9673;</div>
        <h3>Abrir novo chamado</h3>
    </div>
    <form class="form-card-body" action="?url=chamado/salvar" method="POST">
        <div class="field">
            <label for="titulo">Título *</label>
            <input type="text" id="titulo" name="titulo" class="input" required>
        </div>

        <div class="field">
            <label for="categoria_id">Categoria *</label>
            <select id="categoria_id" name="categoria_id" class="select" required>
                <option value="">Selecione...</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="field">
            <label for="prioridade">Prioridade</label>
            <select id="prioridade" name="prioridade" class="select">
                <option value="baixa">Baixa</option>
                <option value="media" selected>Média</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
            </select>
        </div>

        <div class="field">
            <label for="descricao">Descrição *</label>
            <textarea id="descricao" name="descricao" class="textarea" rows="4" required></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Salvar chamado</button>
            <a href="?url=chamado/index" class="btn btn-outline btn-block">Cancelar</a>
        </div>
    </form>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
