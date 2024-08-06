<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\seguranca;

class senha
{
    private int $sQuantidade = 7;
    private bool $sMinusculo = true;
    private bool $sMaiusculo = true;
    private bool $sNumeros = true;
    private bool $sCaracteresEspeciais = true;
    private string|int $sHash = PASSWORD_DEFAULT;

    public const MD5 = 'md5';
    public const SHA1 = 'SHA1';
    public const SHA256 = 'SHA256';
    public const SHA512 = 'SHA512';

    public function quantidade(int $valor) {
        $this->sQuantidade = $valor;
    }

    public function minusculo() {
        $this->sMinusculo = true;
    }

    public function maiusculo() {
        $this->sMaiusculo = true;
    }

    public function numeros() {
        $this->sNumeros = true;
    }

    public function caracteresEspeciais() {
        $this->sCaracteresEspeciais = true;
    }

    public function hash(string|int $valor = PASSWORD_DEFAULT) {
        $this->sHash = $valor;
    }

    public function gerar(): array
    {
        $caracteres = '';
        $txt = '';

        $caracteres .= ($this->sMinusculo) ? 'abcdefghijklmnopqrstuvwxyz' : '';
        $caracteres .= ($this->sMaiusculo) ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : '';
        $caracteres .= ($this->sMaiusculo) ? '1234567890' : '';
        $caracteres .= ($this->sCaracteresEspeciais) ? '!@#$%*-' : '';

        $sTamanho = strlen($caracteres);

        for ($n = 1; $n <= $this->sQuantidade; $n++) {
            $valor = mt_rand(1, $sTamanho);
            $txt .= $caracteres[$valor - 1];
        }

        $a['senha'] = $txt;
        
        if ($this->sHash == 'md5') {
            $a['hash'] = md5($txt);
        } else if ($this->sHash == 'SHA1') {
            $a['hash'] = sha1($txt);
        } else if ($this->sHash == 'SHA256') {
            $a['hash'] = hash('sha256', $txt);
        } else if ($this->sHash == 'SHA512') {
            $a['hash'] = hash('sha512', $txt);
        } else {
            if ($this->sHash == PASSWORD_DEFAULT) {
                $a['hash'] == password_hash($txt, PASSWORD_DEFAULT);
            } else {
                $a['hash'] == password_hash($txt, $this->sHash);
            }
        }

        return $a;
    }
}
