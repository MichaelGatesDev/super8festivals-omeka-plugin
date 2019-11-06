CREATE TABLE IF NOT EXISTS `%PREFIX%countries`
(
    `id`        int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the country for internal use
    `name`      varchar(255)     NOT NULL,                # The name of the country (e.g. "Germany")
    `latitude`  FLOAT(8, 5)      NOT NULL,                # The latitudinal position of the country
    `longitude` FLOAT(8, 5)      NOT NULL,                # The longitudinal position of the country
    PRIMARY KEY (`id`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%cities`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT, # ID of the city for internal use
    `country_id` int(10) unsigned NOT NULL,                # ID of the country in which the city exists
    `name`       varchar(255)     NOT NULL,                # The name of the city (e.g. "Brussels")
    `latitude`   FLOAT(8, 5)      NOT NULL,                # The latitudinal position of the city
    `longitude`  FLOAT(8, 5)      NOT NULL,                # The longitudinal position of the city
    PRIMARY KEY (`id`),
    KEY `name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%festivals`
(
    `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
    `country_id` int(10) unsigned NOT NULL,
    `city_id`    int(10) unsigned NOT NULL,
    `name`       varchar(255)     NOT NULL,
    `date`       DATE,
    PRIMARY KEY (`id`),
    KEY `name` (`name`),
    KEY `date` (`date`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%filmmakers`
(
    `id`                INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name`        VARCHAR(255),
    `last_name`         VARCHAR(255),
    `organization_name` VARCHAR(255),
    PRIMARY KEY (`id`),
    KEY `first_name` (`first_name`),
    KEY `last_name` (`last_name`),
    KEY `organization_name` (`organization_name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%contributors`
(
    `id`                INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, # ID OF the contributor FOR internal USE
    `first_name`        VARCHAR(255),
    `last_name`         VARCHAR(255),
    `organization_name` INT(10) UNSIGNED,
    `email`             VARCHAR(255)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `%PREFIX%contribution_types`
(
    `id`   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, # ID OF the contribution TYPE FOR internal USE
    `name` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

INSERT INTO `%PREFIX%contribution_types` (`name`)
VALUES ('film');
INSERT INTO `%PREFIX%contribution_types` (`name`)
VALUES ('film catalog');
INSERT INTO `%PREFIX%contribution_types` (`name`)
VALUES ('memorabilia');
INSERT INTO `%PREFIX%contribution_types` (`name`)
VALUES ('newspaper/magazine');
INSERT INTO `%PREFIX%contribution_types` (`name`)
VALUES ('poster');
INSERT INTO `%PREFIX%contribution_types` (`name`)
VALUES ('photo');
INSERT INTO `%PREFIX%contribution_types` (`name`)
VALUES ('other');

# Film catalogs
# Photos
# Other

CREATE TABLE IF NOT EXISTS `%PREFIX%contributions`
(
    `id`             INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, # ID OF the contribution FOR internal USE
    `type`           INT(10) UNSIGNED NOT NULL,
    `contributor_id` INT(10) UNSIGNED NOT NULL,                # ID OF the contribution FOR internal USE
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;