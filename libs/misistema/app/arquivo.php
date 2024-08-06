<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

class arquivo
{
    public function verificarExtensao(string $filename, string $ext = ''): bool
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if (empty($ext)) {
            return (empty($extension)) ? false : true;
        } else {
            return ($ext == $extension) ? true : false;
        }
    }

    public function existe(string $nome): bool
    {
        return file_exists($nome);
    }

    public function criar(string $nome): bool
    {
        return touch($nome);
    }

    public function abrir(string $arquivo): string|bool
    {
        return file_get_contents($arquivo);
    }

    public function salvar(string $arquivo, string $texto, bool $substituir = true): int|bool
    {
        if ($substituir) {
            return file_put_contents($arquivo, $texto);
        } else {
            return file_put_contents($arquivo, $texto, FILE_APPEND);
        }
    }

    public function excluir(string $arquivo)
    {
        return unlink($arquivo);
    }
}
