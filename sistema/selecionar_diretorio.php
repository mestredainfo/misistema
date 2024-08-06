<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\seguranca\get;
use MISistema\sistema\ambiente;

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'");
$ambiente = new ambiente();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Diretório</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    $get = new get();

    if ($get->existe('directory')) {
        echo $get->obter('directory');
        exit;
    }
    ?>
    <script>
        async function open() {
            let sSelect = await misistema.selecionarDiretorio();
            window.location.assign(`?directory=${sSelect.toString()}`);
        }
        open();
    </script>
</body>

</html>