<?php
    $htmlTitle    = 'Chamados';
    $activeMenu   = 'chamados';
    $pageTitle    = 'Gerenciamento de chamados';
    $pageSubtitle = 'Acompanhe e trate os chamados abertos no sistema';
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';

    $statusMap = [
        'aberto'       => ['label' => 'Aberto',      'badge' => 'amber', 'row' => '#E8934A'],
        'em_andamento' => ['label' => 'Em andamento', 'badge' => 'blue',  'row' => '#4C5FEA'],
        'resolvido'    => ['label' => 'Resolvido',    'badge' => 'green', 'row' => '#16A87E'],
        'cancelado'    => ['label' => 'Cancelado',    'badge' => 'slate', 'row' => '#8891AC'],
    ];
?>

<div class="table-card">
    <div class="table-card-head">
        <h3>Todos os chamados</h3>
        <a href="?url=chamado/criar" class="btn btn-primary btn-sm">+ Novo chamado</a>
    </div>

    <form method="GET" action="" style="padding: 16px 20px 0 20px;">
        <input type="hidden" name="url" value="chamado/index">
        <div class="topbar-search" style="width: 100%; max-width: 420px;">
            <span>&#8981;</span>
            <input type="text" name="busca" placeholder="Pesquisar por título ou descrição..." value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
        </div>
    </form>

    <table class="data-table" style="margin-top: 16px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoria</th>
                <th>Prioridade</th>
                <th>Status</th>
                <th style="text-align:right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($chamados)): ?>
                <?php foreach ($chamados as $c):
                    $status = $statusMap[$c['status']] ?? ['label' => ucfirst($c['status']), 'badge' => 'slate', 'row' => '#8891AC'];
                ?>
                    <tr class="has-status" style="--row-color: <?= $status['row'] ?>;">
                        <td class="mono">#<?= $c['id'] ?></td>
                        <td class="cell-title"><?= htmlspecialchars($c['titulo']) ?></td>
                        <td class="cell-muted"><?= htmlspecialchars($c['categoria_nome']) ?></td>
                        <td class="cell-muted"><?= ucfirst($c['prioridade']) ?></td>
                        <td><span class="badge badge--<?= $status['badge'] ?>"><?= htmlspecialchars($status['label']) ?></span></td>
                        <td>
                            <div class="row-actions">
                                <a href="?url=chamado/editar/<?= $c['id'] ?>" class="action-btn" title="Editar" aria-label="Editar chamado">&#9998;</a>
                                <a href="?url=chamado/excluir/<?= $c['id'] ?>" class="action-btn action-btn--danger" title="Excluir" aria-label="Excluir chamado" onclick="return confirm('Tem certeza que deseja excluir este chamado?')">&#128465;</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="6">Nenhum chamado encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
