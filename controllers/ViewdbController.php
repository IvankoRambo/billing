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
		
		$recordsList = array();
		$keysList = array();
		foreach ($tableList as $table){
			$tableObj = $this->connection->getTable($table);
			$records = $tableObj->getRecordsFromTable();
			if(count($records) != 0) {
				$keys = array_keys($records[0]);
			}
			$records = array_reverse($records);



			$recordsList[] = $records;
			$keysList[] = $keys;
		}
		$this->view->recordsList = $recordsList;
		$this->view->keysList = $keysList;
		
		
		$logRecordsList = array();
		foreach ($logFilesPathes as $key => $logFilePath){
			$file = fopen($logFilePath, 'r');
			$records = array();
			while (!feof($file)) {
				$records[] = fgets($file);
			}
			array_pop($records);

			fclose($file);

			$records = array_reverse($records);
			$logRecordsList[$key] = $records;
			
		}
		
		// $this->view->tableRecords = $tableRecords;
		// $this->view->keyRecords = $keyRecords;
		$this->view->logRecordsList = $logRecordsList;	
	}
		
}


?>