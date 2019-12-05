CREATE TABLE IF NOT EXISTS `%PREFIX%countries`
(
    `id`   int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the country
    `name` varchar(255)     NOT NULL,                # The name of the country (e.g. "Germany")
    PRIMARY KEY (`id`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%country_banners`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the banner
    `country_id` int(10) unsigned NOT NULL,                # ID of the country
    `path`       varchar(255)     NOT NULL,
    `thumbnail`  varchar(255)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%cities`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the city
    `country_id` int(10) unsigned NOT NULL,                # ID of the country in which the city exists
    `name`       varchar(255)     NOT NULL,                # The name of the city (e.g. "Brussels")
    `latitude`   FLOAT(8, 5)      NOT NULL,                # The latitudinal position of the city
    `longitude`  FLOAT(8, 5)      NOT NULL,                # The longitudinal position of the city
    PRIMARY KEY (`id`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_film_catalogs`
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the film catalog
    `city_id`   int(10) unsigned NOT NULL,                # ID of the festival
    `path`      varchar(255)     NOT NULL,
    `thumbnail` varchar(255)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_filmmakers`
(
    `id`                int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the filmmaker
    `city_id`           int(10) unsigned NOT NULL,                # ID of the festival
    `first_name`        VARCHAR(255),                             # first name, or null if none
    `last_name`         VARCHAR(255),                             # last name, or null if none
    `organization_name` VARCHAR(255),                             # organization name, or null if none
    `cover_photo_url`   VARCHAR(255),                             # image URL
    PRIMARY KEY (`id`),
    KEY `first_name` (`first_name`),
    KEY `last_name` (`last_name`),
    KEY `organization_name` (`organization_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_films`
(
    `id`           int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the film catalog
    `city_id`      int(10) unsigned NOT NULL,                # ID of the festival
    `filmmaker_id` int(10) unsigned,                         # ID Of the filmmaker
    `title`        varchar(255),
    `thumbnail`    varchar(255),
    `url`          varchar(255)     NOT NULL,                # URL to video
    `embed`        TEXT(65535)      NOT NULL,                # HTML to embed video
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_memorabilias`
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the memorabilia
    `city_id`   int(10) unsigned NOT NULL,                # ID of the festival
    `path`      varchar(255)     NOT NULL,
    `thumbnail` varchar(255)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_print_medias` # Newspapers & Magazines
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the print media
    `city_id`   int(10) unsigned NOT NULL,                # ID of the festival
    `path`      varchar(255)     NOT NULL,
    `thumbnail` varchar(255)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_photos`
(
    `id`          int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the photo
    `city_id`     int(10) unsigned NOT NULL,                # ID of the festival
    `title`       varchar(255),
    `description` varchar(255),
    `path`        varchar(255)     NOT NULL,
    `thumbnail`   varchar(255)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festival_posters`
(
    `id`          int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the poster
    `city_id`     int(10) unsigned NOT NULL,                # ID of the festival
    `title`       varchar(255),
    `description` varchar(255),
    `path`        varchar(255)     NOT NULL,
    `thumbnail`   varchar(255)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `%PREFIX%contributors`
(
    `id`                INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, # ID OF the contributor
    `first_name`        VARCHAR(255),
    `last_name`         VARCHAR(255),
    `organization_name` VARCHAR(255),
    `email`             VARCHAR(255)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%contribution_types`
(
    `id`   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, # ID OF the contribution TYPE
    `name` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
INSERT INTO `%PREFIX%contribution_types` (`name`)
VALUES ('film')
     , ('film catalog')
     , ('memorabilia')
     , ('print media')
     , ('poster')
     , ('photo')
     , ('other')
;

CREATE TABLE IF NOT EXISTS `%PREFIX%contributions`
(
    `id`             INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, # ID OF the contribution
    `type`           INT(10) UNSIGNED NOT NULL,                # Type of contribution
    `contributor_id` INT(10) UNSIGNED NOT NULL,                # ID OF the contributor
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;