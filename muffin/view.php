<?php
/**
 * MuffinView
 *
 * V of MVC
 *
 *
 */
class MuffinView {
	
	var $vars = array();
	var $base = '';
	var $template = '';
	var $extension = '';

	function __construct() {

	}
	
	function assign($name, $value = null) {
		if(is_array($name)) {
			$this->vars = array_merge($this->vars, $name);
			return;
		}
		$this->vars[$name] = $value;
	}
	
	function render($name = null) {
		//make vars visible in templates
		extract($this->vars);
		
		if (!$name) {
			$name = $this->base.'-'.$this->template;
		} else {
			$name = $this->base.'-'.$name;
		}
		
		$filename = TEMPLATES.DS.$name.".".$this->extension.".tpl";
		
		if (file_exists($filename)) {
			include($filename);
		} else {
			$filename = TEMPLATES.DS.$name.".tpl";
			if(file_exists($filename)) {
				include($filename);
			} else {
				Error::out("Template not found");
			}
		}
	}

	function getRendered($name) {
		ob_start();
		$this->render($name);
		$txt = ob_get_clean();
		return $txt;
	}
}