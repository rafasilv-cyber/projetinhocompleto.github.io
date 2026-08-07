<?php
    // Espera receber: $htmlTitle (título da aba do navegador)
    $htmlTitle = $htmlTitle ?? 'HelpDesk';

    // Busca as configurações do sistema uma única vez por requisição —
    // o partials/sidebar.php reaproveita essa mesma variável $configSistema,
    // então não roda outra consulta ao banco pra isso.
    $configuracaoModel = new ConfiguracaoModel();
    $configSistema = $configuracaoModel->obterTodas();
    $nomeSistema = $configSistema['nome_sistema'] ?? 'HelpDesk';
    $baseUrl = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($htmlTitle) ?> · <?= htmlspecialchars($nomeSistema) ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl) ?>/assets/css/style.css">
</head>
<body>
