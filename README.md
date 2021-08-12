# php-server-with-docker
La idea de este repositorio es de ser ocupado como plantilla para posteriores proyectos en PHP. Compatible con TypeScript.
## Incluye:
* Servidor de PHP en Docker con Apache, sacado directamente de la imagen oficial, que además agrega:
  * Composer
  * NPM
  * Las extensiones necesarias para instalar Laravel
  * XDebug, para depurar código de PHP
  * Basado en la imagen de PHP del profe Seba.
* TypeScript
* Configuraciones preestablecidas de VS Code
  * launch.json para depurar PHP
  * tasks.json para compilar y limpiar archivos TypeScript
  * tsconfig.json configurado para compilar archivos TS a JS ES6 2015.
## Para que funque:
Es necesario tener instalado en tu máquina Docker y Docker Compose. Si están instalados, sigue estos pasos:

1. Descarga el proyecto, y abre la terminal en la raíz de este.
1. Ejecuta ```docker-compose build``` en tu terminal para construir la imagen de PHP 8 con todos sus dependencias.
1. Una vez terminado, ejecuta ```docker-compose up -d``` para iniciar el servidor PHP.
1. Desde VS Code, accede al "Remote Explorer" desde tu barra de aplicaciones. Deberías ver una entrada en la lista con el servidor recién creado.
1. Hazle clic secundario a esta máquina, y cliquea la acción "Attach to Container". Esto hará que tu VS Code comience a ejecutarse dentro de la máquina virtual.
1. Una vez dentro, instala la extensión "PHP Debug", de Felix Becker desde el marketplace.
    > Nota: es probable que la mayoría de tus extensiones no funcionen dentro de la máquina virtual, por lo que deberás reinstalar cualquiera que quieras utilizar durante el desarrollo.
1. Ahora, abre el la ruta de tu proyecto en la máquina de Docker. Por defecto, esta es `/var/www/`. 
1. Activa las tareas automáticas en esta carpeta. Aprieta F1 para acceder a los comandos, escribe ```"Tasks: Manage Automatic Tasks in Folder"``` y dale enter.
  1. Selecciona ```"Allow Automatic Tasks in Folder"``` y dale enter.
  1. Accede a la lista de comandos de nuevo (F1) y corre el comando ```"Developer: Reload Windows"``` para activar los servicios automáticamente.
      * Si no quieres que los servicios se inicien al abrir tu proyecto, simplemente apreta F1 y corre ```"Tasks: Run Task"```, y elige cual quieres correr de la lista.
