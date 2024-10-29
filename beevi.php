<?php
/*
Plugin Name: Beevi
Plugin URI: http://www.beevi.co/
Description: A complete solution to manage your sport club or organization!
Version: 2.0.2
Author: Beevi
Author URI: http://www.beevi.co
License: GPL
*/

define("OPTION_NAME", "beevi");
define('BEEVI_FILE', __FILE__);
define('BEEVI_PATH', plugin_dir_path(__FILE__));
require_once BEEVI_PATH.'includes/BeeviPlugin.php';

new BeeviPlugin();
?>