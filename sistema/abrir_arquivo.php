<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\arquivo;
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
    <title>Abrir Arquivo</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    $get = new get();
    if ($get->existe('filename')) {
        $filename = $get->obter('filename');

        $arquivo = new arquivo();
        if ($arquivo->existe($filename)) {
            echo '<textarea>' . $arquivo->abrir($filename) . '</textarea>';
        } else {
            echo 'Arquivo não encontrado!';
        }
        exit;
    }
    ?>
    <script>
        async function open() {
            let sOpen = await misistema.abrirArquivo();
            window.location.assign(`?filename=${sOpen.toString()}`);
        }
        open();
    </script>
</body>

</html>