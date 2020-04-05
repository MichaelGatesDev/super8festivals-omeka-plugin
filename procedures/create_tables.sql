#############################################
###                 IMAGES                ###
#############################################
CREATE TABLE IF NOT EXISTS `%PREFIX%country_banners`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `country_id`          int(10) unsigned NOT NULL,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `file_name`           TEXT(65535),
    `file_url_web`        TEXT(65535),
    `active`              BOOL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `%PREFIX%city_banners`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `city_id`             int(10) unsigned NOT NULL,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `file_name`           TEXT(65535),
    `file_url_web`        TEXT(65535),
    `active`              BOOL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_photos`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `festival_id`         int(10) unsigned NOT NULL,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `file_name`           TEXT(65535),
    `file_url_web`        TEXT(65535),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_posters`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `festival_id`         int(10) unsigned NOT NULL,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `file_name`           TEXT(65535),
    `file_url_web`        TEXT(65535),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

#############################################
###                 VIDEOS                ###
#############################################
CREATE TABLE IF NOT EXISTS `%PREFIX%festival_films`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `festival_id`         int(10) unsigned NOT NULL,
    `filmmaker_id`        int(10) unsigned,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `embed`               TEXT(65535),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

#############################################
###               DOCUMENTS               ###
#############################################
CREATE TABLE IF NOT EXISTS `%PREFIX%federation_documents`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `file_name`           TEXT(65535),
    `file_url_web`        TEXT(65535),
    `embed`               TEXT(65535),
    PRIMARY KEY (`id`),
    KEY `name` (`title`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_film_catalogs`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `festival_id`         int(10) unsigned NOT NULL,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `file_name`           TEXT(65535),
    `file_url_web`        TEXT(65535),
    `embed`               TEXT(65535),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_memorabilias`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `festival_id`         int(10) unsigned NOT NULL,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `file_name`           TEXT(65535),
    `file_url_web`        TEXT(65535),
    `embed`               TEXT(65535),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_print_medias`
(
    `id`                  int(10) unsigned NOT NULL AUTO_INCREMENT,
    `festival_id`         int(10) unsigned NOT NULL,
    `contributor_id`      int(10) unsigned,
    `title`               varchar(255),
    `description`         TEXT(65535),
    `thumbnail_file_name` TEXT(65535),
    `thumbnail_url_web`   TEXT(65535),
    `file_name`           TEXT(65535),
    `file_url_web`        TEXT(65535),
    `embed`               TEXT(65535),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

#############################################
###               LOCATIONS               ###
#############################################
CREATE TABLE IF NOT EXISTS `%PREFIX%countries`
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`      varchar(255)     NOT NULL,
    `latitude`  FLOAT(8, 5),
    `longitude` FLOAT(8, 5),
    PRIMARY KEY (`id`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%cities`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
    `country_id` int(10) unsigned,
    `name`       varchar(255)     NOT NULL,
    `latitude`   FLOAT(8, 5)      NOT NULL,
    `longitude`  FLOAT(8, 5)      NOT NULL,
    PRIMARY KEY (`id`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

#############################################
###               PEOPLE                  ###
#############################################
CREATE TABLE IF NOT EXISTS `%PREFIX%festival_filmmakers`
(
    `id`                int(10) unsigned NOT NULL AUTO_INCREMENT,
    `festival_id`       int(10) unsigned NOT NULL,
    `first_name`        VARCHAR(255),
    `last_name`         VARCHAR(255),
    `organization_name` VARCHAR(255),
    `email`             VARCHAR(255)     NOT NULL,
    PRIMARY KEY (`id`),
    KEY `first_name` (`first_name`),
    KEY `last_name` (`last_name`),
    KEY `organization_name` (`organization_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%contributors`
(
    `id`                INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name`        VARCHAR(255),
    `last_name`         VARCHAR(255),
    `organization_name` VARCHAR(255),
    `email`             VARCHAR(255)     NOT NULL,
    PRIMARY KEY (`id`),
    KEY `first_name` (`first_name`),
    KEY `last_name` (`last_name`),
    KEY `organization_name` (`organization_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;


#############################################
###               OTHER                   ###
#############################################
CREATE TABLE IF NOT EXISTS `%PREFIX%pages`
(
    `id`      int(10) unsigned NOT NULL AUTO_INCREMENT,
    `title`   varchar(255)     NOT NULL,
    `url`     varchar(255)     NOT NULL,
    `content` TEXT(65535),
    PRIMARY KEY (`id`),
    KEY `name` (`title`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festivals`
(
    `id`          int(10) unsigned NOT NULL AUTO_INCREMENT,
    `city_id`     int(10) unsigned NOT NULL,
    `year`        int(4)           NOT NULL,
    `title`       varchar(255),
    `description` TEXT(65535),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
