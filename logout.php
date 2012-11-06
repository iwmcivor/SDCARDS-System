<?php
require('header.php');

session_start();
session_unset();
session_destroy();

header("Location: http://students.engr.scu.edu/~ravila/login.php");

?>
