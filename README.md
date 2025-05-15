ARCHIVA - Sistema de Gestión Documental
ARCHIVA es una plataforma de gestión documental desarrollada en Laravel, diseñada para gestionar el ciclo de vida de documentos dentro de una organización, permitiendo el control de transferencias, préstamos y administración de archivos en diversas ubicaciones físicas.

## Tabla de Contenidos

- [Requisitos del Sistema](#requisitos-del-sistema)
- [Instalación](#instalación)
- [Configuración del Proyecto](#configuración-del-proyecto)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Uso](#uso)
- [Comandos Útiles](#comandos-útiles)
- [Contribución](#contribución)


## Requisitos del Sistema
Antes de comenzar, asegúrate de tener instalados los siguientes programas:

PHP >= 8.0.0

Composer: Gestor de dependencias para PHP.

Node.js >= 12.x

MySQL o SQLite (configurable en .env).

Git: Para clonar el repositorio.

## Instalación
1. Clonar el Repositorio
Primero, clona el repositorio en tu máquina local:
git clone https://github.com/tu-usuario/archiva.git
cd archiva
2. Instalar Dependencias de PHP
Instala las dependencias de PHP utilizando Composer:
composer install
3. Instalar Dependencias de Node.js

Si tu proyecto incluye la gestión de activos (CSS/JS) con Laravel Mix, instala las dependencias de Node.js:
npm install

4. Configuración del Archivo .env
Copia el archivo .env.example y renómbralo a .env:
cp .env.example .env
Edita el archivo .env para configurar la base de datos y otras variables de entorno. Asegúrate de configurar la conexión con la base de datos correctamente:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

5. Generar la Clave de la Aplicación
Laravel necesita una clave de aplicación única. Genera esta clave con el siguiente comando:
php artisan key:generate

## Configuración del Proyecto

1. Ejecutar Migraciones
Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
php artisan migrate

2. Ejecutar Seeders (Opcional)
Si deseas poblar la base de datos con datos de ejemplo, ejecuta los seeders:
php artisan db:seed


## Carpetas Fudamentales

app/: Contiene los controladores y modelos de la aplicación.

database/: Contiene las migraciones y seeders.

resources/views: Contiene las vistas Blade de la aplicación.

routes/: Define las rutas del proyecto (web y API).

public/: Contiene los archivos públicos, como imágenes, CSS y JavaScript.


Para iniciar el servidor de desarrollo, utiliza el siguiente comando:

php artisan serve
Este comando iniciará el servidor en http://127.0.0.1:8000. Puedes acceder al proyecto desde tu navegador.

## Comandos Útiles

Limpiar Caché
php artisan cache:clear

Limpiar las Rutas
php artisan route:clear

Listar Rutas Definidas
php artisan route:list

Ejecutar Migraciones
php artisan migrate

Ejecutar Seeders
php artisan db:seed


## Contribución
Si deseas contribuir a este proyecto, sigue estos pasos:

Haz un fork del repositorio.

Crea una nueva rama para tus cambios.

Realiza tus cambios y realiza commit.

Haz un pull request con una descripción detallada de los cambios realizados.

