<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Editar Usuário #<?= $usuario['id'] ?></h4>
            </div>
            <div class="card-body">
                <form action="/usuario/atualizar/<?= $usuario['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome Completo *</label>
                        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">E-mail *</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nova Senha</label>
                        <input type="password" name="senha" class="form-control" placeholder="Deixe em branco para manter a atual">
                        <div class="form-text">Preencha apenas se desejar redefinir a senha deste usuário.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mb-2">Atualizar Dados</button>
                    <a href="?url=usuario/index" class="btn btn-outline-secondary w-100">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>