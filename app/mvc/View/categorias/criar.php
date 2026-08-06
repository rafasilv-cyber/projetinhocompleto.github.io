<?php
    $htmlTitle    = 'Nova categoria';
    $activeMenu   = 'categorias';
    $pageTitle    = 'Nova categoria';
    $pageSubtitle = 'Cadastre um novo tipo de chamado';
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
?>

<div class="form-card">
    <div class="form-card-head">
        <div class="stat-icon stat-card--violet" style="--stat-color: var(--violet); --stat-bg: var(--violet-soft);">&#9636;</div>
        <h3>Cadastrar nova categoria</h3>
    </div>
    <form class="form-card-body" action="?url=categoria/salvar" method="POST">
        <div class="field">
            <label for="nome">Nome da categoria *</label>
            <input type="text" id="nome" name="nome" class="input" required>
        </div>
        <div class="field">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" class="textarea" rows="3"></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-block">Salvar categoria</button>
            <a href="?url=categoria/index" class="btn btn-outline btn-block">Cancelar e voltar</a>
        </div>
    </form>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
