<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\app;

use MISistema\idioma\traduzir;
use MISistema\sistema\servidor;

class sobre
{
  private mixed $traduzir;
  private array $dados = [];

  public function __construct()
  {
    $this->traduzir = new traduzir();
  }

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

  public function autor(string $nome, string $organizacao = '')
  {
    $this->dados['author']['name'] = $nome;
    $this->dados['author']['organization'] = $organizacao;
    return $this;
  }

  public function paginainicial(string $url)
  {
    $this->dados['app']['homepage'] = $url;
    return $this;
  }

  public function copyright(string $ano, string $nome)
  {
    $this->dados['app']['copyright'] = 'Copyright (C) ' . $ano . ' ' . $nome;
    return $this;
  }

  private function row(string ...$nomes): string
  {
    $values = $this->dados;

    foreach ($nomes as $name) {
      $values = empty($values[$name]) ? '' : $values[$name];
    }

    return $values;
  }

  public function licenca(string $nome, string $topo, string $texto): string
  {
    $styleButton = 'background-color: #79b7c8;
        color: #003470;
        cursor: pointer;
        padding: 18px;
        width: 97%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        font-weight: bold;margin-top:7px';

    $styleContent = 'padding: 0 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;padding: 7px;';

    $sTopo = '';
    if (!empty($topo)) {
      $sTopo = nl2br('--------------------------------------------------------------------
          ' . $topo . '
          --------------------------------------------------------------------
          ');
    }
    $txt = '<button class="collapsible" type="button" style="' . $styleButton . '">' .
      $nome . ' (' . $this->traduzir->obter('ver informações') . ')
</button>
<div class="content" style="' . $styleContent . '">' . $sTopo . nl2br('

<strong>' . $this->traduzir->obter('Licença:') . '</strong>

') . nl2br(str_replace(['<', '>', ' '], ['&lt;', '&gt;', '&nbsp;'], $texto)) . '
</div>';

    return $txt;
  }

  // Sobre o App
  public function exibir($texto = '')
  {
    $txt = '<h1>' . $this->traduzir->obter('Sobre o ') . $this->row('app', 'name') . '</h1>
<p>' . $this->row('app', 'name') . ' ' . $this->row('app', 'version') . '</p>
<p>' . $this->traduzir->obter('Desenvolvido por:') . ' ' . $this->row('author', 'name')  . '</p>
<p>' . $this->traduzir->obter('Organização:') . ' ' . $this->row('author', 'organization') . '</p>
<p>Site: <a href="javascript:misistema.abrirURL(\'' . $this->row('app', 'homepage') . '\');">' . str_replace(['http://', 'https://'], '', $this->row('app', 'homepage')) . '</a></p>

<p>' . $this->row('app', 'copyright') . '</p>

<p>' . $this->traduzir->obter('Licença:') . ' GPL-2.0-only' . '</p>

<hr class="border border-primary border-3 opacity-75">

<h3>' . $this->traduzir->obter('Recursos de Terceiros Utilizados') . '</h3>';

    $arquivo = new arquivo();
    $caminho = new caminho();
    $server = new servidor();

    $misistemalicense = str_replace('/sistema', '', $server->pastaSistema());
    $electronlicense = str_replace('/resources/sistema', '', $server->pastaSistema());
    $phplicense = str_replace('/sistema', '/php', $server->pastaSistema());

    if ($arquivo->existe($caminho->juntar($misistemalicense) . '/LICENSE')) {
      $txt .= $this->licenca(
        'MISistema',
        'Copyright (C) 2004-2024 Murilo Gomes Julio
SPDX-License-Identifier: GPL-2.0-only

Mestre da Info
Site: <a href="javascript:misistema.abrirURL(\'https://www.mestredainfo.com.br\');">www.mestredainfo.com.br</a>',
        $arquivo->abrir($caminho->juntar($misistemalicense) . '/LICENSE')
      );
    }

    if ($arquivo->existe($caminho->juntar($electronlicense) . '/LICENSE')) {
      $txt .= $this->licenca('Electron', 'Site: <a href="javascript:misistema.abrirURL(\'https://www.electronjs.org\');">www.electronjs.org</a>', $arquivo->abrir($caminho->juntar($electronlicense) . '/LICENSE'));
    }

    if ($arquivo->existe($caminho->juntar($phplicense) . '/LICENSE')) {
      $txt .= $this->licenca('PHP', 'Site: <a href="javascript:misistema.abrirURL(\'https://www.php.net\');">https://www.php.net</a>', $arquivo->abrir($caminho->juntar($phplicense) . '/LICENSE'));
    }

    $txt .= $texto;

    $txt .= '<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
</script>';

    echo $txt;
  }
}
