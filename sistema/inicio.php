<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\vetor;
use MISistema\sistema\ambiente;

header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline'");

$ambiente = new ambiente();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISistema - Execute e desenvolva aplicativos PHP para desktop</title>
    <style>
        body {
            font-size: 18px;
        }

        li {
            line-height: 27px;
        }
    </style>
</head>

<body>
    <h3>Informação</h3>
    <p id="version" style="line-height: 37px;"></p>
    <p style="margin-top: -7px;">Versão do PHP: <?php echo phpversion(); ?></p>

    <h3>Exemplos</h3>
    <?php
    $vetor = new vetor();
    $files = scandir(dirname(__FILE__) . '/');
    echo '<ul>';
    foreach ($files as $file) {
        if (!empty($file)) {
            if ($file !== '.' && $file !== '..') {
                if (file_exists(dirname(__FILE__) . '/' . $file) && $file !== 'inicio.php' && $file !== 'style.css' && $file !== 'rotas.php' && $file !== 'config.json' && $file !== 'menu.json') {
                    if (is_file(dirname(__FILE__) . '/' . $file)) {
                        $vetor->vetores(explode('_', str_replace('.php', '', $file)));
                        printf('<li><a href="%s" target="_blank" rel="noopener">%s %s</a></li>', $file, ucfirst($vetor->obter(0)), ucfirst($vetor->obter(1)));
                    }
                }
            }
        }
    }
    echo '</ul>';
    ?>
    <script>
        const txtVersion = document.getElementById('version');

        misistema.versao('misistema').then((result) => {
            txtVersion.innerHTML = `Versão de MISistema: ${result}<br>`;
        });

        misistema.versao('electron').then((result) => {
            txtVersion.innerHTML += `Versão de ElectronJS: ${result}<br>`;
        });

        misistema.versao('node').then((result) => {
            txtVersion.innerHTML += `Versão de NodeJS: ${result}<br>`;
        });

        misistema.versao('chromium').then((result) => {
            txtVersion.innerHTML += `Versão de Chromium: ${result}<br>`;
        });
    </script>
</body>

</html>