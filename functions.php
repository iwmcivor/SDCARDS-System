<?php
function start_session()
{
	session_start();
	if(!isset($_SESSION['user']))
	{
		echo 'You\'re not allowed to be here';
		echo '<br /><a href="login.php">Back to Login Page</a>';
		die();
	}

	if(!isset($_SESSION['team']) && !isset($_SESSION['advisees']))
	{
		echo 'You\'re not in a valid group.
		      Please contact the Admin to be added.';
		die();
	}
}

function get_file_extension($file_name) {
  return substr(strrchr($file_name,'.'),1);
}

function is_group_dir($group)
{
    if(!is_dir($group))
    {
       if(!mkdir('./'.$group,0700,true))
       //   if(!mkdir('./'.$group))
                echo 'The Folder failed to be created.';
    }
}

function upload($path, $newName, $oldName)
{
        $path = $path . $newName;
        if(move_uploaded_file($oldName, $path))
        {
               // echo "<br />the file " . $oldName.' has been uploaded';
                echo "<br /> The file has been uploaded!";
        }else
        {
            echo 'The file can\'t be uploaded.';
        }
           if ($_FILES['file']['error'] > 0) {
                echo '<p class="error">The file could not be uploaded because: <strong>';
                $error = 'The file couldn\'t be uploaded because: ';
                switch ($_FILES['upload']['error']) {
                        case 1 :
                                print 'The file exceeds the upload_max_filesize setting in php.ini.';
                                $error = $error . 'The file exceeds the upload_max_filesize setting in php.ini';
                                break;
                        case 2 :
                                print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
                                $error = $error . 'The file exceeds the MAX_FILE_SIZE setting in the HTML form';
 $error = $error . 'The file exceeds the MAX_FILE_SIZE setting in the HTML form';
                                break;
                        case 3 :
                                print 'The file was only partially uploaded.';
                                $error = $error . 'The file was only partially uploaded';
                                break;
                        case 4 :
                                print 'No file was uploaded.';
                                $error = $error . 'No file was uploaded';
                                break;
                        case 6 :
                                print 'No temporary folder was available.';
                                $error = $error . 'No temporary folder was available.';
                                break;
                        case 7 :
                                print 'Unable to write to the disk.';
                                $error = $error . 'Unable to write to the disk';
                                break;
                        case 8 :
                                print 'File upload stopped.';
                                $error = $error . 'File upload stopped';
                                break;
                        default :
                                print 'A system error occurred.';
                                $error = $error . 'A system error occurred';
                                break;
                      }
                     print '</strong></p>';
                 }

                //echo '<br />There was an error in uploading the file. ' . $oldName.' it didn\'t add.';

}

/*
 * Inputs are the file's current name(obtained using $_FILES['postName']['name']),
 * an array containing the extensions that are allowed, the path to the group's folder,
 * the name that the file will be given(usually the name of the requirement), and
 * the temp name that the file is given(obtained through $_FILES['postName']['tmp_name']
 */
function upload_file($file, $extArray, $path,$name, $tempUpload)
{
    $ext = get_file_extension($file);
    $valid = 0;

    foreach($extArray as $key)
    {
        if(strtoupper($key) == strtoupper($ext))
        {
            $valid = 1;
        }
    }
    if($valid)
    {
        foreach($extArray as $key)
        {
            if(file_exists("$path$name.$key"))
            {
                unlink("$path$name.$key");
            }
        }

            //echo 'The file name is '.$file;
        $ext = strtolower($ext);
        upload($path, "$name.$ext", $tempUpload);
    }else
    {
        echo 'That is not a valid file.';
    }
}

function file_check($name, $extArray, $path)
{
    foreach($extArray as $ext)
    {
        if(file_exists("$path$name.$ext"))
        {
            return $ext;
        }
    }

    return false;
}

function member_check($userName)
{
        $conf = parse_ini_file("config.ini", true);
        $sally = $conf['Groups'];
        foreach($sally as $value=>$key)
        {
                //echo $value . ' ';
                for($i = 1; $i < sizeof($sally[$value]);$i++)
                {
                //      echo $sally[$value][$i].' ';
                        if(strtolower($sally[$value][$i]) == strtolower($userName))
                        {
                                $_SESSION['team']=$value;
				$_SESSION['teamName']=$sally[$value][0];
				advisor_set($value,$conf);
				return true;
                        }
                }
                //echo '<br />;
        }
	return false;
}

function advisor_set($team, $conf)
{
	//$conf = parse_ini_file("config.ini",true);
	$sally = $conf['Advisees'];
	foreach($sally as $value=> $key)
	{
		foreach($key as $advisees)
		{
			if($advisees == $team)
			{
				$_SESSION['advisor']=$value;
				reqs_set($value, $conf);
			}
		}
	}
}

function reqs_set($faculty, $conf)
{
	$sally = $conf['Advisors'];
	$dept;
	foreach($sally as $value=>$key)
	{
		foreach($key as $advisor)
		{
			if($advisor == $faculty)
				$dept = $value;
		}
	}

	$sally = $conf['Requirements'];
	foreach($sally as $value=>$key)
	{
		if($value == $dept)
			$_SESSION['reqs']=$key;
	}
}

function ext_array($ext)
{
	$ext = trim($ext);
	$ext = str_replace('  ',' ',$ext);
	$ext = explode(' ', $ext);
	return $ext;
}

function advisor_check($username)
{
	$conf = parse_ini_file("config.ini",true);
	$sally = $conf['Advisees'];
	foreach($sally as $value=>$key)
	{
		if($value == $username)
		{
			$_SESSION['advisees'] = $key;
			advisor_teams($key, $conf);
			return true;
		}
	}
	return false;
}

function advisor_teams($advisees, $conf)
{
	$sally = $conf['Groups'];
	$adviseeNames = Array();
	foreach($advisees as $key)
	{
		foreach($sally as $valueG=>$keyG)
			if($key == $valueG)
				array_push($adviseeNames, $keyG[0]);
	}
	$_SESSION['adviseeNames']=$adviseeNames;
}

?>
