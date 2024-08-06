// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

const { app, BrowserWindow, Menu, MenuItem } = require('electron');
const path = require('path');
const fs = require('fs');
const sOS = require('os');
const { spawn } = require('child_process');
const sHttp = require('http');

const sPlataform = sOS.platform().toLowerCase();
const miSistemaPath = app.getAppPath().replace('app.asar', '');

const milangs = require(path.join(app.getAppPath(), '/milang.js'));
const milang = new milangs(miSistemaPath);

if (milang.getNotFound()) {
    console.error('Arquivo "en.json" não foi encontrado!');
    app.quit();
    return false;
}

process.on('uncaughtException', (error) => {
    console.error(milang.traduzir('Exceção não tratada:'), error);
});

if (!fs.existsSync(path.join(miSistemaPath, '/sistema/config.json'))) {
    console.log(milang.traduzir('Não foi possível encontrar o arquivo %s', '"config.json"'));

    app.quit();
    return false;
}

const config = JSON.parse(fs.readFileSync(path.join(miSistemaPath, '/sistema/config.json'), 'utf-8'));

if (config.sistema.desativarAceleracaoHardware) {
    app.disableHardwareAcceleration();
}

if (config.sistema.nome) {
    app.setName(config.sistema.nome);
}

let sServerName;
let miServidorProcess;
let sPort;

function createMenu(sWin) {
    fs.readFile(path.join(miSistemaPath, '/sistema/menu.json'), (err, data) => {
        if (err) {
            console.error(milang.traduzir('Erro ao ler o arquivo JSON'), err);
            return;
        }

        const menuData = JSON.parse(data);

        // Cria o menu principal
        const mainMenu = Menu.buildFromTemplate(getMenuTemplate(sWin, menuData, true));
        sWin.setMenu(mainMenu);
    });
}

const createWindow = () => {
    const win = new BrowserWindow({
        width: config.sistema.largura,
        height: config.sistema.altura,
        resizable: config.sistema.redimensionar,
        frame: config.sistema.quadro,
        icon: path.join(miSistemaPath, '/sistema/icon/', config.sistema.icon),
        webPreferences: {
            preload: path.join(app.getAppPath(), '/preload.js'),
        }
    });
    win.setMenu(null);
    startMIServidor(win);

    createMenu(win);

    if (config.dev.ferramentas) {
        win.webContents.openDevTools();
    }

    win.webContents.setWindowOpenHandler(({ url }) => {
        if (url !== '') {
            miSistemaNewWindow(url);

            return { action: 'deny' }
        }

        return { action: 'allow' }
    });

    app.on("browser-window-created", (e, win) => {
        if (config.dev.ferramentas) {
            win.webContents.openDevTools();
        }

        if (!config.dev.menu) {
            win.removeMenu();
        }
    });

    createMenuContext(win);

    const mifunctions = require(path.join(app.getAppPath(), '/mifunctions.js'));
    mifunctions.mifunctions(milang, miSistemaNewWindow);
}

// Aplica permissão de execução para o MIServidor
function perm(arquivo) {
    if (config.servidor.perm) {
        spawn('chmod', ['+x', arquivo]);
        config.servidor.perm = false;

        fs.writeFileSync(path.join(miSistemaPath, '/sistema/config.json'), JSON.stringify(config, '', "\t"));

        console.log(milang.traduzir('Aplicado permissão de execução para o %s', path.basename(arquivo)));
    }
}

// Inicia o MIServidor
function startMIServidor(win) {
    let sMIServidor;

    if (sPlataform == 'linux') {
        sMIServidor = path.join(miSistemaPath, '/miservidor/miservidor');
        perm(sMIServidor);
    } else {
        app.quit();
    }

    // Environment
    process.env.MISISTEMA_NOME_USUARIO = sOS.userInfo().username;
    process.env.MISISTEMA_PASTA_USUARIO = sOS.userInfo().homedir;
    process.env.MISISTEMA_PASTA = path.join(miSistemaPath, '/sistema');

    let sArgs = process.argv;
    let sArgv = '';
    if (sArgs[1] == '.') {
        sArgv = sArgs.slice(2).toString();
    } else {
        sArgv = sArgs.slice(1).toString();
    }
    process.env.MISISTEMA_ARGUMENTOS = sArgv;

    // Servidor
    let sCreateServer = sHttp.createServer();
    let sListen = sCreateServer.listen();
    sPort = sListen.address().port;
    sListen.close();
    sCreateServer.close();

    miServidorProcess = spawn(sMIServidor, ['php-server', sPort, miSistemaPath], { cwd: process.env.HOME, env: process.env });

    miServidorProcess.on('error', (err) => {
        console.error(milang.traduzir('Erro ao iniciar o servidor:'), err);
    });

    miServidorProcess.on('close', (code) => {
        console.log(milang.traduzir('O servidor foi encerrado com o código:'), code);
    });

    const checkPortL = setInterval(() => {
        let lsof = spawn('lsof', ['-ti:' + sPort]);

        lsof.stdout.on('data', (data) => {
            console.log(milang.traduzir('Servidor foi iniciado com sucesso.'));
            sServerName = `http://localhost:${sPort}/`;
            win.loadURL(sServerName);
            clearInterval(checkPortL);
        });

        lsof.stderr.on('data', (data) => {
            console.error(milang.traduzir('Erro ao executar lsof:'), data);
        });

        lsof.on('close', (code) => {
            if (code !== 0) {
                console.error(milang.traduzir('lsof saiu com código de erro'), code);
            }
        });
    }, 1000);

    miServidorProcess.unref(); // Permite que o aplicativo seja fechado sem fechar o processo do servidor
}

