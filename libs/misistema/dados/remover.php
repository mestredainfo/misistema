<?php
// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

namespace MISistema\dados;

class remover extends database
{
    public function gerar()
    {
        try {
            $sql = 'DELETE FROM ' . $this->sTable[0];
            $sql .= $this->getWhere();

            if ($this->sPrepare) {
                if ($this->sResult = $this->sConecta->prepare($sql)) {
                    foreach ($this->sWhere as $row) {
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
}
