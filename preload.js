// Copyright (C) 2004-2024 Murilo Gomes Julio
// SPDX-License-Identifier: GPL-2.0-only

// Mestre da Info
// Site: https://www.mestredainfo.com.br

const { contextBridge, ipcRenderer } = require('electron')

ipcRenderer.setMaxListeners(20);

// MISistema
contextBridge.exposeInMainWorld('misistema', {
    versao: (type) => ipcRenderer.invoke('appVersao', type),
    alerta: (title, msg, type, ...buttons) => ipcRenderer.invoke('appMessage', title, msg, type, ...buttons),
    confirmacao: (title, msg, type, ...buttons) => ipcRenderer.invoke('appConfirm', title, msg, type, ...buttons),
    novaJanela: (url, width, height, resizable, frame, menu, hide) => ipcRenderer.invoke('appNewWindow', url, width, height, resizable, frame, menu, hide),
    abrirURL: (url) => ipcRenderer.invoke('appExterno', url),
    traduzir: (text, ...values) => ipcRenderer.invoke('appTraduzir', text, ...values),
    selecionarDiretorio: () => ipcRenderer.invoke('selecionarDiretorio'),
    abrirArquivo: () => ipcRenderer.invoke('abrirArquivo'),
    salvarArquivo: () => ipcRenderer.invoke('salvarArquivo'),
    post: (url, dados) => ipcRenderer.invoke('appPost', url, dados),
    listPost: (listener) => ipcRenderer.on('list:post', (event, ...args) => listener(...args) + ipcRenderer.removeListener('list:post')),
    notificacao: (title, text) => ipcRenderer.invoke('appNotification', title, text),
    bandeja: (title, tooltip, icon, menu) => ipcRenderer.invoke('appTray', title, tooltip, icon, menu),
    exportarPDF: (filename, options) => ipcRenderer.invoke('appExportPDF', filename, options),
    exec: (command) => ipcRenderer.invoke('appExec', command),
    listExec: (listener) => ipcRenderer.on('list:exec', (event, ...args) => listener(...args) + ipcRenderer.removeListener('list:exec')),
});