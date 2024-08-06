<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\sistema\ambiente;

$ambiente = new ambiente();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Argumentos</title>
</head>

<body>
    <p>Para executar os argumentos do terminal, vá para sua pasta e digite:</p>
    <ul>
        <li>./misistema test1 test2 test3</li>
    </ul>
    <?php
    if (empty($ambiente->argumentos())) {
        echo 'Nenhum argumento foi encontrado!';
    } else {
        echo $ambiente->argumentos();
    }
    ?>
</body>

</html>