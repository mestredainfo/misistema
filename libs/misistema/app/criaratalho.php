<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

use MISistema\idioma\traduzir;
use MISistema\sistema\ambiente;
use MISistema\sistema\servidor;

class criaratalho
{
    private array $dados;

    public function nome(string $valor)
    {
        $this->dados['app']['name'] = $valor;
        return $this;
    }

    public function versao(string $valor)
    {
        $this->dados['app']['version'] = $valor;
        return $this;
    }

    public function descricao(string $valor)
    {
        $this->dados['app']['description'] = $valor;
        return $this;
    }

    // Application for presenting, creating, or processing multimedia (audio/video)
    public function catAudioVideo()
    {
        $this->dados['app']['categories'] = 'AudioVideo;';
        return $this;
    }

    // An audio application
    // Desktop entry must include AudioVideo as well
    public function catAudio()
    {
        $this->dados['app']['categories'] = 'Audio;';
        return $this;
    }

    // A video application
    // Desktop entry must include AudioVideo as well
    public function catVideo()
    {
        $this->dados['app']['categories'] = 'Video;';
        return $this;
    }

    // An application for development
    public function catDesenvolvimento()
    {
        $this->dados['app']['categories'] = 'Development;';
        return $this;
    }

    // Educational software
    public function catEducacao()
    {
        $this->dados['app']['categories'] = 'Education;';
        return $this;
    }

    // A game
    public function catJogos()
    {
        $this->dados['app']['categories'] = 'Game;';
        return $this;
    }

    // Application for viewing, creating, or processing graphics
    public function catGrafico()
    {
        $this->dados['app']['categories'] = 'Graphics;';
        return $this;
    }

    // Network application such as a web browser
    public function catRede()
    {
        $this->dados['app']['categories'] = 'Network;';
        return $this;
    }

    // An office type application
    public function catOffice()
    {
        $this->dados['app']['categories'] = 'Office;';
        return $this;
    }

    // Scientific software
    public function catCiencia()
    {
        $this->dados['app']['categories'] = 'Science;';
        return $this;
    }

    // Settings applications
    // Entries may appear in a separate menu or as part of a "Control Center"
    public function catConfiguracoes()
    {
        $this->dados['app']['categories'] = 'Settings;';
        return $this;
    }

    // System application, "System Tools" such as say a log viewer or network monitor
    public function catSistema()
    {
        $this->dados['app']['categories'] = 'System;';
        return $this;
    }

    // Small utility application, "Accessories"
    public function catUtilitarios()
    {
        $this->dados['app']['categories'] = 'Utility;';
        return $this;
    }

    private function row(string ...$names): string
    {
        $values = $this->dados;

        foreach ($names as $name) {
            $values = empty($values[$name]) ? '' : $values[$name];
        }

        return $values;
    }

    function criar()
    {
        $env = new ambiente();
        $traduzir = new traduzir();
        $server = new servidor();
        $script = new funcoes();

        $sFolder = $env->pastaUsuario() . '/.local/share/applications/';

        if (file_exists($sFolder)) {
            $tplShortcut = '[Desktop Entry]
Version={version}
Name={name}
Comment={description}
Type=Application
Exec={exec}
Icon={icon}
Categories={categories}';

            $tplShortcut = str_replace('{version}', $this->row('app', 'version'), $tplShortcut);
            $tplShortcut = str_replace('{name}', $this->row('app', 'name'), $tplShortcut);
            $tplShortcut = str_replace('{description}', $traduzir->obter($this->row('app', 'description')), $tplShortcut);
            $tplShortcut = str_replace('{exec}', str_replace('/resources/sistema', '', $server->pastaSistema()) . "/" . str_replace(' ', '', strtolower($this->row('app', 'name'))), $tplShortcut);
            $tplShortcut = str_replace('{icon}', $server->pastaSistema() . "/icon/" . str_replace(' ', '', strtolower($this->row('app', 'name'))) . ".png", $tplShortcut);
            $tplShortcut = str_replace('{categories}', $this->row('app', 'categories'), $tplShortcut);

            $arquivo = new arquivo();
            if ($arquivo->existe($sFolder . '/' . str_replace(' ', '', strtolower($this->row('app', 'name'))) . '.desktop')) {
                $arquivo->excluir($sFolder . '/' . str_replace(' ', '', strtolower($this->row('app', 'name'))) . '.desktop');
            }

            $sCreateFile = $arquivo->salvar($sFolder . '/' . str_replace(' ', '', strtolower($this->row('app', 'name'))) . '.desktop', $tplShortcut);
            if ($sCreateFile) {
                $script->alerta($traduzir->obter('Informação %s', $this->row('app', 'name')), 'Atalho criado no menu iniciar', 'info');
            } else {
                $script->alerta($traduzir->obter('Informação %s', $this->row('app', 'name')), 'Não foi possível criar o atalho no menu iniciar!', 'error');
            }
        } else {
            $script->alerta($traduzir->obter('Informação %s', $this->row('app', 'name')), 'Não foi possível criar o atalho no menu iniciar!', 'error');
        }

        $script->fecharJanela();
    }
}
