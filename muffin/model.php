<?php
/**
 * MuffinModel
 *
 * M of MVC
 *
 *
 */
class MuffinModel {
	
	function __construct() {
		if (isset($this->uses)) {
			$this->loadModels();
		}
	}
	
	function loadModels() {
		$uses = $this->uses;
		if (is_string($uses)) {
			$uses = array($uses);
		}
		foreach($uses as $use) {
			Loader::model($use);
			$classname = $use.'Model';
			$this->{$use} = new $classname;
		}
	}
}