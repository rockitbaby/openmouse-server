<?php
/**
 * MuffinDispatcher
 *
 * Maps requests URL to actions
 *
 *
 */
class MuffinDispatcher {
	
	var $error = '';
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Error();
		}
		return $instance[0];
	}
	
	static function dispatch() {
		$request = substr($_SERVER['REQUEST_URI'], strlen(WEB_DIR));
		$request = str_replace('?'.$_SERVER['QUERY_STRING'], '', $request);
		$extension = DEFAULT_EXTENSION;
		if (preg_match('/\.[0-9a-zA-Z]*$/', $request, $match) === 1) {
			$extension = substr($match[0], 1);
		}
		if (strpos($request, '.' . $extension)) {
			$request = substr($request, 0, strpos($request, '.' . $extension));
		}
		
		$urlparams = split('/', $request);
		
		if (empty($urlparams) || empty($urlparams[0])) {
			$urlparams = split('/', HOME);
		}
		
		//Cache::useorstart(implode('/', $urlparams).$extension.implode('?', $_GET));
		
		if(!Loader::controller($urlparams[0])) {
			Error::out('Controller file '.$urlparams[0].' does not exist.');
		}
		$controllerName = ucfirst($urlparams[0]).'Controller';
		if(!class_exists($controllerName)) {
			Error::out('Controller class does not exist.');
		}
		
		$controller = new $controllerName;
		
		$action = (count($urlparams) < 2) ? 'index' : strtolower($urlparams[1]);
		
		if (!method_exists($controller, $action)) {
			Error::out('Action does not exist in Controller.');
		}
		
		$controller->params = $_GET;
		$controller->data = $_POST;
		
		Dispatcher::call($controller, $action, array_slice($urlparams, 2));
		
		$controller->setParams($action, $extension);
		
		$controller->render();
		
		Cache::stop();
		
	}
	
	private function call($controller, $action, $actionparams) {
		call_user_func_array(array($controller, $action), $actionparams);
	}
	
}