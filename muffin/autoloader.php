<?php

if (!class_exists('Error')) {
	class Error extends MuffinError {}
}

if (!class_exists('Debugger')) {
	class Debugger extends MuffinDebugger {}
}

if (!class_exists('Dispatcher')) {
	class Dispatcher extends MuffinDispatcher {}
}

if (!class_exists('Loader')) {
	class Loader extends MuffinLoader {}
}

if (!class_exists('Settings')) {
	class Settings extends MuffinSettings {}
}

if (!class_exists('Db')) {
	class Db extends MuffinDb {}
}

if (!class_exists('Controller')) {
	class Controller extends MuffinController {}
}

if (!class_exists('Model')) {
	class Model extends MuffinModel {}
}

if (!class_exists('View')) {
	class View extends MuffinView {}
}

if (!class_exists('Cache')) {
	class Cache extends MuffinCache {}
}