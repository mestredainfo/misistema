<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\app\config;
use MISistema\idioma\traduzir;
use MISistema\sistema\servidor;

include_once(dirname(__FILE__, 2) . '/libs/autoload/autoload.php');
$miconfig = new config();

if ($miconfig->obter('servidor', 'rotas')) {
    return (include_once dirname(__FILE__, 2) . '/sistema/rotas.php');
} else {
    $miserver = new servidor();
    $mitranslate = new traduzir();

    if ($miserver->uri() == '') {
        if (file_exists(dirname(__FILE__, 2) . '/sistema/inicio.php')) {
            include_once(dirname(__FILE__, 2) . '/sistema/inicio.php');
        } else {
            echo $mitranslate->obter('Arquivo "%s" não encontrado!', 'inicio.php');
        }
    } else {
        if (substr($miserver->uri(), -4) === '.php') {
            if (file_exists(dirname(__FILE__, 2) . '/sistema/' . $miserver->uri())) {
                include_once(dirname(__FILE__, 2) . '/sistema/' . $miserver->uri());
            } else {
                echo $mitranslate->obter('Arquivo "%s" não encontrado!', basename($miserver->uri()));
            }
        } else {
            return false;
        }
    }
}
