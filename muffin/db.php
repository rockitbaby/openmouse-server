<?php
/**
 * MuffinDb
 *
 * Database connection plus CRUD
 *
 *
 */
class MuffinDb {
	
	var $connection = null;
	var $result;
	
	function __construct() {
		if(!defined('DB_SERVER') || DB_SERVER === false) {
			return;
		}
		$this->connect();
	}
	
	function connect() {
		if (!($this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD))) {
			Error::out('Could not establish database connection');
		}
		if(!mysql_select_db(DB_NAME)) {
			Error::out('Could not select Database');
		}
	}
	
	function __deconstruct() {
		if ($this->connection) {
			mysql_close($this->connection);
		}
	}
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Db();
		}
		return $instance[0];
	}
	
	function query($sql) {
		$_this = Db::getInstance();
		if (!$_this->connection) {
			return false;
		}
		Debugger::log($sql);
		return ($_this->result = mysql_query($sql, $_this->connection));
	}
	
	function lastId() {
		$_this = Db::getInstance();
		return mysql_insert_id($_this->connection);
	}
	
	function read($sql) {
		$_this = DB::getInstance();
		
		$data = array();
		
		if (!$_this->query($sql)) {
			return $data;
		}
		
		while ($row = mysql_fetch_assoc($_this->result)) {
			$data[]= $row;
		}
		
		return $data;
	}
	
}