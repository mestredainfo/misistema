<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\pasta;
use MISistema\dados\consultar;
use MISistema\dados\ferramentas;
use MISistema\dados\inserir;
use MISistema\sistema\ambiente;

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'");

if (empty($_COOKIE['info'])) {
    $count = 1;
    setcookie('info[msg]', $count, 0, '/', $_SERVER['SERVER_NAME'], false, true);
} else {
    $count = $_COOKIE['info']['msg'] + 1;
    setcookie('info[msg]', $count, 0, '/', $_SERVER['SERVER_NAME'], false, true);
}

$ambiente = new ambiente();
?>
<!DOCTYPE html>
<html lang="<?php echo $ambiente->idioma(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQLITE3 | MISistema</title>
</head>

<body>
    <?php
    $pasta = new pasta();
    $pathDados = dirname(__FILE__) . '/dados/';
    if (!$pasta->existe($pathDados)) {
        $pasta->criar($pathDados);
    }

    $arquivoDados = ['arquivo' => $pathDados . 'exemplo.sqlite'];

    // Criar Banco de Dados
    $db1 = new ferramentas($arquivoDados);
    $db1->tabela('mi_exemplo')
        ->autoIncrementar()->chavePrimaria()->inteiro()->inserirColuna('id')
        ->inserirColuna('nome')
        ->criar();
    $db1->fechar();

    // Inserir
    $db2 = new inserir($arquivoDados, inserir::LeituraEscrita);
    $db2->ativarPreparado()
        ->tabela('mi_exemplo')
        ->inserirValor('nome', $count)
        ->gerar();
    $db2->fechar();

    echo '<p><a href="javascript:window.location.reload();">Atualizar Página</a></p>';

    // Check records
    $db3 = new consultar($arquivoDados, consultar::SomenteLeitura);
    $db3->tabela('mi_exemplo')
        ->decrescente()->ordem('id')
        ->gerar();

    while ($row = $db3->vetores()) {
        $db3->valores($row);
        echo $db3->valor('nome') . '<br>';
    }

    $db3->fechar();
    ?>
</body>

</html>