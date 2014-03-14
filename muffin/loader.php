<?php
/**
 * MuffinLoader
 *
 * load stuff
 *
 *
 */
class MuffinLoader {
	
	var $error = '';
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Loader();
		}
		return $instance[0];
	}
	
	static function load($name, $type = '') {
		$filename = ucfirst($name).ucfirst($type).'.php';
		return require_save(APP.DS.$filename);
	}
	
	static function controller($name) {
		return Loader::load($name, 'Controller');
	}
	
	static function model($name) {
		return Loader::load($name, 'Model');
	}
	
	static function vendor($name) {
		return require_save(APP_VENDORS.DS.$name.DS.$name.'.php');
	}
	
	static function settings() {
		return require_save(APP.DS.'app-settings.php');
	}
	
}