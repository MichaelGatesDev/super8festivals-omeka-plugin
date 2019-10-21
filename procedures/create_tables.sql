use omeka;

CREATE TABLE IF NOT EXISTS `omeka_supereightfestivals_countries`
(
    `country_id` int(6) unsigned NOT NULL AUTO_INCREMENT, # ID of the country for internal use
    `name`       varchar(255)    NOT NULL,                # The name of the country (e.g. "Germany")
    `latitude`   FLOAT(8, 5)     NOT NULL,                # The latitudinal position of the country
    `longitude`  FLOAT(8, 5)     NOT NULL,                # The longitudinal position of the country
    primary key (`country_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `omeka_supereightfestivals_cities`
(
    `city_id`    int(6) unsigned NOT NULL AUTO_INCREMENT, # ID of the city for internal use
    `country_id` int(6) unsigned NOT NULL,                # ID of the country in which the city exists
    `name`       varchar(255)    NOT NULL,                # The name of the city (e.g. "Brussels")
    `latitude`   FLOAT(8, 5)     NOT NULL,                # The latitudinal position of the city
    `longitude`  FLOAT(8, 5)     NOT NULL,                # The longitudinal position of the city
    primary key (`city_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `omeka_supereightfestivals_festivals`
(
    `festival_id` int(6) unsigned NOT NULL AUTO_INCREMENT, # ID of the city for internal use
    `country_id`  int(6) unsigned NOT NULL,                # ID of the country in which the festival exists
    `city_id`     int(6) unsigned NOT NULL,                # ID of the city in which the festival exists
    `name`        varchar(255)    NOT NULL,                # The name of the city (e.g. "Brussels")
    `date`        DATE,
    primary key (`festival_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `omeka_supereightfestivals_filmmakers`
(
    `filmmaker_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
    `name`         varchar(255)    NOT NULL,
    primary key (`filmmaker_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
