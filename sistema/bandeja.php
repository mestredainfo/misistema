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
    <title>Bandeja</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <button type="button" onclick="tray()">Bandeja do Sistema</button>
    <script>
        async function tray() {
            misistema.bandeja('MISistema', 'MISistema', '', JSON.stringify({
                "Mensagem": {
                    click: "misistema.alerta('MISistema', 'Este é um exemplo de mensagem!', 'info');"
                },
                "Fechar Janela": {
                    click: 'window.close();'
                }
            }));
        }
    </script>
</body>

</html>