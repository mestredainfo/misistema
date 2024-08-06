<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\sistema\ambiente;
use MISistema\sistema\servidor;

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'");
$ambiente = new ambiente();
$server = new servidor();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executar Comando</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <label>Comando</label><br>
    <input id="comando" type="text" value="dir <?php echo $ambiente->pastaSistema(); ?>">
    <br><br>
    <button type="button" onclick="execJS()">Executar JS</button>
    <button type="button" onclick="execPHP()">Executar PHP</button>
    <hr>
    <div id="info"></div>
    <script>
        async function execJS() {
            document.getElementById('info').innerHTML = '';
            misistema.exec(document.getElementById('comando').value);
            misistema.listExec((data) => {
                var sData = data.split("\n")
                sData.forEach(result => {
                    document.getElementById('info').innerHTML += result + '<br>';
                });
            });
        }

        async function execPHP() {
            document.getElementById('info').innerHTML = '';
            misistema.post('<?php echo $server->dominio(); ?>/includes/exec.php', {
                "comando": document.getElementById('comando').value
            });
            misistema.listPost((data) => {
                document.getElementById('info').innerHTML += data + '<br>';
            });
        }
    </script>
</body>

</html>