<?php
    // Espera receber: $htmlTitle (título da aba do navegador)
    $htmlTitle = $htmlTitle ?? 'HelpDesk';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($htmlTitle) ?> · HelpDesk</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
