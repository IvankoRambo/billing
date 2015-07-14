<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class ViewdbController extends Component\BaseController{
	
	
	public function indexAction(){
		
		$tableList = $this->connection->getTablesList();
		$this->view->tableList = $tableList;
		$logDir = 'logs/';
		$logFiles = scandir($logDir);
		$logFiles = array_splice($logFiles, 2);
		$this->view->logFiles = $logFiles;
		
		$logFilesPathes = array();
		foreach ($logFiles as $key => $logFile) {
			$logFilesPathes[$key] = $logDir . $logFile;
		}
		
		$this->view->logFilesPathes = $logFilesPathes;
		
		$this->view->records = array();
		foreach ($tableList as $table){
			$tableObj = $this->connection->getTable($table);
			$records = $tableObj->getRecordsFromTable();
			if(count($records) != 0) {
				$keys = array_keys($records[0]);
				$this->view->keys = $keys;
			}
			$records = array_reverse($records);
			$this->view->records[] = $records;
		}
		
		$this->view->log_records = array();
		foreach ($logFilesPathes as $key => $logFilePath){
			$file = fopen($logFilePath, 'r');
			$records = array();
			while (!feof($file)) {
				$records[] = fgets($file);
			}
			array_pop($records);

			fclose($file);

			$log_records = array_reverse($records);
			$this->view->log_records[] = $log_records;
			
		}
			
	}
		
}


?>