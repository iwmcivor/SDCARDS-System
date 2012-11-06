<?php
require('header.php');
require('functions.php');

session_start();
?>
<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="bar">
<?php
require('header.php');
if(!isset($_SESSION['user']))
{
    echo 'Invalid login.<br />';
    echo '<a href="login.php">Back to Login Page</a>';
    die();
}else
{
    echo 'Welcome '.$_SESSION['user'].'!<br />';
}
?>
<a href="logout.php" style="right:10px"> Log Out </a>
</div>



<?php


if(!isset($_SESSION['team']) && !isset($_SESSION['advisees']))
{
	echo 'You\'re not in a valid group.
	      Please contact the Admin to be added.';
	die();
}

if(isset($_SESSION['advisees']) && !isset($_SESSION['team']))
{
	require('advisor.php');
	die();
}

if(isset($_SESSION['advisees']))
	echo '<p><a href=advisor_switch.php>Back to Advisee List</a><p>';


$group = $_SESSION['teamName'];

echo "$group's Dropbox";

//$name = 'Problem Statement';

is_group_dir($path.$group);

$target_path = "$path$group/";


foreach($_SESSION['reqs'] as $key)
{

$target_path = "$path$group/";
list($name, $ext) = split(',',$key);
$fileTypes = ext_array($ext);

$nameWhite = str_replace(" ","",$name);
$nameWhitefile = $nameWhite . 'file';

$file = $_FILES["$nameWhitefile"]["name"];

echo "<span id=$nameWhite></span>";

//$fileTypes = array("png","doc","txt","pdf");
if(isset($_POST[$nameWhite]))
{
        upload_file($file, $fileTypes, $target_path, $nameWhite,$_FILES["$nameWhitefile"]["tmp_name"]);
}

echo '<div class="tile-container">';
echo '<div class="tile" id="tile1"><!--<div>DROP FILES HERE!</div><br />-->';

echo "<h1>$name</h1>";

echo '<div class="tile">';

$ext = file_check($nameWhite, $fileTypes, $target_path);

if($ext != false)
{
    $target_path = $target_path."$nameWhite.$ext";
    echo '<a href="'.$target_path.'" id="download" >Download File</a>';
    //echo "<a href='download.php?ext=$ext&path=$target_path&name=$name&team=$group>Download File</a>";
}
else
    echo '<span id="download">No File Uploaded</span>';

echo '</div>';
if(!isset($_SESSION['advisees']))
{
echo '<div class="tile">
<form enctype="multipart/form-data" action="upload.php#'.$nameWhite.'" method="POST">
        <input type="hidden" />
        Choose a file to upload:<input name="'.$nameWhite.'file" type="file" /><br />
        <input type="submit" name="'.$nameWhite.'"  value="Upload File" />
</form>
</div>';
}
echo '</div></div>';
}
?>  
