<?php
Zend_Loader::loadClass('Zend_View_Helper_Abstract');

class Zend_View_Helper_BeautyTransform extends Zend_View_Helper_Abstract{
	
	public $view;
	
	public function setView(Zend_View_Interface $view){
		$this->view = $view;
	}
	
	public function beautyTransform(){
		return $this;
	}
	
	public function makePrettyValue($field){
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
		
}

?>