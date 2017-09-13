<?php

/**
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author          BlackBird Webprogrammierung
 *   @copyright       2017, BlackBird Webprogrammierung
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @package         LeafletMaps
 *
 */

if(!defined('WB_PATH') && !defined('CAT_PATH')) { exit("Cannot access this file directly"); }

if(defined('CAT_VERSION')) {
    $database = CAT_Helper_DB::getInstance();
    if(!defined('TABLE_PREFIX')) define('TABLE_PREFIX',$database::prefix());
}

$database->query(sprintf(
    "CREATE TABLE IF NOT EXISTS `%smod_leafletmaps_settings` (
        `section_id` int(10) NOT NULL DEFAULT '0',
        `page_id` int(10) NOT NULL DEFAULT '0',
        `provider` varchar(50) DEFAULT 'OpenStreetMap',
        `width` varchar(10) NOT NULL DEFAULT '100%%',
        `height` varchar(10) NOT NULL DEFAULT '500px',
        `popuptpl` text NOT NULL,
        `deflatitude` decimal(18,15) NOT NULL DEFAULT '52.476000000000000',
        `deflongitude` decimal(18,15) NOT NULL DEFAULT '13.433300000000000',
        `defzoom` varchar(255) NOT NULL DEFAULT '5',
        PRIMARY KEY (`section_id`)
    )
    COLLATE='utf8mb4_general_ci'
    ENGINE=InnoDB
    ;", TABLE_PREFIX
));

$database->query(sprintf(
    "CREATE TABLE IF NOT EXISTS `%smod_leafletmaps_iconsets` (
        `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	    `setName` VARCHAR(50) NULL DEFAULT NULL,
        `baseUrl` text NOT NULL,
        `shadowUrl` varchar(50) DEFAULT NULL,
        `iconWidth` int(3) unsigned DEFAULT NULL,
        `iconHeight` int(3) unsigned DEFAULT NULL,
        `iconAnchorLeft` int(3) DEFAULT NULL,
        `iconAnchorBottom` int(3) DEFAULT NULL,
        `shadowWidth` int(3) unsigned DEFAULT NULL,
        `shadowHeight` int(3) unsigned DEFAULT NULL,
        `shadowAnchorLeft` int(3) DEFAULT NULL,
        `shadowAnchorBottom` int(3) DEFAULT NULL,
        `popupAnchorLeft` int(3) DEFAULT NULL,
        `popupAnchorBottom` int(3) DEFAULT NULL,
        `glyphAnchorLeft` int(3) DEFAULT NULL,
        `glyphAnchorBottom` int(3) DEFAULT NULL,
        `glyphColor` varchar(50) DEFAULT NULL,
        PRIMARY KEY (`class_id`)
    )
    COLLATE='utf8mb4_general_ci'
    ENGINE=InnoDB
    ;", TABLE_PREFIX
));

$database->query(sprintf(
    "CREATE TABLE `%smod_leafletmaps_icons` (
    	`icon_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    	`class_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    	`iconUrl` VARCHAR(50) NOT NULL DEFAULT '0',
    	`glyph` VARCHAR(50) NULL DEFAULT NULL,
    	PRIMARY KEY (`icon_id`),
    	INDEX `FK_mod_leafletmaps_icons_mod_leafletmaps_iconclasses` (`class_id`),
    	CONSTRAINT `FK_%smod_leafletmaps_icons_mod_leafletmaps_iconclasses` FOREIGN KEY (`class_id`) REFERENCES `%smod_leafletmaps_iconsets` (`class_id`)
    )
    COLLATE='utf8mb4_general_ci'
    ENGINE=InnoDB
;

    ;", TABLE_PREFIX, TABLE_PREFIX, TABLE_PREFIX
));

$database->query(sprintf(
    "CREATE TABLE `%smod_leafletmaps_markers` (
    	`section_id` INT(10) NOT NULL DEFAULT '0',
    	`page_id` INT(10) NOT NULL DEFAULT '0',
    	`marker_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    	`icon_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
    	`name` VARCHAR(255) NOT NULL,
    	`latitude` DECIMAL(18,15) NOT NULL DEFAULT '0.000000000000000',
    	`longitude` DECIMAL(18,15) NOT NULL DEFAULT '0.000000000000000',
    	`url` TEXT NULL,
    	`description` TEXT NULL,
        `glyph` VARCHAR(50) NULL DEFAULT NULL,
    	`active` INT(1) NOT NULL DEFAULT '1',
    	`pos` INT(10) NOT NULL DEFAULT '0',
    	PRIMARY KEY (`marker_id`),
    	INDEX `FK_mod_leafletmaps_markers_mod_leafletmaps_icons` (`icon_id`),
    	CONSTRAINT `FK_%smod_leafletmaps_markers_mod_leafletmaps_icons` FOREIGN KEY (`icon_id`) REFERENCES `%smod_leafletmaps_icons` (`icon_id`)
    )
    COLLATE='utf8mb4_general_ci'
    ENGINE=InnoDB
    ;

      ;", TABLE_PREFIX, TABLE_PREFIX, TABLE_PREFIX
));

$database->query(sprintf(
    "INSERT INTO `%smod_leafletmaps_iconsets`
    (`class_id`, `setName`, `baseUrl`, `shadowUrl`, `iconWidth`, `iconHeight`, `iconAnchorLeft`, `iconAnchorBottom`, `shadowWidth`, `shadowHeight`, `shadowAnchorLeft`, `shadowAnchorBottom`, `popupAnchorLeft`, `popupAnchorBottom`, `glyphAnchorLeft`, `glyphAnchorBottom`, `glyphColor`)
    VALUES (1, 'byteworker', '/modules/LeafletMaps/icons/byteworker', 'shadow.png', 32, 50, 16, 49, 35, 26, 1, 26, 0, -35, 0, 8, '#fefefe'),
    (2, 'LeafletJS Original', '/modules/LeafletMaps/css/images', 'marker-shadow.png', 25, 41, 12, 40, 41, 41, 12, 41, 0, 0, 0, 3, '#fff');",
    TABLE_PREFIX
));

$database->query(sprintf(
    "INSERT INTO `%smod_leafletmaps_icons` (`class_id`, `iconUrl`) VALUES
	(1, 'beige.png'),
	(1, 'blue.png'),
	(1, 'gold.png'),
	(1, 'gradient.png'),
	(1, 'green.png'),
	(1, 'grey.png'),
	(1, 'pink.png'),
	(1, 'red.png'),
    (2, 'marker-icon.png');",
    TABLE_PREFIX
));
