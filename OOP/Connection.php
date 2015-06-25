<?php

/*
* Singleton class for connection to database, ought to remake for PDO module
*/

/*
class Connection{
private $dbhost = '127.0.0.1',
$dbname = 'billing',
$dbuser = 'root',
$dbpass = 'kolaider';
protected static $_instance;
public static function getInstance(){
if(is_null(self::$_instance)) self::$_instance = new self;
return self::$_instance;
}
private function __construct(){
$this->connect = @mysql_connect($this->dbhost, $this->dbuser, $this->dbpass);
if(!$this->connect){
echo '<p>The error in mysql connection</p>';
exit();
}
if(!mysql_select_db($this->dbname, $this->connect)){
echo '<p>Can\'t connect to appropriate database</p>';
exit();
}
}
public function query($query){
if(isset(self::$_instance->connect)){
$result = mysql_query($query) or die("<p>The appropriate query doesnt get a response</p>");;
return $result;
}
else {
echo "<p>There is still no object and connection to database</p>";
}
}
}
*/

?>
