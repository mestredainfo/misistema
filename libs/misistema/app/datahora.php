<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

class datahora
{
    public function data(): string
    {
        return date('d/m/Y');
    }

    public function hora(): string
    {
        return date('H:i:s');
    }

    public function agora(): string
    {
        return date('d/m/Y') . ' ' . date('H:i:s');
    }

    public function alterar(string $data, string $formato = 'd/m/Y', string $novoformato = 'Y-m-d'): string
    {
        $data = \DateTime::createFromFormat($formato, $data);
        $txt = $data->format($novoformato);
        return $txt;
    }

    public function diaSemana(string $data): string
    {
        $diasemana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
        $valor = date('w', strtotime($data));
        return $diasemana[$valor];
    }

    public function mesExtenso(int $mes): string
    {
        $meses = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
        $valor = ltrim($mes, '0');
        return $meses[$valor];
    }
}
