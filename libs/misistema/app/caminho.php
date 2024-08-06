<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

class caminho
{
    public function juntar(string ...$valores): string
    {
        $arquivo = new arquivo();

        $txt = '';
        $first = true;
        foreach ($valores as $file) {
            $sFile = str_replace('//', '/', $file);

            $txt .= ($first) ? rtrim($sFile, '/') : rtrim(ltrim($sFile, '/'), '/');

            if (!$arquivo->verificarExtensao($txt) && substr($txt, -1) !== '/') {
                $txt .= '/';
            }

            $first = false;
        }

        return $txt;
    }
}
