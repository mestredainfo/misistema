<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\rotas;
use MISistema\idioma\traduzir;
use MISistema\sistema\servidor;

$server = new servidor();
$translate = new traduzir();
$router = new rotas();

$router->obter('', function() {
    include_once(dirname(__FILE__) . '/inicio.php');
});

$router->obter('/categoria/mensagem/', function() {
    include_once(dirname(__FILE__) . '/mensagem.php');
});

$router->obter('404', function() use ($translate, $server) {
    echo $translate->obter('Arquivo "%s" não encontrado!', basename($server->uri()));
});

if ($router->naoPHP()) {
    return false;
}
