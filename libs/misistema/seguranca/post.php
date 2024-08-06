<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\seguranca;

class post
{
    /* Limpar POST */
    function obter(string $nome, int $filter = FILTER_DEFAULT): string|int|null
    {
        return filter_input(INPUT_POST, $nome, $filter);
    }

    function existe(string $nome, array|int $options = 0): bool
    {
        return empty(filter_input(INPUT_POST, $nome, FILTER_DEFAULT, $options)) ? false : true;
    }

    function solicitado(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return true;
        } else {
            return false;
        }
    }
}
