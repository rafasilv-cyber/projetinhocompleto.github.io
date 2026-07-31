<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Categoria - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Cadastrar Nova Categoria</h4>
            </div>
            <div class="card-body">
                <form action="/projetinhocompleto.github.io/public/index.php?url=categoria/salvar" method="POST"></form>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome da Categoria *</label>
                        <input type="text" name="nome" class="form-control" placeholder="Ex: Suporte Técnico" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" placeholder="Breve descrição sobre os chamados desta categoria..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mb-2">Salvar Categoria</button>
                    <a href="/projetinhocompleto.github.io/public/index.php?url=categoria/index" class="btn btn-outline-secondary w-100">Cancelar e Voltar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>