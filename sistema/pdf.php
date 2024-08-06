<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\arquivo;
use MISistema\app\datahora;
use MISistema\app\pasta;
use MISistema\sistema\ambiente;

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'");

$ambiente = new ambiente();
$arquivo = new arquivo();
$pasta = new pasta();
if (!$pasta->existe(dirname(__FILE__) . '/pdf/')) {
    $pasta->criar(dirname(__FILE__) . '/pdf/');
}
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <button id="pdf" type="button" class="no-print">Export PDF</button>
    <div class="display-none print">
        <h3>Exemplo PDF</h3>
        <table>
            <tr>
                <td><strong>Data/Hora:</strong></td>
                <td>
                    <?php
                    $datahora = new datahora();
                    echo $datahora->alterar($datahora->agora(), 'd/m/Y H:i:s', 'Y-m-d H:i:s');
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <p class="no-print">Exportar PDF</p>
    <script>
        const pdf = document.getElementById('pdf');

        pdf.addEventListener('click', async () => {
            await misistema.exportarPDF('<?php echo dirname(__FILE__) . '/pdf/exemplo.pdf'; ?>');
            misistema.novaJanela('/pdf/exemplo.pdf');
        });
    </script>
</body>

</html>