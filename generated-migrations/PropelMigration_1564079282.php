<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1564079282.
 * Generated on 2019-07-25 18:28:02 by mikee
 */
class PropelMigration_1564079282
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `item`

  CHANGE `image_url` `image_url` VARCHAR(255),

  CHANGE `style` `style` VARCHAR(50) DEFAULT \'_\' NOT NULL;

-- CREATE UNIQUE INDEX `item_u_40fe95` ON `item` (`image_url`(255));

ALTER TABLE `item_archive`

  CHANGE `link` `link` VARCHAR(75),

  CHANGE `image_url` `image_url` VARCHAR(255),

  CHANGE `style` `style` VARCHAR(50) DEFAULT \'_\' NOT NULL;

CREATE TABLE `image_data`
(
    `image_url` VARCHAR(255),
    `image_data` MEDIUMBLOB NOT NULL,
    INDEX `iImage` (`image_url`),
    CONSTRAINT `_image_url`
        FOREIGN KEY (`image_url`)
        REFERENCES `item` (`image_url`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET=\'utf8\';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `image_data`;

DROP INDEX `item_u_40fe95` ON `item`;

ALTER TABLE `item`

  CHANGE `image_url` `image_url` VARCHAR(255) DEFAULT \'\' NOT NULL,

  CHANGE `style` `style` VARCHAR(50) DEFAULT \'\' NOT NULL;

ALTER TABLE `item_archive`

  CHANGE `link` `link` VARCHAR(75) DEFAULT \'\' NOT NULL,

  CHANGE `image_url` `image_url` VARCHAR(255) DEFAULT \'\' NOT NULL,

  CHANGE `style` `style` VARCHAR(50) DEFAULT \'\' NOT NULL;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}