<?php

class LogentriesModel extends Model {
	
	
	function getSessions() {
		
		$sessions = array(
		);
		
		return $sessions;
	}
	
	function add($data) {
		
		$keys = implode(',', array_keys($data));
		$values = "'".implode("', '", array_values($data))."'";
		
		$sql = "INSERT INTO logentries ($keys) VALUES($values)";
		
		if(!Db::query($sql)) {
			return 0;
		}
		return Db::lastId();
	}
	
	function data($id, $data) {
		$sql = "SELECT * FROM logentries WHERE id = ".$id;
		$res = Db::read($sql);
		if(!$res) {
			return false;
		}
		
		$row = $res[0];
		$existingData = unserialize($row['data']);
		if(empty($existingData)) {
			$existingData = array();
		}
		$data = array_merge($existingData, $data);
		$data = serialize($data);
		
		$sql = "UPDATE logentries SET data = '".$data."' WHERE id = ".$row['id'];
		return Db::query($sql);
		
	}
	
	function findAll() {
		$sql = "SELECT * FROM logentries ORDER BY created DESC";
		return Db::read($sql);
	}
	
	function findAllByMinutes($start, $end) {
		
		
		$sql = "SELECT * FROM logentries WHERE created > '".date('Y-m-d H:i:s', $end)."' AND created < '".date('Y-m-d H:i:s', $start)."' ORDER BY created DESC";
		$data = Db::read($sql);
		
		$minutes = array_reverse(range($end, $start, 60));
		$stats = array();
		foreach($minutes as $i => $minute) {
			$key = $minute - $end;
			$stats[$key] = array();
			$stats[$key]['date'] = $minute;
			$stats[$key]['entries'] = array();
		}
		foreach($data as $row) {
			$minute = (round((strtotime($row['created']) - $end) / 60)) * 60;
			$key = $minute;
			$stats[$key]['entries'][] = $row;
		}
		return $stats;
	}
}