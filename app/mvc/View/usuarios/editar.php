<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3">
                    <h4 class="mb-0 fw-bold">Editar Usuário <?= $usuario['id']; ?></h4>
                </div>
                <div class="card-body p-4">
                    <form action="?url=usuario/atualizar/<?= $usuario['id']; ?>" method="POST">
                        
                        <div class="mb-3">
                            <label for="nome" class="form-label fw-bold">Nome Completo *</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">E-mail *</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label fw-bold">Nova Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Deixe em branco para manter a atual">
                            <small class="text-muted d-block mt-1">Preencha apenas se desejar redefinir a senha deste usuário.</small>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg fs-6">Atualizar Dados</button>
                            <a href="?url=usuario/index" class="btn btn-outline-secondary">Cancelar</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>