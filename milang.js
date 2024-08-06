// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

module.exports = class milang {
    constructor(dirapp) {
        const fs = require('fs');
        const path = require('path');

        let aLang = '';
        this.notfound = false;

        aLang = (process.env.LANG || process.env.LANGUAGE || process.env.LC_ALL || process.env.LC_MESSAGES).split('.')[0].split('_')[0];

        if (!fs.existsSync(path.join(dirapp, '/sistema/idiomas/en.json'))) {
            this.notfound = true;
        } else {
            process.env.MISISTEMA_IDIOMA = aLang;

            // Idioma do App
            let sPath = path.join(dirapp, '/sistema/idiomas/', `${aLang}.json`);

            if (fs.existsSync(sPath)) {
                this.sLangApp = JSON.parse(fs.readFileSync(sPath), 'utf-8');
            } else {
                if (fs.existsSync(path.join(dirapp, '/sistema/idiomas/en.json'))) {
                    this.sLangApp = JSON.parse(fs.readFileSync(path.join(dirapp, '/sistema/idiomas/en.json'), 'utf-8'));
                } else {
                    this.sLangApp = [];
                }
            }
        }
    }

    getNotFound() {
        return this.notfound;
    }
    
    traduzir(texto, ...values) {
        return (this.sLangApp[texto]) ? require('util').format(this.sLangApp[texto], ...values) : require('util').format(texto, ...values);
    }
}