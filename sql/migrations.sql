CREATE DATABASE url_shorter;
USE url_shorter;
CREATE TABLE `urls` (
  `id`         INT(11)       NOT NULL AUTO_INCREMENT,
  `long_url`   VARCHAR(2000) NOT NULL,
  `hash`       VARCHAR(6)    NOT NULL,
  `created_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `urls_hash_uindex` (`hash`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 265
  DEFAULT CHARSET = utf8;
