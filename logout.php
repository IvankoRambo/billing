<?php
session_start();
unset($_SESSION["isLogged"]);
header("Location: index.php");