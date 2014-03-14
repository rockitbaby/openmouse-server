<?php

define('ROOT', dirname(__FILE__));
require_once('config.php');

if (file_exists(MUFFIN.DS.'muffin.php')) {
	include(MUFFIN.DS.'muffin.php');
}

//if code execuion comes to this point something went wrong
echo "<h1>BOOT ERROR</h1>";

?>