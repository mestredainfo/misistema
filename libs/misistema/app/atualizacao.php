<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

use MISistema\idioma\traduzir;

class atualizacao
{
    private array $dados = [];

    public function nome(string $nome)
    {
        $this->dados['name'] = $nome;
        return $this;
    }

    public function url(string $url)
    {
        $this->dados['url'] = $url;
        return $this;
    }

    public function versao(string $versao)
    {
        $this->dados['version'] = $versao;
        return $this;
    }

    public function exibir()
    {
        $this->dados['show'] = true;
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

    function verificar()
    {
        $traduzir = new traduzir();

        try {
            $script = new funcoes();

            if ($this->row('show')) {
                echo $traduzir->obter('Verificando atualizações...');
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->row('url'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $html = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception($traduzir->obter('Erro ao buscar os dados: %s', curl_error($ch)));
            }

            curl_close($ch);

            preg_match('/<span id="appversion">(.*?)<\/span>/', $html, $matches);

            if (!empty($matches[1])) {
                $versaonova = $matches[1];

                if (version_compare($versaonova, $this->row('version'), '>')) {
                    $script->confirmacao($traduzir->obter('Atualização do %s', $this->row('name')), $traduzir->obter('A versão %s já está disponível, deseja baixar a nova versão?', $versaonova), 'question', function () use ($script) {
                        $script->semTag()->abrirURL($this->row('url'));
                        if ($this->row('show')) {
                            $script->semTag()->fecharJanela();
                        }
                    }, function () use ($script) {
                        if ($this->row('show')) {
                            $script->semTag()->fecharJanela();
                        }
                    });
                } else {
                    if ($this->row('show')) {
                        $script->alerta($traduzir->obter('Atualização do %s', $this->row('name')), $traduzir->obter('O %s já está na versão mais recente.', $this->row('name')), 'info');
                        $script->fecharJanela();
                    }
                }
            }
        } catch (\Exception $error) {
            echo $traduzir->obter('Erro ao buscar os dados: %s', $error->getMessage());
        }
    }
}
