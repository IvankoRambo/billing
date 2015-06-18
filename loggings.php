<?php

/*
 * Loggings
 */
 
 function insertIntoLogFile($filepath, $info){
 	$fd = fopen($filepath, "a");
	if($fd == -1)	die("Error opening of file");
	fputs($fd, $info."\r\n");
	fclose($fd);
	return true;
 }
 
 
 function getFromLogFile($filepath){
 	$fd = fopen($filepath, "r");
	if($fd == -1)	die("Error opening of file");
	$log_array = array();
	
	while(!feof($fd)){
		$log_array[] = rtrim(fgets($fd));
	}
	
	$false_key = array_search('', $log_array);
	if($false_key)	unset($log_array[$false_key]);
	
	return $log_array;
	
 }

?>