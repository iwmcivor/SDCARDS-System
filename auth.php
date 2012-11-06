<?php
require('header.php');
$fp = fsockopen('ssl://pop.scu.edu',995);

//require('test.php');
require('functions.php');
if($fp)
{
    $username = "USER ".$_POST['username']."\n";
    $password = "PASS ".$_POST["password"]."\n";
    
    $trash = fgets($fp,128);
    
    $nameTrash = fwrite($fp,$username,strlen($username));
    
    $resultsName = fgets($fp);
    
    if($resultsName[0]=='+' && $resultsName[1]=='O' && $resultsName[2]=='K')
    {
        $username = $_POST['username'];
    }
    
    $passTrash = fwrite($fp,$password,strlen($password));
    
    $resultsPass = fgets($fp);
    
    if($resultsPass[0]=='+' && $resultsPass[1]=='O' && $resultsPass[2]=='K')
    {
        session_start();
        $_SESSION['user'] = $username;
	$pos;
	if($pos = strrpos($username,'@'))
		$username = substr($username,0,$pos);
	if(!member_check($username))
		advisor_check($username);
    }
 
   if($_POST['username'] == 'user')
   {
        session_start();
	$_SESSION['user'] = 'user';
	member_check('user');
   }

   if($_POST['username']=='admin')
   {
	session_start();
	$_SESSION['user']='admin';
	advisor_check('admin');
    }
   
    header("Location: http://students.engr.scu.edu/~ravila/upload.php");
}
else
{
    echo '<p>Could not connect to Server!</p>';
}
    
?>

