<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Chamado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h4 class="mb-0">Abrir Novo Chamado</h4></div>
            <div class="card-body">
                <form action="?url=chamado/salvar" method="POST">
                    <div class="mb-3">
                        <label>Título *</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Categoria *</label>
                        <select name="categoria_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Prioridade</label>
                        <select name="prioridade" class="form-select">
                            <option value="baixa">Baixa</option>
                            <option value="media" selected>Média</option>
                            <option value="alta">Alta</option>
                            <option value="urgente">Urgente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Descrição *</label>
                        <textarea name="descricao" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Salvar Chamado</button>
                    <a href="/projetinhocompleto.github.io/public/index.php?url=chamado/index" class="btn btn-link w-100 text-center mt-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>