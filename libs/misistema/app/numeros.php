<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

class numeros
{
    function moeda(string $valor): string
    {
        return number_format($valor, 2, ",", ".");
    }

    function formatar(string $valor): string
    {
        return empty($valor) ? 0 : str_pad($valor, 2, '0', STR_PAD_LEFT);
    }
}
