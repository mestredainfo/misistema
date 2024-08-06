<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

use MISistema\idioma\traduzir;

class funcoes
{
    private mixed $traduzir;
    private bool $sSemTag = false;

    public function __construct()
    {
        $this->traduzir = new traduzir();
    }

    private function clean()
    {
        $this->sSemTag = false;
    }

    public function semTag() {
        $this->sSemTag = true;
        return $this;
    }

    /* Exibe Alertas */
    function alerta(string $titulo, string $mensagem, string $tipo)
    {
        if (!$this->sSemTag) {
            echo '<script>';
        }

        echo sprintf("misistema.alerta('%s', '%s', '%s');", $this->traduzir->obter($titulo), $this->traduzir->obter($mensagem), $tipo);

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }

    /* Exibe Confirmação */
    function confirmacao(string $titulo, string $mensagem, string $tipo, mixed $functionContinuar, mixed $functionCancelar)
    {
        if (!$this->sSemTag) {
            echo '<script>';
        }

        echo "misistema.confirmacao('" . $this->traduzir->obter($titulo) . "', '" . $this->traduzir->obter($mensagem) . "', '$tipo').then((result) => {
        if (result) {
            ";
        $functionCancelar();
        echo "} else {";
        $functionContinuar();
        echo "}
    });";

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }

    /* Redireciona */
    function redirecionar(string $url, mixed $parametros = '')
    {
        $sParams = '?';

        if (is_array($parametros)) {
            foreach ($parametros as $name => $value) {
                $sParams .= sprintf('%s=%s&', $name, $value);
            }
        } else {
            $sParams = '';
        }

        $sParams = rtrim($sParams, '&');

        if (!$this->sSemTag) {
            echo '<script>';
        }

        echo sprintf("window.location.assign('%s%s');", $url, $sParams);

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();

        exit;
    }

    function abrirURL(string $url)
    {
        if (!$this->sSemTag) {
            echo '<script>';
        }
        echo "misistema.abrirURL('$url');";

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }

    function novaJanela(string $url, int $largura = 800, int $altura = 600, bool $redimensionar = true, bool $quadro = true, bool $menu = false, bool $ocultar = false)
    {
        $sResizable = ($redimensionar) ? 'true' : 'false';
        $sFrame = ($quadro) ? 'true' : 'false';
        $sMenu = ($menu) ? 'true' : 'false';
        $sHide = ($ocultar) ? 'true' : 'false';

        if (!$this->sSemTag) {
            echo '<script>';
        }

        echo "misistema.novaJanela('$url', $largura, $altura, $sResizable, $sFrame, $sMenu, $sHide);";

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }

    function atualizar() {
        if (!$this->sSemTag) {
            echo '<script>';
        }

        echo "window.location.reload();";

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }

    function fecharJanela()
    {
        if (!$this->sSemTag) {
            echo '<script>';
        }

        echo 'window.close();';

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }

    /* Exibe Notificação */
    function notificacao(string $titulo, string $mensagem)
    {
        if (!$this->sSemTag) {
            echo '<script>';
        }

        echo "misistema.notificacao('" . $this->traduzir->obter($titulo) . "', '" . $this->traduzir->obter($mensagem) . "');";

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }

    /* Exibe Confirmação */
    function bandeja(string $titulo, string $dica, array $itens)
    {
        $sItems = '[{}]';
        if (!empty($itens)) {
            $sItems = '[';
            foreach ($itens as $item) {
                $sItems .= '{ label: ' . $item['label'] . ', type: ' . $item['type'] . ', onclick: ' . $item['onclick'] . ' }';
            }
            $sItems .= ']';
        }

        if (!$this->sSemTag) {
            echo '<script>';
        }

        echo "misistema.bandeja('" . $this->traduzir->obter($titulo) . "', '" . $this->traduzir->obter($dica) . "');";

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }

    function exportarPDF(string $arquivo, array $opcoes = [])
    {
        $sItems = '';
        if (!empty($opcoes)) {
            $sItems = '[';
            foreach ($opcoes as $nome => $valor) {
                $sItems .= '{ ' . $nome . ':' . $valor . ' }';
            }
            $sItems .= ']';
        }

        if (!$this->sSemTag) {
            echo '<script>';
        }

        if (empty($sItems)) {
            echo "misistema.exportarPDF('" . $arquivo . "');";
        } else {
            echo "misistema.exportarPDF('" . $arquivo . "', $sItems);";
        }

        if (!$this->sSemTag) {
            echo '</script>';
        }

        $this->clean();
    }
}
