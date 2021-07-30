# php-server-with-docker
La idea de este repositorio es de ser ocupado como plantilla para posteriores proyectos en PHP. Compatible con TypeScript.
# Incluye:
* Servidor de PHP en Docker, sacado directamente de la imagen oficial, que además agrega:
  * Apache
  * Composer
  * Las extensiones necesarias para instalar Laravel
  * XDebug, para depurar código de PHP
  * Basado en la imagen de PHP del profe Seba.
* TypeScript
* Configuraciones preestablecidas de VS Code
  * launch.json para depurar PHP
  * tasks.json para compilar y limpiar archivos TypeScript
  * tsconfig.json configurado para compilar archivos TS a JS ES6 2015.
# Para que funque:
* Tener instalado Docker, Docker Compose y NPM.
* Instalar extensión "PHP Debug", de Felix Becker desde el marketplace de VS Code.
* Instalar "typescript" y "ts-cleaner" de forma global con NPM:
  * > npm i -g typescript
  * > npm i -g ts-cleaner
* Activar las tareas automáticas en la carpeta de tu proyecto con VS Code:
  * Apretando F1 para acceder a los comandos.
  * Escribe ```"Tasks: Manage Automatic Tasks in Folder"``` y dale enter.
  * Selecciona ```"Allow Automatic Tasks in Folder"``` y dale enter.
  * Accede a la lista de comandos de nuevo (F1) y corre el comando ```"Developer: Reload Windows"``` para activar los servicios automáticamente.
    * Si no quieres que los servicios se inicien al abrir tu proyecto, simplemente apreta F1 y corre ```"Tasks: Run Task"```, y elige cual quieres correr de la lista.
 
