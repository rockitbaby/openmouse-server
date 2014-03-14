<?php
/**
 * MuffinSettings
 *
 * Singleton Error Handling. Throws 404 most of the time
 * If DEBUG > 0 prints out messages
 *
 *
 */
class MuffinSettings {
	
	var $settings = array();
	
	function __construct() {
		if (!Loader::settings()) {
			Error::out('Could not load app-settings');
			return false;
		}
		global $settings;
		$this->settings = $settings;
	}
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Settings();
		}
		return $instance[0];
	}
	
	static function get($key = '') {
		$_this = Settings::getInstance();
		
		if (!array_key_exists($key, $_this->settings)) {
			return false;
		}
		
		return $_this->settings[$key];
		
	}
	
}