<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

use MISistema\sistema\servidor;

class rotas
{
    private bool $isFile = false;
    private bool $nophp = false;
    private bool $encontrado = false;
    private string $url = '';
    private mixed $path;
    private mixed $arquivo;

    public function __construct()
    {
        $server = new servidor();
        $this->path = new caminho();
        $this->arquivo = new arquivo();
        $this->url = rtrim($server->uri());

        if (!empty($this->url)) {
            if ($this->url !== '/') {
                if (file_exists($this->path->juntar($server->pastaSistema(), $this->url))) {
                    if ($this->arquivo->verificarExtensao($this->url, 'php')) {
                        include_once($this->path->juntar($server->pastaSistema(), $this->url));
                    }
                    $this->isFile = true;
                }
            }
        }
    }

    public function __toString()
    {
        return $this->encontrado;
    }

    public function naoPHP() {
        return $this->nophp;
    }

    public function obter(string $caminho, mixed $funcao = false): bool
    {
        if (!$this->isFile) {
            $sFilename = rtrim(ltrim($caminho, '/'), '/');
            $sURL = rtrim($this->url, '/');

            if ($sURL == $sFilename) {
                if (!$this->encontrado) {
                    $this->encontrado = true;
                    if (!is_bool($funcao)) {
                        $funcao();
                    }
                    return true;
                } else {
                    return false;
                }
            } else {
                if (!$this->encontrado) {
                    if ($caminho == '404') {
                        if (!is_bool($funcao)) {
                            $funcao();
                        }
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            }
        } else {
            if ($this->arquivo->verificarExtensao($this->url, 'php')) {
                return true;
            } else {
                $this->nophp = true;
                return false;
            }
        }
    }
}
