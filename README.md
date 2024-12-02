# Minimarket

mini market is a classified ads site

## Prerequis

* [PHP 8.1](https://www.php.net/downloads)
* [Composer 2.7](https://getcomposer.org/download/)
* [Symfony CLI 5.8](https://symfony.com/download)

The symfony binary also provides a tool to check if your computer meets all requirements. Open your console terminal and run this command:

```bash
symfony check:requirements
```

## In dev-mode
The following commands allow in order: to install the dependencies of the minimarket application, launch a PostgreSQL container in the background with the precise configurations (database, user, password),applies all pending migrations to the database defined in your Symfony project, without asking you for confirmation, to launch the internal server of symfony and to open the project in the default browser of the computer.

```bash
composer install
npm install
docker compose up -d
npm run build
symfony console d:m:m -n
symfony console d:f:l -n
symfony serve -d
symfony open:local
```

## Run tests

```bash
composer test
composer fix
composer phpstan
```