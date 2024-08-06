<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

class pasta
{
    private mixed $caminho;

    public function __construct()
    {
        $this->caminho = new caminho();
    }
    public function criar(string $diretorio, int $permissao = 0777, bool $recursivo = true): bool
    {
        return mkdir($diretorio, $permissao, $recursivo);
    }

    private function excluirRecursivamente(string $diretorio): bool
    {
        $arquivos = scandir($diretorio);

        foreach ($arquivos as $arquivo) {
            if ($arquivo !== '.' && $arquivo !== '..') {
                if (is_dir($this->caminho->juntar($diretorio . '/' . $arquivo))) {
                    $this->excluirRecursivamente($this->caminho->juntar($diretorio . '/' . $arquivo) . '/');
                } else {
                    unlink($this->caminho->juntar($diretorio . '/' . $arquivo));
                }
            }
        }

        return rmdir($this->caminho->juntar($diretorio . '/'));
    }

    public function excluir(string $diretorio, bool $recursivo = false)
    {
        if ($recursivo) {
            return $this->excluirRecursivamente($diretorio);
        } else {
            return rmdir($diretorio);
        }
    }

    public function existe(string $nome): bool
    {
        return file_exists($nome);
    }
}
