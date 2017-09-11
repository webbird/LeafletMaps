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

$dir = dirname(__FILE__);

require_once $dir.'/../../config.php';
require_once $dir.'/inc/functions.inc.php';
require_once $dir.'/inc/class.LeafletMaps.php';

// check section_id
$section_id = ( isset($_GET['section_id']) && is_numeric($_GET['section_id']) )
            ? $_GET['section_id']
            : NULL;

// check if this section has a leaflet map
if($section_id) {
    $lm_settings = LeafletMaps::settings($section_id);
    if($lm_settings && is_array($lm_settings) && count($lm_settings)>1) {
        // get marker
        $markers = LeafletMaps::markers($section_id);
        // render popup
        foreach($markers as $i => $m) {
            $markers[$i]['popup'] = str_ireplace(array(
                '{NAME}','{DESCRIPTION}','{LATITUDE}','{LONGITUDE}','{URL}'
            ),array(
                $m['name'],$m['description'],$m['latitude'],$m['longitude'],$m['url']
            ), $lm_settings['popuptpl']);
        }
        // get icons
        echo json_encode($markers,true);
    }
}



