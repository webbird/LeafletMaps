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

$database->query(sprintf(
    "ALTER TABLE `%smod_leafletmaps_markers` DROP COLUMN `page_id`;",
    TABLE_PREFIX
));
$database->query(sprintf(
    "ALTER TABLE `%smod_leafletmaps_settings`
	ADD COLUMN `create_marker` INT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `defzoom`",
    TABLE_PREFIX
));