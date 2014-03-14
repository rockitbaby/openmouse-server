<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('./error.php');
require_once('./debugger.php');
Debugger::log("hi");
Debugger::log("hi2");
Debugger::pr("at first");
Debugger::output("hi2");

Error::out("Error");