<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\sistema;

use MISistema\seguranca\itens;

class servidor
{
    private mixed $itens;

    public function __construct()
    {
        $this->itens = new itens();
    }

    public function dominio(): string
    {
        return sprintf('http://%s:%s', $this->itens->limpar($_SERVER['SERVER_NAME']), $this->itens->limpar($_SERVER['SERVER_PORT']));
    }

    public function uri(): string
    {
        $sRequestURI = $this->itens->limpar($_SERVER['REQUEST_URI']);
        $txt = explode('?', $sRequestURI);
        return empty($txt[0]) ? '' : ltrim($txt[0], '/');
    }

    public function pastaSistema(): string
    {
        return $this->itens->limpar($_SERVER['DOCUMENT_ROOT']);
    }

    public function ipUsuario(): string
    {
        $txt = '';

        if ($_SERVER['HTTP_CLIENT_IP']) {
            $txt = $this->itens->limpar($_SERVER['HTTP_CLIENT_IP']);
        } else if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            $txt = $this->itens->limpar($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else if ($_SERVER['HTTP_X_FORWARDED']) {
            $txt = $this->itens->limpar($_SERVER['HTTP_X_FORWARDED']);
        } else if ($_SERVER['HTTP_FORWARDED_FOR']) {
            $txt = $this->itens->limpar($_SERVER['HTTP_FORWARDED_FOR']);
        } else if ($_SERVER['HTTP_FORWARDED']) {
            $txt = $this->itens->limpar($_SERVER['HTTP_FORWARDED']);
        } else if ($_SERVER['REMOTE_ADDR']) {
            $txt = $this->itens->limpar($_SERVER['REMOTE_ADDR']);
        } else {
            $txt = 'naoEncontrado';
        }

        return $txt;
    }
}
