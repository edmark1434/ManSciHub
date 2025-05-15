const { spawn } = require('child_process');
const path = require('path');
const { app, BrowserWindow } = require('electron');

let phpServer;

function startPHPServer() {
  const phpPath = 'php'; // change to full path if needed (e.g., 'C:/xampp/php/php.exe')
  const serverScript = path.join(__dirname, 'index.php');
  phpServer = spawn(phpPath, ['-S', 'localhost:8000', serverScript]);

  phpServer.stdout.on('data', (data) => console.log(`PHP: ${data}`));
  phpServer.stderr.on('data', (data) => console.error(`PHP Error: ${data}`));
}

function createWindow() {
  const win = new BrowserWindow({
    width: 1400,
    height: 800,
    webPreferences: {
      nodeIntegration: false,
      contextIsolation: true,
    },
  });

  // ✅ Load static frontend/index.html directly from filesystem
  win.loadFile(path.join(__dirname, 'frontend', 'index.html'));
}

app.whenReady().then(() => {
  startPHPServer();
  setTimeout(createWindow, 1000); // wait for PHP server
});

app.on('window-all-closed', () => {
  if (phpServer) phpServer.kill();
  if (process.platform !== 'darwin') app.quit();
});
