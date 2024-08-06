<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

use MISistema\sistema\servidor;

class config
{
    private array $aConfig = [];

    public function __construct()
    {
        $server = new servidor();
        $this->aConfig = json_decode(file_get_contents($server->pastaSistema() . '/config.json'), true);
    }

    function obter(string ...$nomes): string|int|bool
    {
        $sValor = $this->aConfig;

        foreach ($nomes as $value) {
            $sValor = (empty($sValor[$value])) ? '' : $sValor[$value];
        }

        return $sValor;
    }
}
