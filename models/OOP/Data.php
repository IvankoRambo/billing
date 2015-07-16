<?php
namespace OOP;
use \PDO;

class Data implements iData{
	
	protected $send_data_json;
	protected $receive_data_json;
	
	public function __construct(){}
	
	public function sendData($db, $key_info, $info, $address = null, $secret_key = null, $urlDomain = null, $urlPath = null, $partner = null, $key = null){
		
		$url = $address;
		$destination = $partner;
		$fields = array(
			$key_info => $info,
			'secret_key' => $secret_key
		);
		
		$fields_str = '';
		
		foreach($fields as $key=>$value) { $fields_str .= $key.'='.$value.'&'; }
		$fields_str = trim($fields_str, '&');
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		if(!$response || preg_match('/not found/', $response)) {
			$this->insertIntoFailedTable($db, $key_info, $info, $destination);
		}
		
		$this->send_data_json = $info;
		return $response;
		
	}
	
	
	private function insertIntoFailedTable($db, $sufix, $data, $destination){
		$query = $db->prepare("INSERT INTO failed_{$sufix} (data, destination) VALUE (:data, :destination)");
		$query->bindParam(":data", $data, PDO::PARAM_STR);
		$query->bindParam(":destination", $destination, PDO::PARAM_STR);
		
		return ( $query->execute() );
	}
	
	
	public function receiveData($data, $db = null, SecretKey $obj = null, $arrayed = false){
		$this->receive_data_json = $data;
		return ( $this->isJson($data) ) ? json_decode($this->receive_data_json, $arrayed) : $this->receive_data_json;		
	}
	
	
	private function isJson($data){
		json_decode($data);
		return ( json_last_error() === JSON_ERROR_NONE );
	}
		
}

?>