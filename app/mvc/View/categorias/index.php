<?php
    $htmlTitle    = 'Categorias';
    $activeMenu   = 'categorias';
    $pageTitle    = 'Gerenciamento de categorias';
    $pageSubtitle = 'Organize os tipos de chamados atendidos pelo sistema';
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
?>

<div class="table-card">
    <div class="table-card-head">
        <h3>Todas as categorias</h3>
        <a href="?url=categoria/criar" class="btn btn-primary btn-sm">+ Nova categoria</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th style="text-align:right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $cat): ?>
                    <tr>
                        <td class="mono">#<?= $cat['id'] ?></td>
                        <td class="cell-title"><?= htmlspecialchars($cat['nome']) ?></td>
                        <td class="cell-muted"><?= htmlspecialchars($cat['descricao'] ?? 'Sem descrição') ?></td>
                        <td>
                            <div class="row-actions">
                                <a href="?url=categoria/editar/<?= $cat['id'] ?>" class="action-btn" title="Editar" aria-label="Editar categoria">&#9998;</a>
                                <a href="?url=categoria/excluir/<?= $cat['id'] ?>" class="action-btn action-btn--danger" title="Excluir" aria-label="Excluir categoria" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">&#128465;</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="4">Nenhuma categoria cadastrada ainda.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
