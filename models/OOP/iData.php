<?php

namespace OOP;

interface iData{
	public function sendData($db, $key_info, $info, $address = null, $secret_key = null, $urlDomain = null, $urlPath = null, $partner = null, $key = null);
	public function receiveData($data, $db = null, SecretKey $obj = null);
}


?>