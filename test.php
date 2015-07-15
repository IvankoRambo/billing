<?php

$filepath = 'config/urls.ini';

$urls = parse_ini_file($filepath, true);
var_dump($urls);

?>