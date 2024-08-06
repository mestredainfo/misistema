<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

class vetor
{
    private $sVetores = [];

    /* Verifica Arrays */
    public function verificar(string $keyword, mixed $values): bool
    {
        $a = is_array($values) ? $values : array($values);

        foreach ($a as $query) {
            if (strpos($keyword, $query, 0) !== false) {
                return true;
            }
        }

        return false;
    }

    /* Exibe arrays formatados com tag pre */
    public function exibir(array $valores)
    {
        printf('<pre>%s</pre>', print_r($valores, true));
    }

    // Ler Vetores
    public function vetores(array $valores)
    {
        $this->sVetores = $valores;
    }

    private function get($valores, string ...$nomes): mixed
    {
        $sValor = $valores;

        foreach ($nomes as $value) {
            $sValor = (empty($sValor[$value])) ? '' : $sValor[$value];
        }

        return $sValor;
    }

    public function customObter(array $valores = [], string ...$nomes): mixed
    {
        return $this->get($valores, ...$nomes);
    }

    public function obter(string ...$nomes): mixed
    {
        return $this->get($this->sVetores, ...$nomes);
    }
}
