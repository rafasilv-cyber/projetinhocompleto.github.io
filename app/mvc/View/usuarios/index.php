<?php
    $htmlTitle    = 'Usuários';
    $activeMenu   = 'usuarios';
    $pageTitle    = 'Gerenciamento de usuários';
    $pageSubtitle = 'Pessoas com acesso ao sistema de chamados';
    require_once PARTIAL_PATH . '/head.php';
    require_once PARTIAL_PATH . '/sidebar.php';
?>

<div class="table-card">
    <div class="table-card-head">
        <h3>Todos os usuários</h3>
        <a href="?url=usuario/criar" class="btn btn-primary btn-sm">+ Novo usuário</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th style="text-align:right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td class="mono">#<?= $u['id'] ?></td>
                        <td class="cell-title"><?= htmlspecialchars($u['nome']) ?></td>
                        <td class="cell-muted"><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <div class="row-actions">
                                <a href="?url=usuario/editar/<?= $u['id'] ?>" class="action-btn" title="Editar" aria-label="Editar usuário">&#9998;</a>
                                <a href="?url=usuario/excluir/<?= $u['id']; ?>" class="action-btn action-btn--danger" title="Excluir" aria-label="Excluir usuário" onclick="return confirm('Deseja realmente excluir este usuário?');">&#128465;</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="empty-row"><td colspan="4">Nenhum usuário cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once PARTIAL_PATH . '/footer.php'; ?>
