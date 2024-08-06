<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\sistema;

class plataforma
{
    private string $sDistro = '';
    private function obter()
    {
        $exec = new exec();
        $exec->comando('lsb_release -i')->consultar();
        $a = explode(':', $exec->valores()[0]);
        $exec->fechar();
        if (empty($a[1])) {
            $this->sDistro = '';
        } else {
            $this->sDistro = strtolower(trim($a[1]));
        }
    }

    function soDebian(): bool
    {
        $this->obter();
        return ($this->sDistro == 'debian') ? true : false;
    }

    function soUbuntu(): bool
    {
        $this->obter();
        return ($this->sDistro == 'debian') ? true : false;
    }
}
