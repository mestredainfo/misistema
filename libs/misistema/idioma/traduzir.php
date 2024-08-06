<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\idioma;

use MISistema\sistema\ambiente;
use MISistema\sistema\servidor;

class traduzir
{
    private array $miLang = [];
    public function __construct()
    {
        $server = new servidor();
        $env = new ambiente();
        /* Lang */
        $miLangPath = sprintf('%s/lang/%s.json', $server->pastaSistema(), $env->idioma());

        if (file_exists($miLangPath)) {
            $this->miLang = json_decode(file_get_contents($miLangPath), true);
        } else {
            if (file_exists(dirname(__FILE__, 4) . '/lang/en.json')) {
                $this->miLang = json_decode(file_get_contents($server->pastaSistema() . '/lang/en.json'), true);
            }
        }
    }

    public function obter(string $texto, string ...$valores): string
    {
        return (empty($this->miLang[$texto])) ? sprintf($texto, ...$valores) : sprintf($this->miLang[$texto], ...$valores);
    }
}
