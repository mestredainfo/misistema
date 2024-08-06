<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\dados;

class inserir extends database
{
    public function gerar()
    {
        try {
            $sql = 'INSERT INTO ' . $this->sTable[0] . ' (';

            foreach ($this->sValores as $row) {
                $sql .= $row['nome'] . ',';
            }

            $sql = rtrim($sql, ',');

            $sql .= ') VALUES (';

            if ($this->sPrepare) {
                foreach ($this->sValores as $row) {
                    $sql .= ':' . $row['nome'] . ',';
                }
            } else {
                foreach ($this->sValores as $row) {
                    $sql .= "'{$row['valor']}',";
                }
            }

            $sql = rtrim($sql, ',');

            $sql .= ')';

            if ($this->sPrepare) {
                if ($this->sResult = $this->sConecta->prepare($sql)) {
                    foreach ($this->sValores as $row) {
                        $this->sResult->bindParam(':' . $row['nome'], $row['valor']);
                    }

                    $this->sResult->execute();

                    $this->sFechaResult = true;
                } else {
                    $this->sFechaResult = false;
                }
            } else {
                $this->sConecta->query($sql);
                $this->sFechaResult = false;
            }
        } catch (\SQLite3Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function executar()
    {
        $this->sResult->execute();
        
    }

    function idInserido(): int
    {
        return $this->sConecta->lastInsertRowID();
    }
}
