<?php 

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');



	include 'library/opendb.php';
		// required for checking if an attribute belongs to the
		// radcheck table or the radreply based upon it's name	
	include 'include/management/attributes.php';				

	if (isset($_REQUEST['submit'])) {

		$username = $_REQUEST['username'];
		$password = "";						// we initialize the $password variable to contain nothing
		if (trim($username) != "") {

			 foreach( $_POST as $attribute=>$value ) { 

				if ( ($attribute == "username") || ($attribute == "submit") )	// we skip these post variables as they are not important
					continue;	
					
					$useTable = checkTables($attribute);			// checking if the attribute's name belong to the radreply
												// or radcheck table (using include/management/attributes.php function)

			        $counter = 0;

					// we set the $password variable to the attribute value only if that attribute is actually a password attribute indeed 
					// and this has to be done because we're looping on all attributes that were submitted with the form
					switch($attribute) {
						case "User-Password":
							$password = "'$value'";
							break;
						case "CHAP-Password":
							$password = "'$value'";
							break;
						case "Cleartext-Password":
							$password = "'$value'";
							break;							
						case "Crypt-Password":
							$password = "'$value'";
							break;	
						case "MD5-Password":
							$password = "'$value'";
							break;
						case "SHA1-Password":
							$password = "'$value'";
							break;
						default:
							$value = "'$value'";
					}
					
					// first we check that the config option is actually set and available in the config file
					if (isset($configValues['CONFIG_DB_PASSWORD_ENCRYPTION'])) {
						// if so we need to use different function for each encryption type and so we force it here
						switch($configValues['CONFIG_DB_PASSWORD_ENCRYPTION']) {
							case "cleartext":
								if ($password != "")
										$value = "$password";
								break;
							case "crypt":
								if ($password != "")
										$value = "ENCRYPT($password)";
								break;
							case "md5":
								if ($password != "")
										$value = "MD5($password)";
								break;
						}
					} else {
						// if the config option was not set and we encountered a password attribute we set it to default which is cleartext
						if ($password != "")
							$value = "$password";
					}

					$sql = "UPDATE $useTable SET Value=$value WHERE UserName='$username' AND Attribute='$attribute'";
					$res = $dbSocket->query($sql);

					$counter++;
					$password = "";		// we MUST reset the $password variable to nothing  so that it's not kepy in the loop and will repeat itself as the value to set

	        } //foreach $_POST

			$actionStatus = "success";
			$actionMsg = "Updated attributes for: <b> $username </b>";
			$logAction = "Successfully updates attributes for user [$username] on page: ";
			
		} else { // if username != ""
			$actionStatus = "failure";
			$actionMsg = "no user was entered, please specify a username to edit";		
			$logAction = "Failed updating attributes for user [$username] on page: ";
		}
	} // if isset post submit


	if (isset($_REQUEST['username']))
		$username = $_REQUEST['username'];
	else
		$username = "";

	if (trim($username) != "") {
		$username = $_REQUEST['username'];
	} else {
		$actionStatus = "failure";
		$actionMsg = "no user was entered, please specify a username to edit";
	}

	
	/* an sql query to retrieve the password for the username to use in the quick link for the user test connectivity
	*/
	$sql = "SELECT Value FROM ".$configValues['CONFIG_DB_TBL_RADCHECK']." WHERE UserName='$username' AND Attribute like '%Password'";
	$res = $dbSocket->query($sql);
	$row = $res->numRows();
	$user_password = $row[0];

	/* fill-in all the user radcheck attributes */

	$sql = "SELECT Attribute, op, Value FROM ".$configValues['CONFIG_DB_TBL_RADCHECK']." WHERE UserName='$username'";
	$res = $dbSocket->query($sql);

	$arrAttr = array();
	$arrOp = array();
	$arrValue = array();

        while($row = $res->fetchRow()) {
		array_push($arrAttr, $row[0]);
		array_push($arrOp, $row[1]);
		array_push($arrValue, $row[2]);
	}	
		


	/* fill-in all the user radreply attributes */

	$sql = "SELECT Attribute, op, Value FROM ".$configValues['CONFIG_DB_TBL_RADREPLY']." WHERE UserName='$username'";
	$res = $dbSocket->query($sql);

	$arrAttrReply = array();
	$arrOpReply = array();
	$arrValueReply = array();

        while($row = $res->fetchRow()) {
		array_push($arrAttrReply, $row[0]);
		array_push($arrOpReply, $row[1]);
		array_push($arrValueReply, $row[2]);
	}	


	include 'library/closedb.php';



	include_once('library/config_read.php');
    $log = "visited page: ";
    include('include/config/logging.php');


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

</head>
 
<?php

	include ("menu-mng-main.php");
	
?>
		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><?php echo $l[Intro][mngedit.php] ?></h2>
				
				<p>
				<?php echo $l[captions][mngedit] ?>
				</p>

<br/>
<table border='2' class='table1'>
<thead>
                <tr>
                <th class='info' colspan='10'>Tool-Box</th>
                </tr>
</thead>
<tr><td>
</td><td>
</td><td>
</td><td>
        <a class='novisit' href="config-maint-test-user.php?username=<?php echo $username ?>&password=<?php echo $user_password ?>"> Test Connectivity </a>
</td><td>
        <a class='novisit' href="acct-username.php?username=<?php echo $username ?>"> Accounting </a>
</td><td>
        <a class='novisit' href="graphs-overall_logins.php?type=monthly&username=<?php echo $username ?>"> Graphs - Logins </a>
</td><td>
        <a class='novisit' href="graphs-overall_download.php?type=monthly&username=<?php echo $username ?>"> Graphs - Downloads </a>
</td><td>
        <a class='novisit' href="graphs-overall_upload.php?type=monthly&username=<?php echo $username ?>"> Graphs - Uploads </a>
</td></tr>
</table>
<br/>


				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

				<input type="hidden" value="<?php echo $username ?>" name="username" />

<?php


		echo "<table border='2' class='table1'>";
	        echo "
                        <thead>
                                <tr>
                                <th colspan='10'>radcheck</th>
                                </tr>
                        </thead>
                ";

                $counter = 0;
                foreach ($arrAttr as $attribute) {

			echo "<tr><td>";
			echo "<b>$arrAttr[$counter]</b";
			echo "</td><td>";

			if ( ($configValues['CONFIG_IFACE_PASSWORD_HIDDEN'] == "yes") and (preg_match("/.*-Password/", $arrAttr[$counter])) )
				echo "<input type='password' value='$arrValue[$counter]' name='$arrAttr[$counter]' /><br/>";
			else
				echo "<input value='$arrValue[$counter]' name='$arrAttr[$counter]' /><br/>";

			echo "</td></tr>";
			$counter++;

		}

		echo "</table>";

		echo "<br/><br/>";

		echo "<table border='2' class='table1'>";
	        echo "
                        <thead>
                                <tr>
                                <th colspan='10'>radreply </th>
                                </tr>
                        </thead>
                ";

                $counter = 0;
                foreach ($arrAttrReply as $attribute) {

                        echo "<tr><td>";
			echo "<b>$arrAttrReply[$counter]</b";
                        echo "</td><td>";
			echo "<input value='$arrValueReply[$counter]' name='$arrAttrReply[$counter]' /><br/>";
                        echo "</td></tr>";
			$counter++;

		}

		echo "</table>";


?>

						<br/><br/>
<center>
						<input type="submit" name="submit" value="<?php echo $l[buttons][apply] ?>"/>
</center>

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
