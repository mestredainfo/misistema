<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\funcoes;
use MISistema\sistema\ambiente;

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'");
$ambiente = new ambiente();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagem</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    $funcoes = new funcoes();
    $funcoes->alerta('Mensagem de Informação', 'Este é um exemplo de mensagem com PHP!', 'info');
    $funcoes->confirmacao('Confirmação', 'Este é um exemplo de confirmação com PHP!', 'info', function() {
        echo 'document.getElementById(\'info\').innerHTML = \'Confirmado\';'; 
    }, function() {
        echo 'document.getElementById(\'info\').innerHTML = \'Não Confirmado\';'; 
    });
    ?>

    <button type="button" onclick="message()">Exibir Mensagem com JS</button>
    <button type="button" onclick="confirm()">Confirmação com JS</button>
    <button type="button" onclick="confirm(true)">Confirmação (4 botões) com JS</button>
    <div id="info"></div>
    <script>
        async function message(buttons) {
            if (buttons) {
                misistema.alerta('Mensagem de informação', 'Este é um exemplo de mensagem!', 'info', 'Botão 1', 'Botão 3');
            } else {
                misistema.alerta('Mensagem de informação', 'Este é um exemplo de mensagem!', 'info');
            }
        }

        async function confirm(buttons) {
            if (buttons) {
                misistema.confirmacao('Mensagem de confirmação', 'Este é um exemplo de mensagem!', 'error', 'Botão 1', 'Botão 2').then((result) => {
                    if (result == 1) {
                        document.getElementById('info').innerHTML = 'Não confirmado';
                    } else if (result == 2) {
                        document.getElementById('info').innerHTML = 'Botão 1';
                    } else if (result == 3) {
                        document.getElementById('info').innerHTML = 'Botão 2';
                    } else {
                        document.getElementById('info').innerHTML = 'Confirmada';
                    }
                });
            } else {
                misistema.confirmacao('Mensagem de confirmação', 'Este é um exemplo de mensagem!', 'error').then((result) => {
                    if (result) {
                        document.getElementById('info').innerHTML = 'Não confirmado';
                    } else {
                        document.getElementById('info').innerHTML = 'Confirmada';
                    }
                });
            }
        }
    </script>
</body>

</html>