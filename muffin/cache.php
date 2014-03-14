<?php
/**
 * MuffinDb
 *
 * Database connection plus CRUD
 *
 *
 */
class MuffinCache {
	
	var $url = null;
	
	function __construct() {
		
	}
	
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new Cache();
		}
		return $instance[0];
	}
	
	function filename($url) {
		return CACHE.DS.md5($url);
	}
	
	function isCached($url) {
		$_this = Cache::getInstance();
		if (file_exists($_this->filename($url))) {
			return true;
		}
		return false;
	}
	
	function useorstart($url) {
		$_this = Cache::getInstance();
		if ($_this->isCached($url)) {
			readfile($_this->filename($url));
			exit();
		} else {
			$_this->start($url);
		}
	}
	
	function clear() {
		$_this = Cache::getInstance();
		rmdir_recurse(CACHE);
	}
	
	function start($url) {
		$_this = Cache::getInstance();
		$_this->url = $url;
		ob_start();
	}
	
	function stop() {
		$_this = Cache::getInstance();
		if ($_this->url) {
			$content = ob_get_clean();
			file_put_contents($_this->filename($_this->url), $content);
			echo $content;
			exit();
		}
	}
	
}

function rmdir_recurse($path, $removedir = false)
{
    $path = rtrim($path, '/').'/';
    $handle = opendir($path);
    while(false !== ($file = readdir($handle)))
    {
        if($file != '.' and $file != '..' )
        {
            $fullpath = $path.$file;
            if(is_dir($fullpath))
                rmdir_recurse($fullpath, true);
            else
                unlink($fullpath);
        }
    }

    closedir($handle);
    if ($removedir) {
    	rmdir($path);
    }
}