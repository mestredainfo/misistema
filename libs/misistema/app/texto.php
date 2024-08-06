<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

class texto
{
    public function removerAcentos(string $valor): string
    {
        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
        return str_replace($array1, $array2, $valor);
    }

    /* Remover caracteres especiais de um texto */
    public function removerCaracteresEspeciais(string $valor): string
    {
        $array1 = array("$", "@", "%", "&", "*", "/", "+", "#");
        $array2 = array("", "", "", "", "", "", "", "");
        return str_replace($array1, $array2, $valor);
    }

    public function separador(string $valor, string $separador = '-'): string {
        $txt = $this->removerAcentos($valor);
        $txt = $this->removerCaracteresEspeciais($txt);
        $txt = str_replace([' ', '&nbsp;'], $separador, $txt);
        return $txt;
    }
}
