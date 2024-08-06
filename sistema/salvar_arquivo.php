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
    <title>Salvar Arquivo</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    $get = new get();
    if ($get->existe('filename')) {
        $filename = $get->obter('filename');

        $arquivo = new arquivo();
        $arquivo->salvar($filename, rand(10000, 99999));
        echo 'Arquivo ' . basename($filename) . ' salvo com sucesso!';
        exit;
    }
    ?>
    <script>
        async function save() {
            let sSave = await misistema.salvarArquivo();
            window.location.assign(`?filename=${sSave.toString()}`);
        }
        save();
    </script>
</body>

</html>