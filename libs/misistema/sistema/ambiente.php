<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\sistema;

use MISistema\seguranca\itens;

class ambiente
{
    private mixed $itens;

    public function __construct()
    {
        $this->itens = new itens();
    }

    function obter(string $nome): string
    {
        return $this->itens->limpar(filter_input(INPUT_ENV, $nome, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }

    function usuario(): string
    {
        return $this->obter('MISISTEMA_NOME_USUARIO');
    }

    function pastaUsuario(): string
    {
        return $this->obter('MISISTEMA_PASTA_USUARIO');
    }

    function idioma(): string
    {
        return $this->obter('MISISTEMA_IDIOMA');
    }

    function distribuicao(): string
    {
        $exec = new exec();
        $exec->comando('lsb_release -i')->consultar();
        while ($row = $exec->valores()) {
            $a = explode(':', $row);
            $exec->limpar();
        }
        $exec->fechar();

        return strtolower(trim($a[1]));
    }

    function pastaSistema(): string
    {
        return $this->obter('MISISTEMA_PASTA');
    }

    function argumentos(): string
    {
        return $this->obter('MISISTEMA_ARGUMENTOS');
    }
}
