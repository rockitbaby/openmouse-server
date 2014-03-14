<?php

	// debug level: 0 or 1 - use 0 for production
	define('DEBUG', 0);

	// directory seperator - tring to make things platform independent
	define('DS', '/');
	
	define('WEB_DIR', '/');
	
	// location of the muffin framework
	define('MUFFIN', ROOT.DS.'muffin');

	// location of the application
	define('APP', ROOT.DS.'app');

	// location of the application templates
	define('TEMPLATES', APP.DS.'templates');

	// used to extend all parts of core muffin lib
	define('APP_LIB', APP.DS.'lib');

	// used to include 3rd party stuff
	define('APP_VENDORS', APP.DS.'vendors');

	// we just have tmp directory
	define('APP_TMP', APP.DS.'tmp');

	// we just have tmp directory
	define('CACHE', APP_TMP.DS.'cache');

	// we just have tmp directory
	define('HOME', 'logentries/sessions');

	// DATABASE
	define('DB_SERVER', 'localhost');
	define('DB_NAME', '');
	define('DB_USER', '');
	define('DB_PASSWORD', '');

	// directory of muffin library
	define('MUFFIN_LIB', MUFFIN);
	
	define('DEFAULT_EXTENSION', 'html');

	ini_set('display_errors', 1);
	error_reporting(E_ALL);
?>