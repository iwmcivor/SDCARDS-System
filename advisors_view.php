<?php
session_start();
require('functions.php');

$teamName = $_GET['tN'];
$groupName = $_GET['gN'];

$_SESSION['teamName'] = $teamName;
$_SESSION['team']=$groupName;
$conf = parse_ini_file("config.ini",true);
advisor_set($groupName,$conf);

header("Location: http://students.engr.scu.edu/~ravila/upload.php");

?>
