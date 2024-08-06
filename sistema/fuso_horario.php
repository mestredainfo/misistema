<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\datahora;
use MISistema\sistema\ambiente;

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'");

date_default_timezone_set("America/Sao_Paulo");

$ambiente = new ambiente();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuso Horário | MISistema</title>
</head>

<body>
    <?php
    $datahora = new datahora();
    echo $datahora->agora(); ?>
</body>

</html>