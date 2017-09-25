<?php

/*
   ____  __      __    ___  _  _  ___    __   ____     ___  __  __  ___
  (  _ \(  )    /__\  / __)( )/ )/ __)  /__\ (_  _)   / __)(  \/  )/ __)
   ) _ < )(__  /(__)\( (__  )  (( (__  /(__)\  )(    ( (__  )    ( \__ \
  (____/(____)(__)(__)\___)(_)\_)\___)(__)(__)(__)    \___)(_/\/\_)(___/

   @author          BlackBird Webprogrammierung
   @copyright       2017 BlackBird Webprogrammierung
   @link            https://www.webbird.de
   @license         http://www.gnu.org/licenses/gpl.html
   @category        CAT_Modules
   @package         LeafletMaps

   Note: This is a hybrid module that is indented to run with WBCE,
   BlackCat CMS v1.x and BlackCat CMS v2.x. There are some concessions to
   make this work.

*/

if(!class_exists('LeafletMaps',false))
{
    require_once dirname(__FILE__).'/functions.inc.php';

    final class LeafletMaps
    {
        protected static $type        = 'page';
        protected static $directory   = 'LeafletMaps';
        protected static $name        = 'LeafletMaps';
        protected static $version     = '1.0.1';
        protected static $description = "";
        protected static $author      = "BlackBird Webprogrammierung";
        protected static $guid        = "7741329D-EA1C-550C-4C89-B6291DA69179";
        protected static $license     = "GNU General Public License";
        protected static $db          = NULL;

        /**
         * this is only needed as we can't inherit from CAT_Addons here
         **/
        public static function initialize() {
            global $baseUrl;
            if(defined('CAT_VERSION'))
                $baseUrl = CAT_ADMIN_URL;
            else
                $baseUrl = WB_URL.'/modules/LeafletMaps/';
        }

        /**
         *
         * @access public
         * @return
         **/
        public static function add()
        {
            global $section_id, $page_id;
            $popuptpl = '<h2>{NAME}</h2>
{DESCRIPTION}<br />
<a href="{URL}">{URL}</a><br />
<small><strong>Latitude: </strong>{LATITUDE}</small><br />
<small><strong>Longitude: </strong>{LONGITUDE}</small>
';

            $query = "INSERT INTO `%smod_leafletmaps_settings` ( `section_id`, `page_id`, `popuptpl` ) "
                   . "VALUES ( '$section_id', '$page_id', '$popuptpl' )";

            self::db()->query(sprintf($query,TABLE_PREFIX));
        }   // end function add()
        
        /**
         *
         * @access public
         * @return
         **/
        public static function delMarker($section_id)
        {
            // check if marker exists
            $marker_id = ( isset($_REQUEST['del']) && is_numeric($_REQUEST['del']) )
                       ? $_REQUEST['del']
                       : null;
            if(!$marker_id) return false;

            $markers   = self::markers($section_id,true);
            foreach($markers as $i => $m) {
                if($m['marker_id']==$marker_id) {
                    $query = "DELETE FROM `%smod_leafletmaps_markers` "
                           . "WHERE `marker_id`=%d";
                    self::db()->query(sprintf($query,TABLE_PREFIX,intval($marker_id)));
                    return self::db()->is_error() ? false : true;
                }
            }
            return false;
        }   // end function delMarker()

        /**
         *
         * @access public
         * @return
         **/
        public static function modify($section_id)
        {
            global $page_id, $baseUrl;
            if(defined('CAT_VERSION') && version_compare(CAT_VERSION,'2.0','>=')) {
                $page_id = CAT_Sections::getPageForSection($section_id);
                $baseUrl = CAT_ADMIN_URL.'/page/edit/'.$page_id;
                $saveUrl = CAT_ADMIN_URL.'/page/save/'.$page_id;
                $delim   = '?';
            } else {
                $baseUrl = ADMIN_URL.'/pages/modify.php?page_id='.$page_id;
                $saveUrl = WB_URL.'/modules/LeafletMaps/save.php';
                $delim   = '&amp;';
            }

            $lm_settings = self::settings($section_id);
            $markers     = self::markers($section_id,true);
            $icons       = self::icons();
            $glyphs      = json_decode(file_get_contents(dirname(__FILE__).'/fa_icons.json'),true);
            $do          = ( isset($_REQUEST['do']) && in_array($_REQUEST['do'],array('set','icon','marker')) )
                         ? $_REQUEST['do']
                         : 'marker';

            switch($do) {
                case 'icon':
                    $do = 'icon';
                    $tpl = 'icons';
                    break;
                case 'set':
                    $do = 'set';
                    $tpl = 'settings';
                    if(isset($_REQUEST['submit'])) {
                        self::save($section_id);
                    }
                    break;
                case 'marker':
                default:
                    $tpl = 'marker';
                    if(isset($_REQUEST['submit'])) {
                        self::saveMarker($section_id);
                    }
                    if(isset($_REQUEST['del'])) {
                        $result = self::delMarker($section_id);
                        if(!$result) {
                            $warn = lm_trans('An error occured while trying to delete the marker');
                        } else {
                            $info = lm_trans('The marker was deleted.');
                            $markers = self::markers($section_id,true);
                        }
                    }
                    break;
            }

            ob_start();
                include dirname(__FILE__).'/../templates/default/'.$tpl.'.tpl';
                $content = ob_get_contents();
            ob_end_clean();

            return $content;
        }   // end function modify()

        /**
         *
         * @access public
         * @return
         **/
        public static function save($section_id)
        {
            global $admin, $page_id;
            if(!defined('CAT_VERSION')) {
                $js_back = ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&do=set#'.SEC_ANCHOR.$section_id;
            }

            // check input data
            $section_id = addslashes($_POST['section_id']);
            if(!isset($section_id) || !is_numeric($section_id)) {
                $admin->print_error(lm_trans('Invalid data!'), $js_back);
            }

            foreach(array_values(array(
                'page_id', 'deflatitude', 'deflongitude', 'defzoom', 'width', 'height', 'popuptpl'
            )) as $key ) {
                $data[$key] = addslashes($_POST[$key]);
            }
            $data['create_marker']
                = (isset($_POST['create_marker']) && $_POST['create_marker']=='on')
                ? 1
                : 0;

            foreach(array_values(array(
                'page_id', 'defzoom'
            )) as $key ) {
                if(!isset($data[$key]) || !is_numeric($data[$key])) {
                    $admin->print_error(lm_trans('Invalid data!'), $js_back);
                }
            }

            $lengths = array('em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', '%', 'cm', 'mm', 'in', 'px', 'pt', 'pc',);
            foreach(array_values(array('width', 'height')) as $key) {
                if(!is_numeric($data[$key])) {
                    if(!preg_match('~^(\d+)('.implode('|',$lengths).')$~i', $data[$key], $m)) {
                        $admin->print_error(lm_trans('Invalid data!'), $js_back);
                    }
                } else {
                    $data[$key] .= 'px';
                }
            }

            $query_data = array();
            foreach($data as $key => $value) {
                $query_data[] = "`$key`='$value'";
            }
            $query = 'UPDATE `%smod_leafletmaps_settings` SET %s WHERE `section_id` = %d';
            self::db()->query(sprintf(
                $query, TABLE_PREFIX, (implode(', ', $query_data)), $section_id
            ));
            
            if(self::db()->is_error()) {
                if(defined('CAT_VERSION')) {
                    CAT_Object::printError(self::db()->getError());
                } else {
            	   $admin->print_error(self::db()->get_error(), $js_back);
                   exit;
                }
            } else {
                // check if we have to auto-create a marker
                if($data['create_marker']==1) {
                    $found   = false;
                    $markers = self::markers($section_id,1);
                    foreach($markers as $m) {
                        if($m['latitude'] == $data['deflatitude'] && $m['longitude'] == $data['deflongitude']) {
                            $found = true;
                            break;
                        }
                    }
                    if(!$found) {
                        $_POST = array(
                            'marker_name' => lm_trans('Map center'),
                            'marker_icon' => 1,
                            'marker_latitude' => $data['deflatitude'],
                            'marker_longitude' => $data['deflongitude'],
                            'page_id' => $page_id,
                        );
                        self::saveMarker($section_id);
                    }
                }
                if(defined('CAT_VERSION')) {
                    CAT_Object::printMsg(lm_trans('Saved'),CAT_ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&do=set');
                } else {
            	    $admin->print_success(lm_trans('Saved'), $js_back);
                    exit;
                }
            }

        }   // end function save()

        /**
         *
         * @access public
         * @return
         **/
        public static function saveMarker($section_id)
        {
            global $admin, $page_id, $baseUrl;

            foreach(array_values(array(
                'marker_id', 'marker_name', 'marker_active', 'marker_icon', 'marker_glyph', 'marker_latitude', 'marker_longitude', 'marker_description', 'marker_url'
            )) as $key ) {
                $data[$key] = addslashes($_POST[$key]);
            }

            // mandatory
            $missing = array();
            foreach(array_values(array(
                'marker_name', 'marker_icon', 'marker_latitude', 'marker_longitude'
            )) as $key ) {
                if(!isset($data[$key]) || !strlen($data[$key])) {
                    $missing[] = $key;
                }
            }
            if(count($missing)) {
                if(defined('CAT_VERSION')) {
                    CAT_Object::printError(lm_trans('There are missing fields:').' '.implode(', ',$missing),$baseUrl);
                    return;
                } else {
            	   $admin->print_error(
                       lm_trans('There are missing fields:').' '.implode(', ',$missing),
                       $baseUrl
                    );
                   return;
                }
            }

            // new marker
            if($data['marker_id'] == '') {
                $query = 'INSERT INTO `%smod_leafletmaps_markers` '
                       . '( `section_id`,  `name`, `icon_id`, `latitude`, `longitude`, `url`, `description`, `glyph` ) '
                       . "VALUES( %d, '%s', '%d', '%s', '%s', '%s', '%s', '%s' )";
                self::db()->query(sprintf(
                    $query,
                    TABLE_PREFIX,
                    $section_id,
                    $data['marker_name'],
                    $data['marker_icon'],
                    $data['marker_latitude'],
                    $data['marker_longitude'],
                    $data['marker_url'],
                    $data['marker_description'],
                    $data['marker_glyph']
                ));
            } else { // update
                $query = 'UPDATE `%smod_leafletmaps_markers` '
                       . "SET `name`='%s', `icon_id`=%d, `latitude`='%s', `longitude`='%s', `url`='%s', `description`='%s', `glyph`='%s' "
                       . 'WHERE `section_id`=%d AND `marker_id`=%d';
                self::db()->query(sprintf(
                    $query,
                    TABLE_PREFIX,
                    $data['marker_name'],
                    $data['marker_icon'],
                    $data['marker_latitude'],
                    $data['marker_longitude'],
                    $data['marker_url'],
                    $data['marker_description'],
                    $data['marker_glyph'],
                    $section_id,
                    $data['marker_id']
                ));
            }

            if(defined('CAT_VERSION')) {
                CAT_Object::printMsg(lm_trans('Saved'),CAT_ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
            } else {
    	        $admin->print_success(lm_trans('Saved'), ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
                exit;
            }
        }

        /**
         *
         * @access public
         * @return
         **/
        public static function view($section_id)
        {
            $lm_settings = self::settings($section_id);
            ob_start();
                include dirname(__FILE__).'/../templates/default/view.tpl';
                $content = ob_get_contents();
            ob_end_clean();
            echo $content;
        }   // end function view()

        /**
         *
         * @access public
         * @return
         **/
        public static function uninstall()
		{
			foreach(array_values(array(
                'mod_leafletmaps_markers',
                'mod_leafletmaps_icons',
                'mod_leafletmaps_settings',
                'mod_leafletmaps_iconsets',
            )) as $table) {
                self::db()->query(sprintf(
                    "DROP TABLE `%s$table`",
                    TABLE_PREFIX
                ));
            }
		}   // end function uninstall()
        
        /**
         *
         * @access public
         * @return
         **/
        public static function upgrade()
        {
        
        }   // end function upgrade()
        

// *****************************************************************************
// Utility functions
// *****************************************************************************

        /**
         * this function is only needed for use with WBCE
         **/
        public static function fetchall($sth) {
            $data = array();
            while($row = $sth->fetchRow(MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }   // end function fetchall()

        /**
         *
         * @access public
         * @return
         **/
        public static function icons()
        {
            $query = 'SELECT * FROM `%smod_leafletmaps_icons` AS t1 '
                   . 'JOIN `%smod_leafletmaps_iconsets` AS t2 '
                   . 'ON `t1`.`class_id`=`t2`.`class_id` ';
            $sth   = self::db()->query(sprintf(
                $query, TABLE_PREFIX, TABLE_PREFIX
            ));
            return ( !defined('CAT_VERSION') ? self::fetchall($sth) : $sth->fetchAll() );
        }   // end function icons()

        /**
         * get the list of markers for given section
         *
         * @access public
         * @param  integer  $section_id
         * @param  boolean  $for_be
         * @return array
         **/
        public static function markers($section_id,$for_be=false) {
            if($for_be) {
                $query = 'SELECT * '
                       . 'FROM `%smod_leafletmaps_markers` AS t1 '
                       . 'JOIN `%smod_leafletmaps_icons` AS t2 '
                       . 'ON `t1`.`icon_id`=`t2`.`icon_id` '
                       . 'JOIN `%smod_leafletmaps_iconsets` AS t4 '
                       . 'ON `t2`.`class_id`=`t4`.`class_id` '
                       . 'WHERE `t1`.`section_id`=%d '
                       . 'ORDER BY `t1`.`pos` ASC';
            } else {
                $query = 'SELECT t1.`name`, t1.`latitude`, t1.`longitude`, '
                       . 't1.`url`, t1.`description`, t1.`glyph`, '
                       . 't3.`icon_id`, t3.`iconUrl`, t4.*'
                       . 'FROM `%smod_leafletmaps_markers` AS t1 '
                       . 'JOIN `%smod_leafletmaps_icons` AS t3 '
                       . 'ON `t1`.`icon_id`=`t3`.`icon_id` '
                       . 'JOIN `%smod_leafletmaps_iconsets` AS t4 '
                       . 'ON `t3`.`class_id`=`t4`.`class_id` '
                       . 'WHERE `t1`.`section_id`=%d AND `t1`.`active`=1 '
                       . 'ORDER BY `t1`.`pos` ASC';
            }
            $sth   = self::db()->query(sprintf(
                $query, TABLE_PREFIX, TABLE_PREFIX, TABLE_PREFIX, $section_id
            ));
            return ( !defined('CAT_VERSION') ? self::fetchall($sth) : $sth->fetchAll() );
        }   // end function markers()

        /**
         * get the settings for the given section
         *
         * @access public
         * @param  integer  $section_id
         * @return array
         **/
        public static function settings($section_id) {
            $query = 'SELECT * FROM `%smod_leafletmaps_settings` WHERE `section_id`=%d';
            $sth   = self::db()->query(sprintf(
                $query, TABLE_PREFIX, $section_id
            ));
            return ( !defined('CAT_VERSION') ? $sth->fetchRow() : $sth->fetch() );
        }

        /**
         *
         * @access protected
         * @return
         **/
        protected static function db()
        {
            global $database;
            if(!is_object(self::$db)) {
                if(defined('CAT_VERSION')) {
                    $database = CAT_Helper_DB::getInstance();
                    if(!defined('TABLE_PREFIX')) define('TABLE_PREFIX',$database::prefix());
                }
                self::$db = $database;
            }
            return self::$db;
        }   // end function db()
    }
}

