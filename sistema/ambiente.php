<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\sistema\ambiente;

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'");
$ambiente = new ambiente();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambiente</title>
</head>
<body>
    <strong>Nome de Usuário</strong><br>
    <?php echo $ambiente->usuario(); ?><br><br>

    <strong>Pasta do Usuário</strong><br>
    <?php echo $ambiente->pastaUsuario(); ?><br><br>

    <strong>Distribuição Linux</strong><br>
    <?php echo $ambiente->distribuicao(); ?><br><br>

    <strong>Idioma</strong><br>
    <?php echo $ambiente->idioma(); ?><br><br>

    <strong>Pasta do Sistema</strong><br>
    <?php echo $ambiente->pastaSistema(); ?><br><br>
</body>
</html>