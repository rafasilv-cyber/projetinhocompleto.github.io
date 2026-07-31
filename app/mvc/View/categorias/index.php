<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Menu Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="?url=home">HelpDesk</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="?url=home">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=chamado/index">Chamados</a></li>
                    <li class="nav-item"><a class="nav-link active" href="?url=categoria/index">Categorias</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=usuario/index">Usuários</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gerenciamento de Categorias</h2>
            <a href="?url=categoria/criar" class="btn btn-primary">+ Nova Categoria</a>
        </div>

        <!-- Exibição de Mensagens de Sucesso ou Erro (opcional, mas recomendado) -->
        <?php if (isset($_SESSION['sucesso'])): ?>
            <div class="alert alert-success"><?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome da Categoria</th>
                            <th>Descrição</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $cat): ?>
                                <tr>
                                    <td><?= $cat['id'] ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($cat['nome']) ?></td>
                                    <td><?= htmlspecialchars($cat['descricao'] ?? 'Sem descrição') ?></td>
                                    <td class="text-end">
                                        <a href="?url=categoria/editar/<?= $cat['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="?url=categoria/excluir/<?= $cat['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center py-3">Nenhuma categoria cadastrada.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>