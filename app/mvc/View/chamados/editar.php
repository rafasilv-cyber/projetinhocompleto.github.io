<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Chamado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark"><h4 class="mb-0">Editar Chamado #<?= $chamado['id'] ?></h4></div>
            <div class="card-body">
                <form action="?url=chamado/atualizar/<?= $chamado['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label>Título *</label>
                        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($chamado['titulo']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="aberto" <?= $chamado['status'] == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                            <option value="em_andamento" <?= $chamado['status'] == 'em_andamento' ? 'selected' : '' ?>>Em Andamento</option>
                            <option value="resolvido" <?= $chamado['status'] == 'resolvido' ? 'selected' : '' ?>>Resolvido</option>
                            <option value="cancelado" <?= $chamado['status'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Descrição *</label>
                        <textarea name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($chamado['descricao']) ?></textarea>
                    </div>

                <div class="mb-3">
    <label>Categoria *</label>
    <select name="categoria_id" class="form-select" required>
        <?php foreach ($categorias as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $chamado['categoria_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label>Prioridade</label>
    <select name="prioridade" class="form-select">
        <option value="baixa" <?= $chamado['prioridade'] == 'baixa' ? 'selected' : '' ?>>Baixa</option>
        <option value="media" <?= $chamado['prioridade'] == 'media' ? 'selected' : '' ?>>Média</option>
        <option value="alta" <?= $chamado['prioridade'] == 'alta' ? 'selected' : '' ?>>Alta</option>
        <option value="urgente" <?= $chamado['prioridade'] == 'urgente' ? 'selected' : '' ?>>Urgente</option>
    </select>
</div>

                    <!-- (Adicione os campos categoria e prioridade mantendo o padrão de value/selected) -->
                    <button type="submit" class="btn btn-success w-100">Atualizar Chamado</button>
                    <a href="?url=chamado/index" class="btn btn-link w-100 text-center mt-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>