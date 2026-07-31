<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Chamados - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Pode copiar o mesmo <nav> do dashboard aqui -->
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gerenciamento de Chamados</h2>
            <a href="/projetinhocompleto.github.io/public/index.php?url=chamado/criar" class="btn btn-primary">+ Novo Chamado</a>
        </div>

        <form method="GET" action="/projetinhocompleto.github.io/public/index.php?url=chamado/index" class="mb-4">
            <div class="input-group">
                <input type="text" name="busca" class="form-control" placeholder="Pesquisar por título ou descrição..." value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
            </div>
        </form>

        <div class="card shadow-sm"><div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>ID</th><th>Título</th><th>Categoria</th><th>Prioridade</th><th>Status</th><th>Ações</th></tr></thead>
                <tbody>
                    <?php foreach ($chamados as $c): ?>
                        <tr>
                            <td><?= $c['id'] ?></td>
                            <td><?= htmlspecialchars($c['titulo']) ?></td>
                            <td><?= htmlspecialchars($c['categoria_nome']) ?></td>
                            <td><?= ucfirst($c['prioridade']) ?></td>
                            <td><?= ucfirst($c['status']) ?></td>
                            <td>
                                <a href="?url=chamado/editar/<?= $c['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="?url=chamado/excluir/<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div></div>
    </div>
</body>
</html>