<?php 

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];


	$username_prefix = "";
	$number = "";
	$length_pass = "";
	$length_user = "";
	$expiration = "";
	$maxallsession = "";
	$sessiontimeout = "";

function createPassword($length) {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i <= ($length - 1)) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }

    return $pass;

}

	if (isset($_POST['submit'])) {
		$username_prefix = $_POST['username_prefix'];
		$number = $_POST['number'];
		$length_pass = $_POST['length_pass'];
		$length_user = $_POST['length_user'];
		$expiration = $_POST['expiration'];
		$maxallsession = $_POST['maxallsession'];
		$sessiontimeout = $_POST['sessiontimeout'];

		
		include 'library/opendb.php';

		for ($i=0; $i<$number; $i++) {
			$username = createPassword($length_user);
			$password = createPassword($length_pass);

			// append the prefix to the username
			$username  = $username_prefix . $username;

			echo "username: $username <br/>";
			echo "password: $password <br/>";

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADCHECK']." WHERE UserName='$username'";
		$res = mysql_query($sql) or die('Query failed: ' . mysql_error());

		if (mysql_num_rows($res) > 0) {
	                print "skipping matching entry: $username\n";
		} else {
		
			// insert username/password
			$sql = "insert into ".$configValues['CONFIG_DB_TBL_RADCHECK']." values (0, '$username', 'User-Password', '==', '$password')";
			$res = mysql_query($sql) or die('Query failed: ' . mysql_error());

			if ($expiration) { 
			// insert username/password
			$sql = "insert into ".$configValues['CONFIG_DB_TBL_RADCHECK']." values (0, '$username', 'Expiration', ':=', '$expiration')";
			$res = mysql_query($sql) or die('Query failed: ' . mysql_error());
			}
	
			if ($maxallsession) {
			// insert username/password
			$sql = "insert into ".$configValues['CONFIG_DB_TBL_RADCHECK']." values (0, '$username', 'Max-All-Session', ':=', '$maxallsession')";
			$res = mysql_query($sql) or die('Query failed: ' . mysql_error());
			}
	
			if ($sessiontimeout) {
			// insert username/password
			$sql = "insert into radreply values (0, '$username', 'Session-Timeout', ':=', '$sessiontimeout')";	$res = mysql_query($sql) or die('Query failed: ' . mysql_error());
			}

			echo "success<br/>";
		} 
		
		}

		include 'library/closedb.php';

	}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">
<!--[if lte IE 6.5]>
<link rel="stylesheet" type="text/css" href="library/js_date/select-free.css"/>
<![endif]-->

</head>


<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
 

<SCRIPT TYPE="text/javascript">
<!--

function sessiontimeout(time)
{
  document.batchuser.sessiontimeout.value = time;
}


function maxallsession(time)
{
  document.batchuser.maxallsession.value = time;
}

function toggleShowDiv(pass) {

        var divs = document.getElementsByTagName('div');
        for(i=0;i<divs.length;i++) {
                if (divs[i].id.match(pass)) {
                        if (document.getElementById) {                                                  
                                if (divs[i].style.display=="inline")
                                        divs[i].style.display="none";
                                else
                                        divs[i].style.display="inline";
                        } else if (document.layers) {                                                   
                                if (document.layers[divs[i]].display=='visible')
                                        document.layers[divs[i]].display = 'hidden';
                                else
                                        document.layers[divs[i]].display = 'visible';
                        } else {
                                if (document.all.hideShow.divs[i].visibility=='visible')                
                                        document.all.hideShow.divs[i].visibility = 'hidden';
                                else
                                        document.all.hideShow.divs[i].visibility = 'visible';
                        }
                }
        }
}

// -->
</script>

<?php

	include ("menu-mng-main.php");
	
?>

		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><?php echo $l[Intro][mngbatch.php] ?></h2>
				
				<p>
				<?php echo $l[captions][mngbatch] ?><br/>
				<br/><br/>
<?php
		if (trim($username_prefix) == "") { echo "error: missing username prefix<br/>";  }
		if (trim($number) == "") { echo "error: missing number of instances to create <br/>";  }
		if (trim($length_user) == "") { echo "error: missing username length<br/>";  }
		if (trim($length_pass) == "") { echo "error: missing password length<br/>";  }

		if (trim($expiration) == "") { echo "error: missing expiration <br/>";  }
		if (trim($maxallsession) == "") { echo "error: missing max-all-session <br/>";  }
		if (trim($sessiontimeout) == "") { echo "error: missing session <br/>";  }
