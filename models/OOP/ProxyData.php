<?php

namespace OOP;
use \PDO;

class ProxyData implements iData{
	
	protected $_data = NULL;
	
	public function sendData($db, $key_info, $info, $address = null, $secret_key = null, $urlDomain = null, $urlPath = null, $partner = null, $key = null){
		
		settype($urlDomain, 'String');
	    settype($urlPath, 'String');
	    settype($partner, 'String');
	    settype($key, 'String');
	    $URL_sig = "hash";
	    $URL_partner = "asid";
	    $URLreturn = "";
	    $URLtmp = "";
	    $s = "";

	    if (!(strpos($urlPath, '?'))) {
	        $urlPath = $urlPath.'?';
	    }
	    $urlPath = str_replace(" ", "+", $urlPath);

	    if (substr($urlPath, -1) == '?') {
	        $URLtmp = $urlPath.$URL_partner . "=" . $partner;
	    }
	    else {
	        $URLtmp = $urlPath . "&" . $URL_partner . "=" . $partner;
	    }
		if(!preg_match('|^\/|', $urlPath)){
	    	$s = '/'.$urlPath . $URL_partner . "=" . $partner . $key;
		}
		else{
			$s = $urlPath . $URL_partner . "=" . $partner . $key;
		}
	    $tokken = "";
	    $tokken = base64_encode(pack('H*', md5($s)));
	    $tokken = str_replace(array("+", "/", "="), array(".", "_", "-"), $tokken);
	    $URLreturn = $urlDomain . $URLtmp . "&" . $URL_sig . "=" . $tokken;
	    $address = $URLreturn;
		
		if(NULL == $this->_data){
			$this->makeData();
		}

		return $this->_data->sendData($db, $key_info, $info, $address, null, null, null, $partner);
		
	}

	public function receiveData($data, $db = null, SecretKey $obj = null, $arrayed = false){
		
		$_get = $_GET;
		$check_info = $obj->selectSecretKey($db, $_get['asid']);
		if(empty($check_info)){
			return false;
		}
		else{
			$urlPath = stristr($_SERVER['REQUEST_URI'], '&hash', True);
		    $urlPath = str_replace(" ", "+", $urlPath);
		    $s = $urlPath.$check_info[0]['secret_key'];
		    $check_key = "";
		    $check_key = base64_encode(pack('H*', md5($s)));
		    $check_key = str_replace(array("+", "/", "="), array(".", "_", "-"), $check_key);
			
			if($check_key != $_get['hash']){
				return false;
			}
			else{
				if(NULL == $this->_data){
					$this->makeData();
				}
				return $this->_data->receiveData($data, null, null, $arrayed);
			}
			
		}
		
	}
	
	
	private function makeData(){
		$this->_data = new Data();
	}
	
}

?>
