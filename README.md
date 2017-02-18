# Url shorter

Small application for implement url shorter service.

# Installation

## PHP

Version should be >= 5.6.

Modules:
- pdo_mysql
- json
- openssl

## Composer

Project hasn't external dependencies in production mode. But composer used for autoloading classes.

```
composer install --no-dev
```

## Create database

Project use Mysql. Please install server on you OS and create database and user with commands:

```
mysql -u... -p... -e '`cat sql/migrations.sql`'
```

# Start server

Server listen http://localhost:8998.

```
bin/run 
```

# Testing 

Install PHPUnit:

```
composer install
```

Run tests:

```
vendor/bin/phpunit tests/
```

# Docker

Run with docker on Server listen http://localhost:8998:

```
bin/docker
```
