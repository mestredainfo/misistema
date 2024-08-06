<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\funcoes;
use MISistema\seguranca\post;
use MISistema\sistema\ambiente;

$ambiente = new ambiente();
$post = new post();

if ($post->solicitado()) {
    $funcao = new funcoes();
    if ($post->obter('rotas') == 1) {
        $funcao->redirecionar('/categoria/mensagem/');
    } else {
        $funcao->redirecionar('mensagem.php');
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecionar</title>
</head>

<body>
    <form method="post" action="redirecionar.php">
        <select name="rotas">
            <option value="1">/categoria/mensagem/</option>
            <option value="2">mensagem.php</option>
        </select>
        <button type="submit">Enviar</button>
    </form>
</body>

</html>