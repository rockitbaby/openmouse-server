<?php
/**
 * MuffinDebugger
 *
 * Singleton Debugging Helper
 *
 *
 */
class MuffinDebugger {
	
	var $logs = array();
	
	function __construct() {
		if(Debugger::level()) {
			ini_set('display_errors', 1);
			error_reporting(E_ALL);
		} else {
			ini_set('display_errors', 0);
		}
	}
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Debugger();
		}
		return $instance[0];
	}
	
	static function log($s) {
		$_this = Debugger::getInstance();
		$_this->logs[] = $s;
	}
	
	static function pr($s) {
		echo "<pre>\n";
		print_r($s);
		echo "\n</pre>\n";
	}
	
	static function level() {
		if (!defined('DEBUG')) {
			return 0;
		}
		return DEBUG;
	}
	
	static function output() {
		$_this = Debugger::getInstance();
		if(!Debugger::level()) {
			return;
		}
		foreach($_this->logs as $log) {
			Debugger::pr($log);
		}
	}
}