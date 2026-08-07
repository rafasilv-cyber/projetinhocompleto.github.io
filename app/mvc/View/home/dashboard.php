<?php
    $htmlTitle   = 'Dashboard';
    $activeMenu  = 'dashboard';
    $pageTitle   = 'Dashboard';
    $pageSubtitle = 'Visão geral dos chamados e indicadores do sistema';
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';

    // Paleta usada no donut e nas listas — na mesma ordem dos tokens do style.css
    $donutPalette = [
        ['color' => '#4C5FEA', 'bar' => 'blue'],
        ['color' => '#16A87E', 'bar' => 'green'],
        ['color' => '#E8934A', 'bar' => 'amber'],
        ['color' => '#8B6CE8', 'bar' => 'violet'],
        ['color' => '#E1566B', 'bar' => 'red'],
        ['color' => '#8891AC', 'bar' => 'slate'],
    ];

    // --- Monta o gradiente cônico do donut a partir de $chamadosPorCategoria (dado real do HomeModel) ---
    $totalCategoriaChamados = array_sum(array_column($chamadosPorCategoria ?? [], 'total'));
    $stops = [];
    $cursor = 0;
    foreach (($chamadosPorCategoria ?? []) as $i => $row) {
        if ((int)$row['total'] === 0) continue;
        $fatia = $totalCategoriaChamados > 0 ? ($row['total'] / $totalCategoriaChamados) * 100 : 0;
        $cor = $donutPalette[$i % count($donutPalette)]['color'];
        $inicio = $cursor;
        $fim = $cursor + $fatia;
        $stops[] = "{$cor} {$inicio}% {$fim}%";
        $cursor = $fim;
    }
    $donutGradient = implode(', ', $stops);

    // --- Mapa de status -> variante visual, reutilizado nos badges e nas faixas de linha ---
    $statusMap = [
        'aberto'       => ['label' => 'Aberto',       'badge' => 'amber', 'row' => '#E8934A'],
        'em_andamento' => ['label' => 'Em andamento',  'badge' => 'blue',  'row' => '#4C5FEA'],
        'resolvido'    => ['label' => 'Resolvido',     'badge' => 'green', 'row' => '#16A87E'],
        'cancelado'    => ['label' => 'Cancelado',     'badge' => 'slate', 'row' => '#8891AC'],
    ];

    $maxPrioridade = max(array_column($chamadosPorPrioridade ?? [], 'total') ?: [0]);
?>

<div class="stat-grid">
    <a href="?url=chamado/index" class="stat-card stat-card--blue">
        <div class="stat-icon">&#9673;</div>
        <div class="stat-label">Total de chamados</div>
        <div class="stat-value"><?= $totais['total_chamados'] ?? 0 ?></div>
        <div class="stat-foot">Ver todos</div>
    </a>
    <a href="?url=chamado/index&status=aberto" class="stat-card stat-card--amber">
        <div class="stat-icon">&#9679;</div>
        <div class="stat-label">Chamados abertos</div>
        <div class="stat-value"><?= $totais['chamados_abertos'] ?? 0 ?></div>
        <div class="stat-foot">Ver abertos</div>
    </a>
    <a href="?url=chamado/index&status=em_andamento" class="stat-card stat-card--slate">
        <div class="stat-icon">&#9679;</div>
        <div class="stat-label">Em andamento</div>
        <div class="stat-value"><?= $totais['chamados_em_andamento'] ?? 0 ?></div>
        <div class="stat-foot">Ver em andamento</div>
    </a>
    <a href="?url=chamado/index&status=resolvido" class="stat-card stat-card--green">
        <div class="stat-icon">&#10003;</div>
        <div class="stat-label">Resolvidos</div>
        <div class="stat-value"><?= $totais['chamados_resolvidos'] ?? 0 ?></div>
        <div class="stat-foot">Ver resolvidos</div>
    </a>
    <a href="?url=categoria/index" class="stat-card stat-card--violet">
        <div class="stat-icon">&#9636;</div>
        <div class="stat-label">Categorias</div>
        <div class="stat-value"><?= $totais['total_categorias'] ?? 0 ?></div>
        <div class="stat-foot">Gerenciar categorias</div>
    </a>
    <a href="?url=usuario/index" class="stat-card stat-card--blue">
        <div class="stat-icon">&#9679;</div>
        <div class="stat-label">Usuários</div>
        <div class="stat-value"><?= $totais['total_usuarios'] ?? 0 ?></div>
        <div class="stat-foot">Gerenciar usuários</div>
    </a>
</div>

