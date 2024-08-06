<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

use MISistema\seguranca\post;
use MISistema\sistema\ambiente;
use MISistema\sistema\exec;

$post = new post();
if ($post->solicitado()) {
    if ($post->existe('comando')) {
        $exec = new exec();
        $exec->comando($post->obter('comando'))->consultar();
        while ($row = $exec->valores()) {
            echo $row . '<br>';
            $exec->limpar();
        }
        $exec->fechar();
    } else {
        echo 'Não encontrado comando!';
    }
}
