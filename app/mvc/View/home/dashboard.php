<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/home">HelpDesk</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="?url=home">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=chamado/index">Chamados</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=categoria/index">Categorias</a></li>
                    <li class="nav-item"><a class="nav-link" href="?url=usuario/index">Usuários</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Painel de Indicadores</h2>
        
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white shadow-sm"><div class="card-body">
                    <h6>Total de Chamados</h6><h2 class="display-6 fw-bold"><?= $totais['total_chamados'] ?? 0 ?></h2>
                </div></div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark shadow-sm"><div class="card-body">
                    <h6>Chamados Abertos</h6><h2 class="display-6 fw-bold"><?= $totais['chamados_abertos'] ?? 0 ?></h2>
                </div></div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white shadow-sm"><div class="card-body">
                    <h6>Chamados Resolvidos</h6><h2 class="display-6 fw-bold"><?= $totais['chamados_resolvidos'] ?? 0 ?></h2>
                </div></div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white shadow-sm"><div class="card-body">
                    <h6>Usuários Cadastrados</h6><h2 class="display-6 fw-bold"><?= $totais['total_usuarios'] ?? 0 ?></h2>
                </div></div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Últimos Chamados Registrados</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>#ID</th><th>Título</th><th>Categoria</th><th>Solicitante</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php if (!empty($ultimosChamados)): ?>
                            <?php foreach ($ultimosChamados as $item): ?>
                                <tr>
                                    <td>#<?= $item['id'] ?></td>
                                    <td><?= htmlspecialchars($item['titulo']) ?></td>
                                    <td><?= htmlspecialchars($item['categoria_nome']) ?></td>
                                    <td><?= htmlspecialchars($item['usuario_nome']) ?></td>
                                    <td><span class="badge bg-<?= $item['status'] == 'aberto' ? 'warning text-dark' : 'success' ?>"><?= ucfirst($item['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-3">Nenhum chamado encontrado.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>