<div class="panel-grid">
    <div class="panel">
        <div class="panel-title">Chamados por categoria</div>
        <div class="panel-subtitle">Distribuição do total de chamados por categoria cadastrada</div>

        <?php if ($totalCategoriaChamados > 0): ?>
            <div class="donut-wrap">
                <div class="donut-ring" style="background: conic-gradient(<?= $donutGradient ?>);">
                    <div class="donut-center">
                        <strong><?= $totalCategoriaChamados ?></strong>
                        <span>chamados</span>
                    </div>
                </div>
                <div class="legend">
                    <?php foreach (($chamadosPorCategoria ?? []) as $i => $row): if ((int)$row['total'] === 0) continue; ?>
                        <div class="legend-item">
                            <span class="legend-dot" style="background: <?= $donutPalette[$i % count($donutPalette)]['color'] ?>;"></span>
                            <span class="legend-label"><?= htmlspecialchars($row['categoria']) ?></span>
                            <span class="legend-value"><?= $row['total'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-mini">Nenhum chamado cadastrado ainda para gerar o gráfico.</div>
        <?php endif; ?>
    </div>

    <div class="panel">
        <div class="panel-title">Chamados por prioridade</div>
        <div class="panel-subtitle">Volume de chamados em cada nível de prioridade</div>

        <?php if (!empty($chamadosPorPrioridade)): ?>
            <div class="bar-list">
                <?php
                    $corPrioridade = ['baixa' => '#16A87E', 'media' => '#4C5FEA', 'alta' => '#E8934A', 'urgente' => '#E1566B'];
                    foreach ($chamadosPorPrioridade as $row):
                        $pct = $maxPrioridade > 0 ? ($row['total'] / $maxPrioridade) * 100 : 0;
                        $cor = $corPrioridade[$row['prioridade']] ?? '#8891AC';
                ?>
                    <div class="bar-row">
                        <span class="bar-row-label"><?= htmlspecialchars($row['prioridade']) ?></span>
                        <span class="bar-track">
                            <span class="bar-fill" style="width: <?= $pct ?>%; --bar-color: <?= $cor ?>;"></span>
                        </span>
                        <span class="bar-row-value"><?= $row['total'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-mini">Nenhum chamado cadastrado ainda para gerar o gráfico.</div>
        <?php endif; ?>
    </div>
</div>

<div class="table-card">
    <div class="table-card-head">
        <h3>Últimos chamados registrados</h3>
        <div style="display:flex; align-items:center; gap: 10px;">
            <div class="seg-control">
                <a href="?url=home&limite=5" class="<?= $limiteAtual == 5 ? 'is-active' : '' ?>">5</a>
                <a href="?url=home&limite=10" class="<?= $limiteAtual == 10 ? 'is-active' : '' ?>">10</a>
                <a href="?url=home&limite=20" class="<?= $limiteAtual == 20 ? 'is-active' : '' ?>">20</a>
            </div>
            <a href="?url=chamado/index" class="btn btn-outline btn-sm">Ver todos</a>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoria</th>
                <th>Solicitante</th>
                <th>Status</th>
                <th style="text-align:right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ultimosChamados)): ?>
                <?php foreach ($ultimosChamados as $item):
                    $status = $statusMap[$item['status']] ?? ['label' => ucfirst($item['status']), 'badge' => 'slate', 'row' => '#8891AC'];
                ?>
                    <tr class="has-status" style="--row-color: <?= $status['row'] ?>;">
                        <td class="mono">#<?= $item['id'] ?></td>
                        <td class="cell-title"><?= htmlspecialchars($item['titulo']) ?></td>
                        <td class="cell-muted"><?= htmlspecialchars($item['categoria_nome']) ?></td>
                        <td class="cell-muted"><?= htmlspecialchars($item['usuario_nome']) ?></td>
                        <td><span class="badge badge--<?= $status['badge'] ?>"><?= htmlspecialchars($status['label']) ?></span></td>
                        <td>
                            <div class="row-actions">
                                <?php if (!in_array($item['status'], ['resolvido', 'cancelado'], true)): ?>
                                    <a href="?url=chamado/resolverRapido/<?= $item['id'] ?>" class="action-btn action-btn--success" title="Marcar como resolvido" aria-label="Marcar como resolvido" onclick="return confirm('Marcar o chamado #<?= $item['id'] ?> como resolvido?')">&#10003;</a>
                                <?php endif; ?>
                                <a href="?url=chamado/editar/<?= $item['id'] ?>" class="action-btn" title="Editar" aria-label="Editar chamado">&#9998;</a>
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
