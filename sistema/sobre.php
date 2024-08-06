<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\config;
use MISistema\app\sobre;
use MISistema\sistema\ambiente;

$ambiente = new ambiente();
$sobre = new sobre();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre o MISistema</title>
</head>

<body>
    <?php
    $config = new config();
    $sobre->nome('MISistema')
        ->versao($config->obter('sistema', 'versao'))
        ->autor('Murilo Gomes Julio', 'Mestre da Info')
        ->copyright('2004-2024', 'Murilo Gomes Julio')
        ->paginainicial('https://www.mestredainfo.com.br')
        ->exibir();
    ?>
</body>

</html>