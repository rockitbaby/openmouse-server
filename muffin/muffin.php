<?php
/**
 * muffin
 *
 * 'Boots' muffin framework and application
 *
 *
 */

require_save_or_die(MUFFIN.DS.'basic.php');

//core classes of muffin to be loaded
$classes = array('error', 'debugger', 'dispatcher', 'loader', 'settings', 'db', 'controller', 'model', 'view', 'cache');

foreach($classes as $class) {
	
	// load muffin core class names Muffin*
	if (!require_save(MUFFIN_LIB.DS.$class.'.php')) {
		die('Could not load '.ucfirst($class));
	}
	
	// load app classes that extend Muffin* from app lib
	require_save(APP_LIB.DS.$class.'.php');
}

// create classes that are not overwritten by app
require_save_or_die(MUFFIN.DS.'autoloader.php');

Dispatcher::dispatch();

Debugger::output();

//exit
exit();

/**
 * Require Save
 *
 * Checks if a file exists, than includes it and retruns if included
 * @param string $filename name of file to require
 */
function require_save($filename) {
	if (!file_exists($filename)) {
		return false;
	}
	require_once($filename);
	return true;
}

/**
 * Require Save or Die
 *
 * dies with message if a file could not be included
 */
function require_save_or_die($filename) {
	if (!require_save($filename)) {
		die('Could not load '.$filename);
	}
}