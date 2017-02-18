# Url shorter

Small application for implement url shorter service.

# Installation

## PHP

Version should be >= 5.6.

Modules:
- pdo_mysql
- json
- openssl

## Create database
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
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=latin1
```

# Start server

```
php -S localhost:8000 public/index.php 
```