?>
				</p>
				<form name="batchuser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<table border='2' class='table1'>
<tr><td>
						<b><?php echo $l[FormField][mngbatch.php][UsernamePrefix] ?></b>
</td><td>
						<input value="<?php echo $username_prefix ?>" name="username_prefix"/><br/>
</td></tr>
<tr><td>
						<b><?php echo $l[FormField][mngbatch.php][NumberInstances] ?></b>
</td><td>
						<input value="<?php echo $number ?>" name="number" /><br/>
</td></tr>
<tr><td>

						<b><?php echo $l[FormField][mngbatch.php][UsernameLength] ?></b>
</td><td>
	<SELECT name="length_user">
          <OPTION id="4"> 4 </OPTION>
          <OPTION id="5"> 5 </OPTION>
          <OPTION id="6"> 6 </OPTION>
          <OPTION id="8"> 8 </OPTION>
          <OPTION id="10"> 10 </OPTION>
          <OPTION id="12"> 12 </OPTION>
        </SELECT><br/>
</td></tr>
<tr><td>

						<b><?php echo $l[FormField][mngbatch.php][PasswordLength] ?></b>
</td><td>
	<SELECT name="length_pass">
          <OPTION id="4"> 4 </OPTION>
          <OPTION id="5"> 5 </OPTION>
          <OPTION id="6"> 6 </OPTION>
          <OPTION id="8"> 8 </OPTION>
          <OPTION id="10"> 10 </OPTION>
          <OPTION id="12"> 12 </OPTION>
        </SELECT><br/>
</td></tr>
</table>

<br/>
                                                <input type="checkbox" onclick="javascript:toggleShowDiv('attributesExpiration')">
						<b><?php echo $l[FormField][all][Expiration] ?></b>
<div id="attributesExpiration" style="display:none;visibility:visible" >
<input name="expiration" type="text" id="expiration" value="<?php echo $expiration ?>">
<img src="library/js_date/calendar.gif" onclick="showChooser(this, 'expiration', 'chooserSpan', 1950, 2010, 'd M Y', false);">
<div id="chooserSpan" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;"></div>
</div>
						<br/>





						<input type="checkbox" onclick="javascript:toggleShowDiv('attributesMaxAllSession')">
						<b><?php echo $l[FormField][all][MaxAllSession] ?></b><br/>
<div id="attributesMaxAllSession" style="display:none;visibility:visible" >
						<input value="<?php echo $maxallsession ?>" name="maxallsession" />

<a href="javascript:maxallsession(86400)">1day(s)</a>
<a href="javascript:maxallsession(259200)">3day(s)</a>
<a href="javascript:maxallsession(604800)">1week(s)</a>
<a href="javascript:maxallsession(1209600)">2week(s)</a>
<a href="javascript:maxallsession(1814400)">3week(s)</a>
<a href="javascript:maxallsession(2592000)">1month(s)</a>
<a href="javascript:maxallsession(5184000)">2month(s)</a>
<a href="javascript:maxallsession(7776000)">3month(s)</a>
						<br/>
</div>


                                                <input type="checkbox" onclick="javascript:toggleShowDiv('attributesSessionTimeout')">
						<b><?php echo $l[FormField][all][SessionTimeout] ?></b><br/>
<div id="attributesSessionTimeout" style="display:none;visibility:visible" >
						<input value="<?php echo $sessiontimeout ?>" name="sessiontimeout" />
<a href="javascript:sessiontimeout(86400)">1day(s)</a>
<a href="javascript:sessiontimeout(259200)">3day(s)</a>
<a href="javascript:sessiontimeout(604800)">1week(s)</a>
<a href="javascript:sessiontimeout(1209600)">2week(s)</a>
<a href="javascript:sessiontimeout(1814400)">3week(s)</a>
<a href="javascript:sessiontimeout(2592000)">1month(s)</a>
<a href="javascript:sessiontimeout(5184000)">2month(s)</a>
<a href="javascript:sessiontimeout(7776000)">3month(s)</a>
						<br/>
</div>

						<br/><br/>
						<input type="submit" name="submit" value="<?php echo $l[buttons][apply] ?>"/>

				</form>
		
		</div>
		
		<div id="footer">
		
								<?php
        include 'page-footer.php';
?>

		
		</div>
		
</div>
</div>


</body>
</html>