// Nova Janela
function miSistemaNewWindow(url, width, height, resizable, frame, menu, hide) {
    let sWidth = (width) ? width : config.sistema.largura;
    let sHeight = (height) ? height : config.sistema.altura;
    let sResizable = (resizable == true || resizable == false) ? resizable : config.sistema.redimensionar;
    let sFrame = (frame == true || frame == false) ? frame : config.sistema.quadro;
    let sMenu = (menu == true || menu == false) ? menu : true;
    let sHide = (hide == true || hide == false) ? hide : false;

    const sNewWindow = new BrowserWindow({
        width: sWidth,
        height: sHeight,
        resizable: sResizable,
        frame: sFrame,
        icon: path.join(miSistemaPath, '/sistema/icon/', config.sistema.icon),
        webPreferences: {
            preload: path.join(app.getAppPath(), '/preload.js'),
        }
    });

    if (sHide) {
        sNewWindow.hide();
    }

    sNewWindow.setMenu(null);
    sNewWindow.loadURL(`${sServerName}/${url.replace(sServerName, '')}`);

    createMenuContext(sNewWindow);

    sNewWindow.webContents.setWindowOpenHandler(({ url }) => {
        if (url !== '') {
            miSistemaNewWindow(`${url}`);

            return { action: 'deny' }
        }

        return { action: 'allow' }
    });

    if (sMenu) {
        createMenu(sNewWindow);
    }
}

// Template de Menu
function getMenuTemplate(win, menuData) {
    let template = [];

    if (config.dev.menu) {
        let devMenu = {
            label: milang.traduzir('Desenvolvedor'),
            submenu: [
                {
                    label: milang.traduzir('Atualizar'),
                    accelerator: 'F5',
                    click: () => {
                        win.reload();
                    }
                },
                {
                    type: 'separator'
                },
                {
                    label: milang.traduzir('Ferramentas do Desenvolvedor'),
                    accelerator: 'F12',
                    click: () => {
                        win.openDevTools();
                    }
                }
            ],
        }

        template.push(devMenu);

        let helpMenu = {
            label: milang.traduzir('Ajuda'),
            submenu: [
                {
                    label: milang.traduzir('Documentação'),
                    accelerator: 'F1',
                    click: () => {
                        require('electron').shell.openExternal('https://www.mestredainfo.com.br/2024/07/documentacao-misistema.html');
                    }
                },
                {
                    type: 'separator'
                },
                {
                    label: milang.traduzir('Site do Mestre da Info'),
                    click: () => {
                        require('electron').shell.openExternal('https://www.mestredainfo.com.br');
                    }
                },
                {
                    label: milang.traduzir('YouTube do Mestre da Info'),
                    click: () => {
                        require('electron').shell.openExternal('https://www.youtube.com/@mestredainfo');
                    }
                },
                {
                    label: milang.traduzir('Relatar Problema'),
                    click: () => {
                        require('electron').shell.openExternal('https://www.mestredainfo.com.br/p/relatorio-de-bug.html');
                    }
                },
                {
                    type: 'separator'
                },
                {
                    label: milang.traduzir('Verificar Atualização'),
                    click: () => {
                        require('electron').shell.openExternal('https://www.mestredainfo.com.br/2024/07/misistema.html');
                    }
                },
                {
                    type: 'separator'
                },
                {
                    label: milang.traduzir('Apoie o MISistema'),
                    click: () => {
                        require('electron').shell.openExternal('https://www.mestredainfo.com.br/p/apoie.html');
                    }
                },
                {
                    type: 'separator'
                },
                {
                    label: milang.traduzir('Sobre o MISistema'),
                    click: () => {
                        require('electron').shell.openExternal('https://www.mestredainfo.com.br/2024/07/misistema.html');
                    }
                },
            ]
        }

        template.push(helpMenu);
    }

    // Loop sobre as chaves do objeto JSON
    Object.keys(menuData).forEach((key) => {
        let submenu = [];

        // Loop sobre os itens do submenu
        Object.keys(menuData[key]).forEach((submenuKey) => {
            let menuItem = {};

            if (submenuKey.indexOf('separador') == 0) {
                menuItem = { type: 'separator' };
            } else {
                menuItem = {
                    label: milang.traduzir(submenuKey),
                    accelerator: menuData[key][submenuKey].atalho,
                    click: () => {
                        // Verifica se é uma página ou URL
                        if (menuData[key][submenuKey].pagina) {
                            if (menuData[key][submenuKey].novajanela) {
                                miSistemaNewWindow(menuData[key][submenuKey].pagina, menuData[key][submenuKey].largura, menuData[key][submenuKey].altura, menuData[key][submenuKey].redimensionar, menuData[key][submenuKey].quadro, menuData[key][submenuKey].menu, menuData[key][submenuKey].ocultar)
                            } else {
                                win.loadURL(sServerName + menuData[key][submenuKey].pagina);
                            }
                        } else if (menuData[key][submenuKey].url) {
                            require('electron').shell.openExternal(menuData[key][submenuKey].url);
                        } else if (menuData[key][submenuKey].script) {
                            win.webContents.executeJavaScript(menuData[key][submenuKey].script);
                        }
                    }
                };
            }

            submenu.push(menuItem);
        });

        // Adiciona o submenu ao item do menu principal
        template.push({ label: milang.traduzir(key), submenu });
    });

    return template;
}

