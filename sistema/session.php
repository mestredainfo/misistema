<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\sistema\ambiente;

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'");

session_name('misistema');
session_start();

$ambiente = new ambiente();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session | MISistema</title>
</head>

<body>
    <?php
    if (empty($_SESSION['info'])) {
        $count = 1;
        $_SESSION['info'] = $count;

        echo 'Session: ' . $count;
    } else {
        $count = $_SESSION['info'] + 1;
        $_SESSION['info'] = $count;

        echo 'Session: ' . $count;
    }

    echo '<p><a href="javascript:window.location.reload();">Atualizar Página</a></p>';
    ?>
</body>

</html>