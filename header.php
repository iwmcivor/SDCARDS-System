<?php
	if($_SERVER["HTTPS"] != "on")
		header("Location: https://ssl.".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);

$path="";

?>
