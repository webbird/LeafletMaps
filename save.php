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

require_once dirname(__FILE__).'/../../config.php';

$update_when_modified = true; // Tells script to update when this page was last updated
if(!defined('CAT_VERSION')) {
    require_once WB_PATH.'/framework/functions.php';
}

require_once dirname(__FILE__).'/inc/functions.inc.php';

// check input data
$section_id = addslashes($_REQUEST['section_id']);
if(!isset($section_id) || !is_numeric($section_id)) {
    $admin->print_error(lm_trans('Invalid data!'), $js_back);
}

// Include admin wrapper script
require_once WB_PATH.'/modules/admin.php';
if(!isset($admin) || !$admin->is_authenticated()) {
    die();
}

require_once WB_PATH.'/modules/LeafletMaps/inc/class.LeafletMaps.php';
echo LeafletMaps::modify($section_id);
