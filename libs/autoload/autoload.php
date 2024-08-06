<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\autoload;

class autoload
{
    private array $classes = [];

    public function __construct()
    {
        spl_autoload_register(array($this, 'carregarClasses'));
    }

    public function setNamespace(string $nome, string $pasta) {
        if (empty($this->classes[$nome])) {
            $this->classes[$nome] = $pasta;
        }
    }

    public function carregarClasses(mixed $classe)
    {
        $a = explode('\\', $classe);
        $s = str_replace([$a[0], '\\'], ['', '/'], $classe);
        $sArquivo = $this->classes[$a[0]] . $s . '.php';
        
        $this->incluir($sArquivo);
    }

    public function incluir(string $arquivo) {
        if (file_exists($arquivo)) {
            include_once($arquivo);
        }
    }
}

$miAutoLoad = new autoload();
$miAutoLoad->setNamespace('MISistema', dirname(__FILE__, 2) . '/misistema');
