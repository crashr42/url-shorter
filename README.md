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
mysql> create database url_shorter;
mysql> grant all privileges on url_shorter.* to 'demo'@'%' identified by 'demo';
```

## Create table
```
CREATE TABLE `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `long_url` varchar(2000) NOT NULL,
  `hash` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `urls_hash_uindex` (`hash`)
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8_general_ci
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
