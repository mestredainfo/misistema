<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\sistema;

class exec
{
    private mixed $sProcess;
    private mixed $sPipes;
    private array $sComandos = [];

    public function comando(string $comando)
    {
        $this->sComandos[] = $comando;
        return $this;
    }

    public function consultar()
    {
        $comando = implode(' && ', $this->sComandos);

        $descriptorspec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );

        flush();

        $this->sProcess = proc_open($comando, $descriptorspec, $this->sPipes, realpath('./'), array());
    }

    public function valores(): mixed
    {
        if (is_resource($this->sProcess)) {
            return fgets($this->sPipes[1]);
        } else {
            return false;
        }
    }

    public function limpar()
    {
        flush();
    }

    public function fechar()
    {
        proc_close($this->sProcess);
    }
}
