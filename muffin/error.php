<?php
/**
 * MuffinError
 *
 * Singleton Error Handling. Throws 404 most of the time
 * If DEBUG > 0 prints out messages
 *
 *
 */
class MuffinError {
	
	var $error = '';
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Error();
		}
		return $instance[0];
	}
	
	static function out($s) {
		$_this = Error::getInstance();
		$_this->error = $s;
		if (Debugger::level()) {
			print_r($_this->error);
		}
		//exit(0);
	}
	
	static function missingController($s) {
		Error::out($s);
	}
	
	static function missingAction($s) {
		Error::out($s);
	}
}