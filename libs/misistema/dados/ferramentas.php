<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\dados;

class ferramentas extends database
{
    public bool $ctInteger = false;
    public bool $ctNull = false;
    public bool $ctPrimaryKey = false;
    public bool $ctAutoIncrement = false;
    public string $ctDefaultValue = '';

    private array $ctColumn = [];

    public function inteiro()
    {
        $this->ctInteger = true;
        return $this;
    }

    public function nulo()
    {
        $this->ctNull = true;
        return $this;
    }

    public function chavePrimaria()
    {
        $this->ctPrimaryKey = true;
        return $this;
    }

    public function autoIncrementar()
    {
        $this->ctAutoIncrement = true;
        return $this;
    }

    public function valorPadrao(string $value)
    {
        $this->ctDefaultValue = $value;
        return $this;
    }

    public function inserirColuna(string $name)
    {
        $sql = $name;

        if ($this->ctInteger) {
            $sql .= ' INTEGER';
        } else {
            $sql .= ' TEXT';
        }

        if ($this->ctNull) {
            $sql .= ' NULL';
        } else {
            $sql .= ' NOT NULL';
        }

        if ($this->ctPrimaryKey) {
            $sql .= ' PRIMARY KEY';
        }

        if ($this->ctAutoIncrement) {
            $sql .= ' AUTOINCREMENT';
        }

        $this->ctColumn[] = $sql;

        $this->ctInteger = false;
        $this->ctNull = false;
        $this->ctPrimaryKey = false;
        $this->ctAutoIncrement = false;
        $this->ctDefaultValue = false;
        return $this;
    }

    public function criar()
    {
        try {
            $sql = 'CREATE TABLE IF NOT EXISTS ';
            $sql .= $this->sTable[0] . ' (';
            $sql .= implode(',', $this->ctColumn);
            $sql .= ');';

            $this->sConecta->exec($sql);
        } catch (\SQLite3Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function exec(string $sql)
    {
        $this->sConecta->exec($sql);
    }
}
