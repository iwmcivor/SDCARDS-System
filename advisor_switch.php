<?php
session_start();

unset($_SESSION['team']);

header("Location: http://students.engr.scu.edu/~ravila/upload.php");

?>
