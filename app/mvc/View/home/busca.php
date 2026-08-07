<?php
    $htmlTitle = 'Pesquisa global';
    $activeMenu = 'dashboard';
    $pageTitle = 'Pesquisa global';
    $pageSubtitle = $termo === '' ? 'Informe um termo para pesquisar no sistema.' : 'Resultados para: ' . $termo;
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
    $quantidade = count($resultados['chamados']) + count($resultados['categorias']) + count($resultados['usuarios']);
?>
<div class="table-card">
    <div class="table-card-head"><h3><?= $quantidade ?> resultado<?= $quantidade === 1 ? '' : 's' ?> encontrado<?= $quantidade === 1 ? '' : 's' ?></h3><a href="?url=home" class="btn btn-outline btn-sm">Voltar ao dashboard</a></div>
    <?php if ($termo === ''): ?>
        <div class="empty-mini">Digite um termo no campo de pesquisa do topo.</div>
    <?php elseif ($quantidade === 0): ?>
        <div class="empty-mini">Nenhum resultado encontrado para “<?= htmlspecialchars($termo) ?>”.</div>
    <?php else: ?>
        <?php if (!empty($resultados['chamados'])): ?><section class="search-section"><h3>Chamados</h3><?php foreach ($resultados['chamados'] as $chamado): ?><a class="search-result" href="?url=chamado/editar/<?= $chamado['id'] ?>"><strong>#<?= $chamado['id'] ?> · <?= htmlspecialchars($chamado['titulo']) ?></strong><span><?= htmlspecialchars($chamado['categoria_nome']) ?> · <?= htmlspecialchars($chamado['prioridade']) ?> · <?= htmlspecialchars($chamado['status']) ?></span></a><?php endforeach; ?></section><?php endif; ?>
        <?php if (!empty($resultados['categorias'])): ?><section class="search-section"><h3>Categorias</h3><?php foreach ($resultados['categorias'] as $categoria): ?><a class="search-result" href="?url=categoria/editar/<?= $categoria['id'] ?>"><strong><?= htmlspecialchars($categoria['nome']) ?></strong><span><?= htmlspecialchars($categoria['descricao'] ?? 'Sem descrição') ?></span></a><?php endforeach; ?></section><?php endif; ?>
        <?php if (!empty($resultados['usuarios'])): ?><section class="search-section"><h3>Usuários</h3><?php foreach ($resultados['usuarios'] as $usuario): ?><a class="search-result" href="?url=usuario/editar/<?= $usuario['id'] ?>"><strong><?= htmlspecialchars($usuario['nome']) ?></strong><span><?= htmlspecialchars($usuario['email']) ?></span></a><?php endforeach; ?></section><?php endif; ?>
    <?php endif; ?>
</div>
<?php require_once PARTIAL_PATH . '/footer.php'; ?>
