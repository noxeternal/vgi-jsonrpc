
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category`
(
    `text` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`text`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- state
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state`
(
    `text` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`text`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- console
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `console`;

CREATE TABLE `console`
(
    `text` VARCHAR(75) NOT NULL,
    `link` VARCHAR(25) NOT NULL,
    `order_by` INTEGER NOT NULL,
    PRIMARY KEY (`text`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- extra
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `extra`;

CREATE TABLE `extra`
(
    `extra_id` INTEGER NOT NULL AUTO_INCREMENT,
    `item_id` BIGINT NOT NULL,
    `text` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`extra_id`),
    INDEX `fi_em_id_extra` (`item_id`),
    CONSTRAINT `_item_id_extra`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`item_id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- login
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `login`;

CREATE TABLE `login`
(
    `login_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `role` VARCHAR(10) NOT NULL,
    `passwd` VARCHAR(255) NOT NULL,
    `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`login_id`),
    UNIQUE INDEX `name` (`name`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- style
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `style`;

CREATE TABLE `style`
(
    `name` VARCHAR(50) DEFAULT '' NOT NULL,
    `text` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`name`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item`
(
    `item_id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `link` VARCHAR(75) DEFAULT '' NOT NULL,
    `image_url` VARCHAR(255) DEFAULT '' NOT NULL,
    `console` VARCHAR(75) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `state` VARCHAR(50) NOT NULL,
    `box` TINYINT(1) DEFAULT 0 NOT NULL,
    `manual` TINYINT(1) DEFAULT 0 NOT NULL,
    `style` VARCHAR(50) DEFAULT '' NOT NULL,
    PRIMARY KEY (`item_id`),
    INDEX `fi_nsole` (`console`),
    INDEX `fi_tegory` (`category`),
    INDEX `fi_ate` (`state`),
    INDEX `fi_yle` (`style`),
    INDEX `i_referenced__image_url_1` (`image_url`),
    CONSTRAINT `_console`
        FOREIGN KEY (`console`)
        REFERENCES `console` (`text`),
    CONSTRAINT `_category`
        FOREIGN KEY (`category`)
        REFERENCES `category` (`text`),
    CONSTRAINT `_state`
        FOREIGN KEY (`state`)
        REFERENCES `state` (`text`),
    CONSTRAINT `_style`
        FOREIGN KEY (`style`)
        REFERENCES `style` (`name`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- price_list
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `price_list`;

CREATE TABLE `price_list`
(
    `price_id` INTEGER NOT NULL AUTO_INCREMENT,
    `item_id` BIGINT NOT NULL,
    `amount` FLOAT NOT NULL,
    `last_check` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`price_id`),
    INDEX `fi_em_id_price_list` (`item_id`),
    CONSTRAINT `_item_id_price_list`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`item_id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- image_data
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `image_data`;

CREATE TABLE `image_data`
(
    `image_url` VARCHAR(255) NOT NULL,
    `image_data` MEDIUMBLOB NOT NULL,
    PRIMARY KEY (`image_url`),
    CONSTRAINT `_image_url`
        FOREIGN KEY (`image_url`)
        REFERENCES `item` (`image_url`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- category_archive
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category_archive`;

CREATE TABLE `category_archive`
(
    `text` VARCHAR(50) NOT NULL,
    `archived_at` DATETIME,
    PRIMARY KEY (`text`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- state_archive
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `state_archive`;

CREATE TABLE `state_archive`
(
    `text` VARCHAR(50) NOT NULL,
    `archived_at` DATETIME,
    PRIMARY KEY (`text`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- console_archive
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `console_archive`;

CREATE TABLE `console_archive`
(
    `text` VARCHAR(75) NOT NULL,
    `link` VARCHAR(25) NOT NULL,
    `order_by` INTEGER NOT NULL,
    `archived_at` DATETIME,
    PRIMARY KEY (`text`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- extra_archive
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `extra_archive`;

CREATE TABLE `extra_archive`
(
    `extra_id` INTEGER NOT NULL,
    `item_id` BIGINT NOT NULL,
    `text` VARCHAR(100) NOT NULL,
    `archived_at` DATETIME,
    PRIMARY KEY (`extra_id`),
    INDEX `fi_em_id_extra` (`item_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- login_archive
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `login_archive`;

CREATE TABLE `login_archive`
(
    `login_id` INTEGER NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `role` VARCHAR(10) NOT NULL,
    `passwd` VARCHAR(255) NOT NULL,
    `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `archived_at` DATETIME,
    PRIMARY KEY (`login_id`),
    INDEX `login_archive_i_d94269` (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- style_archive
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `style_archive`;

CREATE TABLE `style_archive`
(
    `name` VARCHAR(50) DEFAULT '' NOT NULL,
    `text` VARCHAR(255) NOT NULL,
    `archived_at` DATETIME,
    PRIMARY KEY (`name`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item_archive
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_archive`;

CREATE TABLE `item_archive`
(
    `item_id` BIGINT NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `link` VARCHAR(75) DEFAULT '' NOT NULL,
    `image_url` VARCHAR(255) DEFAULT '' NOT NULL,
    `console` VARCHAR(75) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `state` VARCHAR(50) NOT NULL,
    `box` TINYINT(1) DEFAULT 0 NOT NULL,
    `manual` TINYINT(1) DEFAULT 0 NOT NULL,
    `style` VARCHAR(50) DEFAULT '' NOT NULL,
    `archived_at` DATETIME,
    PRIMARY KEY (`item_id`),
    INDEX `fi_nsole` (`console`),
    INDEX `fi_tegory` (`category`),
    INDEX `fi_ate` (`state`),
    INDEX `fi_yle` (`style`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
