<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Cadastrar Novo Usuário</h4>
            </div>
            <div class="card-body">
                <form action="projetinhocompleto.github.io/public/index.php?url=usuario/salvar" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome Completo *</label>
                        <input type="text" name="nome" class="form-control" placeholder="Ex: João da Silva" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">E-mail *</label>
                        <input type="email" name="email" class="form-control" placeholder="joao@empresa.com.br" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Senha de Acesso *</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mb-2">Salvar Usuário</button>
                    <a href="?url=usuario/index" class="btn btn-outline-secondary w-100">Cancelar e Voltar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>