function createMenuContext(win) {
    const contextMenu = new Menu();
    contextMenu.append(new MenuItem({
        label: milang.traduzir('Recortar'),
        role: 'cut'
    }));
    contextMenu.append(new MenuItem({
        label: milang.traduzir('Copiar'),
        role: 'copy'
    }));
    contextMenu.append(new MenuItem({
        label: milang.traduzir('Colar'),
        role: 'paste'
    }));
    contextMenu.append(new MenuItem({
        type: "separator"
    }));
    contextMenu.append(new MenuItem({
        label: milang.traduzir('Selecionar Tudo'),
        role: 'selectall'
    }));

    win.webContents.on('context-menu', (event, params) => {
        if (params.formControlType == 'input-text' || params.formControlType == 'text-area') {
            contextMenu.popup({
                window: win,
                x: params.x,
                y: params.y
            });
        }
    });
}

// Função para encerrar o processo com base na porta
function killProcessByPort(port) {
    let miServidorClose;
    if (sPlataform == 'linux') {
        miServidorClose = spawn('lsof', ['-ti:' + port, '|', 'xargs', 'kill'], { shell: true });

        miServidorClose.stderr.on('data', (data) => {
            console.log(milang.traduzir('Erro ao encerrar o processo na porta:'), sPort);
            return;
        });

        miServidorClose.on('error', (err) => {
            console.error(milang.traduzir('Erro ao encerrar o processo na porta:'), port, err.message);
            return;
        });

        miServidorClose.on('close', (code) => {
            console.log(milang.traduzir('O servidor foi encerrado com o código:'), code);
            return;
        });

        console.log(milang.traduzir('Processo na porta'), port, milang.traduzir('encerrado com sucesso.'));
    }
}

function stopMIServidor() {
    if (miServidorProcess) {
        killProcessByPort(sPort); // Encerra todos os processos do servidor que estão sob a mesma porta
        console.log(milang.traduzir('Servidor parado.'));
    }
}

app.whenReady().then(() => {
    createWindow()

    // Enquanto os aplicativos do Linux são encerrados quando não há janelas abertas, os aplicativos do macOS geralmente continuam em execução mesmo sem nenhuma janela aberta, e ativar o aplicativo quando não há janelas disponíveis deve abrir um novo.
    app.on('activate', () => {
        if (BrowserWindow.getAllWindows().length === 0) createWindow()
    });
});

// Para sair do aplicativo no Linux
// Se for MACOS não roda esse comando
app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
        stopMIServidor();
        app.quit();
    }
});

app.on('before-quit', () => {
    stopMIServidor();
});
