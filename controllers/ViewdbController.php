<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class ViewdbController extends Component\BaseController{
	
	
	
	protected function makePrettyValue($field){
		
		$data = json_decode($field);
		if ($data == NULL) {
			$data = str_replace("'", '"', $field);
			$data = json_decode($data);
			if ($data == NULL) {
				$data = str_replace('"', '\"', $field);
				$data = json_decode('"'.$data.'"');

			}
		} 
		$res = json_encode($data, JSON_PRETTY_PRINT);
		// $res = htmlspecialchars($res);
		$res = str_replace(array('\"', '\/'), array('"', '/'), $res);

		return '<pre class="json-obj">'
		.$res
		.'</pre>';	
		
	}
	
	
	public function indexAction(){
			
		$this->view->tableList = $this->connection->getTablesList();
		$logDir = __DIR__.'/../logs/';
		$logFiles = scandir($logDir);
		$this->view->logFiles = array_splice($logFiles, 2);
		
		$logFilesPathes = array();
		foreach ($logFiles as $key => $logFile) {
			$logFilesPathes[$key] = $logDir . $logFile;
		}
		
		$this->view->logFilesPathes = $logFilesPathes;
		
		foreach ($this->view->tableList as $table){
			$tableObj = $this->connection->getTable($table);
			$records = $tableObj->getRecordsFromTable();
			if(count($records) != 0) {
				$this->view->keys = array_keys($records[0]);
			}
			$this->view->records = array_reverse($records);
			
			foreach($records as $record){
				//$this->view->prettyValue[] = array();
				foreach ($record as $field){
						//$this->view->prettyValue[][] = $this->makePrettyValue($field);
				}
			}
			
		}
		
		foreach ($logFilesPathes as $key => $logFilePath){
			$this->view->logPrettyValue = array(); 
			$file = fopen($logFilePath, 'r');
			$records = array();
			while (!feof($file)) {
				$records[] = fgets($file);
			}
			array_pop($records);

			fclose($file);

			$records = array_reverse($records);
			
			
			foreach ($records as $record){
					$this->view->prettyValue = $this->makePrettyValue($record);
			}
			
			
		}		
			
			
	}
		
}


?>