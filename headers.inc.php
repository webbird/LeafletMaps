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

$mod_headers = array(
    'backend'    => array(
        'js'     => array(
            '/modules/LeafletMaps/js/leaflet.min.js',
            '/modules/LeafletMaps/js/Leaflet.Icon.Glyph.js',
            '/modules/LeafletMaps/js/map.js',
            '/modules/LeafletMaps/js/jquery-asTooltip.min.js',
            '/modules/LeafletMaps/js/jquery-asScrollbar.min.js',
            '/modules/LeafletMaps/js/jquery-asIconPicker.min.js',
        ),
        'css'    => array(
            array('file'=>'/modules/LeafletMaps/css/leaflet.css')
        ),
        'jquery' => array( 'core' => true, 'ui' => false ),
        'meta'   => array(),
    ),
    'frontend' => array(
        'js'  => array(
            '/modules/LeafletMaps/js/leaflet.min.js',
            '/modules/LeafletMaps/js/Leaflet.Icon.Glyph.js',
            '/modules/LeafletMaps/js/map.js',
        ),
        'css' => array(
            array('file'=>'/modules/LeafletMaps/css/leaflet.css')
        ),
        'jquery' => array( 'core' => true, 'ui' => false ),
    ),
);
