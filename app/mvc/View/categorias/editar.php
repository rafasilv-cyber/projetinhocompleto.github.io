<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Editar Categoria #<?= $categoria['id'] ?></h4>
            </div>
            <div class="card-body">
                <form action="?url=categoria/atualizar/<?= $categoria['id']; ?>" method="POST"></form>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome da Categoria *</label>
                        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($categoria['nome']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($categoria['descricao'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mb-2">Atualizar Categoria</button>
                    <a href="?url=categoria/index" class="btn btn-outline-secondary w-100">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>