<?php
namespace OOP;

class Urls {
	protected $iniFilePath;
	protected $urls;

	public function __construct($filepath = null) {
		if ($filepath == null) {
			$filepath = realpath(__DIR__.'/../../config/urls.ini');
		}
		$this->iniFilePath = $filepath;
		$this->urls = parse_ini_file($filepath, true);
	}

	public function getDomain($partner, $action) {
		if (!isset($this->urls[$partner])) {
			return false;
		}
		if (!isset($this->urls[$partner][$action])) {
			return false;
		}
		return $this->urls[$partner][$action]['urlDomain'];
	}

	public function getPath($partner, $action) {
		if (!isset($this->urls[$partner])) {
			return false;
		}
		if (!isset($this->urls[$partner][$action])) {
			return false;
		}
		return $this->urls[$partner][$action]['urlPath'];
	}
}

?>