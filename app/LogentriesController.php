<?php

class LogentriesController extends Controller {

	function sessions() {
		
		$sessions = $this->Logentries->getSessions();
		
		$this->set(compact('sessions'));
		
	}
	
	function add() {
		if($_GET['key'] != $settings['Domain.key']) {
			header('HTTP/1.0 401 Unauthorized');
			return;
		}
		$data['event'] = $_GET['event'];
		$data['value'] = $_GET['value'];
		
		if(strpos($data['value'], 'http://localhost:8888/') !== false) {
			return;
		}
		
		$data['created'] = date('Y-m-d H:i:s');
		
		$callback = $_GET['callback'];
		$res['id'] = $this->Logentries->add($data);
		
		$this->set(compact('callback', 'res'));
		
		header('Content-Type: text/javascript');
	}
	
	function data($id) {
		if($_POST['key'] != $settings['Domain.key']) {
			header('HTTP/1.0 401 Unauthorized');
			return;
		}
		if(empty($_POST['data'])) {
			exit();
		}
		
		$this->Logentries->data($id, $_POST['data']); //$_POST['data']);
		
		$callback = $_GET['callback'];
		$res['id'] = $id;
		$res['msg'] = "Got data";
		$this->set(compact('callback', 'res'));
		header('Content-Type: text/javascript');
	}

	function special($type) {
		if($_POST['key'] != $settings['Domain.key']) {
			header('HTTP/1.0 401 Unauthorized');
			return;
		}
		if(empty($_POST['event'])) {
			exit();
		}
		$data['event'] = $_POST['event'];
		$data['value'] = $_POST['value'];
		$data['created'] = date('Y-m-d H:i:s');

		$res['id'] = $this->Logentries->add($data);

		$entryData = $_POST['data'];
		$entryData['type'] = $type;
		$this->Logentries->data($res['id'], $entryData);
		
		$this->set(compact('res'));
		//print_r("HLLO WORLD");
		header('Content-Type: text/javascript');
	}
	
	function shot($id = 0, $version = 1, $type = 'org') {
		$res['id'] = "id";
		$res['msg'] = "Got data";
		$this->set(compact('res'));
		
		$postText = trim(file_get_contents('php://input'));
		$img = base64_decode($postText);
		file_put_contents(ROOT.DS.'public'.DS.'openmouse'.DS.'captures'.DS.$id.'-'.$version.'-'.$type.'.png', $img);
		header('Content-Type: text/javascript');
	}
	
	function capture($id, $version = 1) {
		
		$sql = "SELECT * FROM logentries WHERE id = ".$id;
		$res = Db::read($sql);
		if(!$res) {
			return false;
		}
		
		$entry = $res[0];
		
		$this->set(compact('id', 'version', 'entry'));
	}
	
	
	function img() {
		
		$im = imagecreatefrompng(ROOT.DS.'public'.DS.'ulk'.DS.'snapshot_00000.png');
		
		$im = $this->crop($im, $_GET['w'], $_GET['h']);
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
		//echo file_get_contents($_GET['url']);
		exit();
	}
	
	function index($enddate = null, $startdate = null) {
		
		$theme = isset($_GET['theme']) ? $_GET['theme'] : '';
		$start = null;
		$end = null;
		$replacementMap = array(
			',' => ':',
			'_' => ' ',
		);
		
		if($enddate) {
			$enddate = str_replace(array_keys($replacementMap), array_values($replacementMap), $enddate);
			$end = strtotime($enddate);
		}
		
		if($startdate) {
			$startdate = str_replace(array_keys($replacementMap), array_values($replacementMap), $startdate);
			$start = strtotime($startdate);
		}
		
		if($start == null) {
			$start = round(time() / 60) * 60 + 60;
		}
		if($end == null || $start - $end > 60 * 60 * 4) {
			$end = $start - 60 * 60 * 4; // 4 hours;
		}
		
		$logentries = $this->Logentries->findAllByMinutes($start, $end);
		$this->set(compact('start', 'end', 'logentries', 'theme'));
	}
	
	function crop($im, $tw, $th, $options = array()) {
		
		$defaultOptions = array('align' => 'center', 'valign' => 'middle');
		$options = array_merge($defaultOptions, $options);
		extract($options);
		/*
			tw = target width
			th = target height
			cw = crop width
			ch = crop height
			cx = crop x
			cy = crop y
		*/
		$w = imagesx($im);
		$h = imagesy($im);
	
		if ($th * $w / $h > $tw) {
			// x abschneiden:
			$ch = $th;
			$cw = $th * $w / $h;
			$cx = $cw / 2 - $tw / 2;
			$cy = 0;
		} else {
			// y abschneiden:
			$cw = $tw;
			$ch = $tw * $h / $w;
			$cy = $ch / 2 - $th / 2;
			$cx = 0;
		}
	
		if ($valign == "top")
			$cy = 0;
		if ($valign == "bottom")
			$cy = $ch - $th;
	
		if ($align == "left")
			$cx = 0;
		if ($align == "right")
			$cx = $cx - $tx;
	
		$cw = floor($cw);
		$ch = floor($ch);
		//pr($cw);
		//pr($ch);
		$resized = imagecreatetruecolor($cw, $ch);
		@imagecopyresampled($resized, $im, 0, 0, 0, 0, $cw, $ch, $w, $h);

		$thumbnail = imagecreatetruecolor($tw, $th);
		@imagecopyresampled($thumbnail, $resized, 0, 0, $cx, $cy, $tw, $th, $tw, $th);
		
		$im = $thumbnail;
		imagedestroy($resized);
		return $im;
	}
	
}