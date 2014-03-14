<?php
/**
 * MuffinController
 *
 * C of MVC
 *
 *
 */
class MuffinController {
	
	var $model = true;
	
	function __construct() {
		if (!preg_match('/(.*)Controller/i', get_class($this), $r)) {
			Error::out('Can not parse controller name');
		}
		$this->name = $r[1];
		
		if ($this->model) {
			if (!Loader::model($this->name)) {
				Error::out('Model file does not exist.');
			}
			$modelName = ucfirst($this->name).'Model';
			if(!class_exists($modelName)) {
				Error::out('Model class does not exist.');
			}
			$this->{$this->name} = new $modelName;
		}
		
		$this->View = new View();
		$this->View->base = strtolower($this->name);
	}
	
	function setParams($action, $extension) {
		$this->View->template = strtolower($action);
		$this->View->extension = strtolower($extension);
	}
	
	function redirect($url) {
		header('Location: '.$url);
	}

	function render($action = null) {
		$this->View->render($action);
	}

	function set($name, $value = null) {
		$this->View->assign($name, $value);
	}

}