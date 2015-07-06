<?php

namespace OOP;

class Logging{
	
	protected $filepath;
	
	public function __construct($filepath){
		$this->filepath = $filepath;
	}
	
	public function insertIntoLogFile($info, $date){
		
		$fd = fopen($this->filepath, "a");
		if($fd == -1)	die("Error opening of file");
		fputs($fd, $info.' ['.$date."]\r\n");
		fclose($fd);
		return true;
		
	}
	
	public function getFromLogFile(){
		
		$fd = fopen($this->filepath, "r");
		if($fd == -1)	die("Error opening of file");
		$log_array = array();
		
		while(!feof($fd)){
			$log_array[] = rtrim(fgets($fd));
		}
		
		$false_key = array_search('', $log_array);
		if($false_key)	unset($log_array[$false_key]);
		
		return $log_array;
		
	}
	
}

?>