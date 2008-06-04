<?php
/*
 *********************************************************************************************************
 * daloRADIUS - RADIUS Web Platform
 * Copyright (C) 2007 - Liran Tal <liran@enginx.com> All Rights Reserved.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 *********************************************************************************************************
 *
 * Authors:	Liran Tal <liran@enginx.com>
 *
 *********************************************************************************************************
 */
 
	include ("library/checklogin.php");
	$operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	// declaring variables
	$logAction = "";
	$logDebugSQL = "";

	isset($_POST['username']) ? $username = $_POST['username'] : $username = "";
	isset($_POST['password']) ? $password = $_POST['password'] : $password = "";
	isset($_POST['group']) ? $group = $_POST['group'] : $group = "";
	isset($_POST['authType']) ? $authType = $_POST['authType'] : $authType = "";

	isset($_POST['username']) ? $username = $_POST['username'] : $username = "";
	isset($_POST['password']) ? $password = $_POST['password'] : $password = "";
	isset($_POST['passwordType']) ? $passwordtype = $_POST['passwordType'] : $passwordtype = "";

	isset($_POST['macaddress']) ? $macaddress = $_POST['macaddress'] : $macaddress = "";
	isset($_POST['pincode']) ? $pincode = $_POST['pincode'] : $pincode = "";

	isset($_POST['group_macaddress']) ? $group_macaddress = $_POST['group_macaddress'] : $group_macaddress = "";
	isset($_POST['group_pincode']) ? $group_pincode = $_POST['group_pincode'] : $group_pincode = "";

	isset($_POST['firstname']) ? $firstname = $_POST['firstname'] : $firstname = "";
	isset($_POST['lastname']) ? $lastname = $_POST['lastname'] : $lastname = "";
	isset($_POST['email']) ? $email = $_POST['email'] : $email = "";
	isset($_POST['department']) ? $department = $_POST['department'] : $department = "";
	isset($_POST['company']) ? $company = $_POST['company'] : $company = "";
	isset($_POST['workphone']) ? $workphone = $_POST['workphone'] : $workphone = "";
	isset($_POST['homephone']) ? $homephone = $_POST['homephone'] :  $homephone = "";
	isset($_POST['mobilephone']) ? $mobilephone = $_POST['mobilephone'] : $mobilephone = "";
	isset($_POST['notes']) ? $notes = $_POST['notes'] : $notes = "";

	isset($_POST['dictAttributes']) ? $dictAttributes = $_POST['dictAttributes'] : $dictAttributes = "";		


	function addGroups($dbSocket, $username, $group) {

		global $logDebugSQL;
		global $configValues;

		// insert usergroup mapping
		if (isset($group) && (trim($group) != "")) {
			$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADUSERGROUP']." (UserName,GroupName,priority) ".
				" VALUES ('".$dbSocket->escapeSimple($username)."', '".$dbSocket->escapeSimple($group)."',0) ";
			$res = $dbSocket->query($sql);
			$logDebugSQL .= $sql . "\n";
		}
	}


	function addUserInfo($dbSocket, $username) {

		global $firstname;
		global $lastname;
		global $email;
		global $department;
		global $company;
		global $workphone;
		global $homephone;
		global $mobilephone;
		global $notes;
		global $logDebugSQL;
		global $configValues;

		$currDate = date('Y-m-d H:i:s');
		$currBy = $_SESSION['operator_user'];

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].
				" WHERE username='".$dbSocket->escapeSimple($username)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		// if there were no records for this user present in the userinfo table
		if ($res->numRows() == 0) {
			// insert user information table
			$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_DALOUSERINFO'].
				" (id, username, firstname, lastname, email, department, company, workphone, homephone, ".
				" mobilephone, notes, creationdate, creationby, updatedate, updateby) ".
				" VALUES (0, 
				'".$dbSocket->escapeSimple($username)."', '".$dbSocket->escapeSimple($firstname)."', '".
				$dbSocket->escapeSimple($lastname)."', '".$dbSocket->escapeSimple($email)."', '".
				$dbSocket->escapeSimple($department)."', '".$dbSocket->escapeSimple($company)."', '".
				$dbSocket->escapeSimple($workphone)."', '".$dbSocket->escapeSimple($homephone)."', '".
				$dbSocket->escapeSimple($mobilephone)."', '".$dbSocket->escapeSimple($notes).
				"', '$currDate', '$currBy', NULL, NULL)";
			$res = $dbSocket->query($sql);
			$logDebugSQL .= $sql . "\n";
		} //FIXME:
		  //if the user already exist in userinfo then we should somehow alert the user
		  //that this has happened and the administrator/operator will take care of it

	}


	function addAttributes($dbSocket, $username) {
		
		global $logDebugSQL;
		global $configValues;

		foreach($_POST as $element=>$field) { 

			// switch case to rise the flag for several $attribute which we do not
			// wish to process (ie: do any sql related stuff in the db)
			switch ($element) {

				case "authType":
				case "username":
				case "password":
				case "passwordType":
				case "group":
				case "group_macaddress":
				case "group_pincode":
				case "macaddress":
				case "pincode":
				case "submit":
				case "firstname":
				case "lastname":
				case "email":
				case "department":
				case "company":
				case "workphone":
				case "homephone":
				case "mobilephone":
				case "notes":
					$skipLoopFlag = 1;	// if any of the cases above has been met we set a flag
								// to skip the loop (continue) without entering it as
								// we do not want to process this $attribute in the following
								// code block
					break;
			}
	
			if ($skipLoopFlag == 1) {
				$skipLoopFlag = 0;              // resetting the loop flag
				continue;
			}

			if (isset($field[0]))
				$attribute = $field[0];
			if (isset($field[1]))
				$value = $field[1];
			if (isset($field[2]))
				$op = $field[2];
			if (isset($field[3]))
				$table = $field[3];

			if ( isset($table) && ($table == 'check') )
				$table = $configValues['CONFIG_DB_TBL_RADCHECK'];
			if ( isset($table) && ($table == 'reply') )
				$table = $configValues['CONFIG_DB_TBL_RADREPLY'];

			if ( (isset($field)) && (!isset($field[1])) )
				continue;
	
			$sql = "INSERT INTO $table (id,Username,Attribute,op,Value) ".
					" VALUES (0, '".$dbSocket->escapeSimple($username)."', '".
					$dbSocket->escapeSimple($attribute)."', '".$dbSocket->escapeSimple($op)."', '".
					$dbSocket->escapeSimple($value)."')  ";
			$res = $dbSocket->query($sql);
			$logDebugSQL .= $sql . "\n";

		} // foreach

	}


	if (isset($_POST['submit'])) {

		include 'library/opendb.php';

		global $username;
		global $authType;
		global $password;
		global $passwordtype;

		switch($authType) {
			case "userAuth":
				break;
			case "macAuth":
				$username = $macaddress;
				break;
			case "pincodeAuth":
				$username = $pincode;
				break;
		}

		$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_RADCHECK']." WHERE UserName='".
				$dbSocket->escapeSimple($username)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 0) {

		    if ($authType == "userAuth") {

				if (trim($username) != "" and trim($password) != "") {

					// we need to perform the secure method escapeSimple on $dbPassword early because as seen below
					// we manipulate the string and manually add to it the '' which screw up the query if added in $sql
					$password = $dbSocket->escapeSimple($password);

					switch($configValues['CONFIG_DB_PASSWORD_ENCRYPTION']) {
						case "cleartext":
							$dbPassword = "'$password'";
							break;
						case "crypt":
							$dbPassword = "ENCRYPT('$password')";
							break;
						case "md5":
							$dbPassword = "MD5('$password')";
							break;
						default:
							$dbPassword = "'$password'";
					}
					
					// at this stage $dbPassword contains the password string encapsulated by '' and either uses
					// a function to encrypt it like ENCRYPT or it doesn't, it's based on the configuration
					// but here we provide another stage, for Crypt-Password and MD5-Password it's obvious
					// that the password need be encrypted so even if this option is not in the configuration
					// we enforce it.

					// we first check if the password attribute is to be encrypted at all
					if (preg_match("/crypt/i", $passwordtype)) {
						// if we don't find the encrypt function even though we identified
						// a Crypt-Password attribute
						if (!(preg_match("/encrypt/i",$dbPassword))) {
							$dbPassword = "ENCRYPT('$password')";
						}
				
						// we now perform the same check but for an MD5-Password attribute
					} elseif (preg_match("/md5/i", $passwordtype)) {
						// if we don't find the md5 function even though we identified
						// a MD5-Password attribute
						if (!(preg_match("/md5/i",$dbPassword))) {
							$dbPassword = "MD5('$password')";
						}
					}

					// insert username/password
					$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADCHECK']." (id,Username,Attribute,op,Value) ".
							" VALUES (0, '".$dbSocket->escapeSimple($username)."', '".$dbSocket->escapeSimple($passwordtype).
							"', ':=', $dbPassword)";
					$res = $dbSocket->query($sql);
					$logDebugSQL .= $sql . "\n";
					
					addGroups($dbSocket, $username, $group);
					addUserInfo($dbSocket, $username);
					addAttributes($dbSocket, $username);

					$successMsg = "Added to database new user: <b> $username </b>";
					$logAction .= "Successfully added new user [$username] on page: ";

				} else {

					$failureMsg = "username or password are empty";
					$logAction .= "Failed adding (possible empty user/pass) new user [$username] on page: ";
				}

		   } elseif ($authType == "macAuth") {

				// insert username/password
				$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADCHECK']." (id,Username,Attribute,op,Value) ".
						" VALUES (0, '".$dbSocket->escapeSimple($macaddress)."', 'Auth-Type', ':=', 'Accept')";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
				
				addGroups($dbSocket, $macaddress, $group_macaddress);
				addUserInfo($dbSocket, $macaddress);
				addAttributes($dbSocket, $macaddress);

				$successMsg = "Added to database new mac auth user: <b> $macaddress </b>";
				$logAction .= "Successfully added new mac auth user [$macaddress] on page: ";

		   } elseif ($authType == "pincodeAuth") {

				// insert username/password
				$sql = "INSERT INTO ".$configValues['CONFIG_DB_TBL_RADCHECK']." (id,Username,Attribute,op,Value) ".
						" VALUES (0, '".$dbSocket->escapeSimple($pincode)."', 'Auth-Type', ':=', 'Accept')";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";

				addGroups($dbSocket, $pincode, $group_macaddress);
				addUserInfo($dbSocket, $pincode);
				addAttributes($dbSocket, $pincode);

				$successMsg = "Added to database new pincode: <b> $pincode </b>";
				$logAction .= "Successfully added new pincode [$pincode] on page: ";

		   } else {
				echo "unknown authentication method <br/>";
		   }

		} else { 
			$failureMsg = "user already exist in database: <b> $username </b>";
			$logAction .= "Failed adding new user already existing in database [$username] on page: ";
		}
		
		include 'library/closedb.php';

	}




	include_once('library/config_read.php');
	$log = "visited page: ";

	if ($configValues['CONFIG_IFACE_PASSWORD_HIDDEN'] == "yes")
		$hiddenPassword = "type=\"password\"";
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />
<link rel="stylesheet" href="css/auto-complete.css" media="screen" type="text/css">
<link rel="stylesheet" type="text/css" href="library/js_date/datechooser.css">
<!--[if lte IE 6.5]>
<link rel="stylesheet" type="text/css" href="library/js_date/select-free.css"/>
<![endif]-->
</head>
 
<script src="library/js_date/date-functions.js" type="text/javascript"></script>
<script src="library/js_date/datechooser.js" type="text/javascript"></script>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<script src="library/javascript/productive_funcs.js" type="text/javascript"></script>

<script type="text/javascript" src="library/javascript/ajax.js"></script>
<script type="text/javascript" src="library/javascript/dynamic_attributes.js"></script>
 
<?php
	include_once ("library/tabber/tab-layout.php");
?>

<?php
	include ("menu-mng-users.php");
?>
	<div id="contentnorightbar">

		<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo $l['Intro']['mngnew.php'] ?>
		<h144>+</h144></a></h2>
		
		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo $l['helpPage']['mngnew'] ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>
		
		<form name="newuser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="tabber">

     <div class="tabbertab" title="<?php echo $l['title']['AccountInfo']; ?>">

	<fieldset>

		<h302> <?php echo $l['title']['AccountInfo']; ?> </h302>

		<input checked type='radio' value="userAuth" name="authType" onclick="javascript:toggleUserAuth()"/>
		<b> Username Authentication </b>
		<br/>

		<ul>

		<div id='UserContainer'>
		<li class='fieldset'>
		<label for='username' class='form'><?php echo $l['all']['Username']?></label>
		<input name='username' type='text' id='username' value='' tabindex=100 />
		<input type='button' value='Random' class='button' onclick="javascript:randomAlphanumeric('username',8)" />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('usernameTooltip')" /> 

		<div id='usernameTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo $l['Tooltip']['usernameTooltip'] ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='password' class='form'><?php echo $l['all']['Password']?></label>
		<input name='password' type='text' id='password' value='' 
			<?php if (isset($hiddenPassword)) echo $hiddenPassword ?> tabindex=101 />
		<input type='button' value='Random' class='button' onclick="javascript:randomAlphanumeric('password',8)" />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('passwordTooltip')" />

		<div id='passwordTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' /> 
			<?php echo $l['Tooltip']['passwordTooltip'] ?>
		</div>
		</li>
		</div>


		<li class='fieldset'>
		<label for='passwordType' class='form'><?php echo $l['all']['PasswordType']?> </label>
		<select class='form' tabindex=102 name='passwordType' >
			<option value='User-Password'>User-Password</option>
			<option value='Cleartext-Password'>Cleartext-Password</option>
			<option value='Crypt-Password'>Crypt-Password</option>
			<option value='MD5-Password'>MD5-Password</option>
			<option value='SHA1-Password'>SHA1-Password</option>
			<option value='CHAP-Password'>CHAP-Password</option>
		</select>
		</li>

		<li class='fieldset'>
		<label for='group' class='form'><?php echo $l['all']['Group']?></label>
		<?php   
			include_once 'include/management/populate_selectbox.php';
			populate_groups("Select Groups","group");
		?>
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('group')" />

		<div id='groupTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' /> 
			<?php echo $l['Tooltip']['groupTooltip'] ?>
		</div>
		</li>

		<li class='fieldset'>
		<br/>
		<hr><br/>
		<input type='submit' name='submit' value='<?php echo $l['buttons']['apply'] ?>' class='button' />
		</li>

		</ul>

	</fieldset>

	<br/>

	<fieldset>

		<h302> <?php echo $l['title']['AccountInfo']; ?> </h302>


		<input type='radio' name="authType" value="macAuth"  onclick="javascript:toggleMacAuth()"/>
		<b> MAC Address Authentication </b>
		<br/>

		<ul>

		<li class='fieldset'>
		<label for='macaddress' class='form'><?php echo $l['all']['MACAddress']?></label>
		<input name='macaddress' type='text' id='macaddress' value='' tabindex=105 disabled />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('macaddressTooltip')"  />

		<div id='macaddressTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo $l['Tooltip']['macaddressTooltip'] ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='group' class='form'><?php echo $l['all']['Group']?></label>
		<?php   
			include_once 'include/management/populate_selectbox.php';
			populate_groups("Select Groups", "group_macaddress", "form", "disabled");
		?>
		</li>

		<li class='fieldset'>
		<br/>
		<hr><br/>
		<input type='submit' name='submit' value='<?php echo $l['buttons']['apply'] ?>' class='button' />
		</li>

		</ul>

	</fieldset>


	<br/>

	<fieldset>

		<h302> <?php echo $l['title']['AccountInfo']; ?> </h302>

		<input type='radio' name="authType" value="pincodeAuth" onclick="javascript:togglePinCode()"/>
		<b> PIN Code Authentication </b>
		<br/>

		<ul>

		<li class='fieldset'>
		<label for='pincode' class='form'><?php echo $l['all']['PINCode']?></label>
		<input name='pincode' type='text' id='pincode' value='' tabindex=106 disabled />
		<input type='button' value='Generate' class='button' onclick="javascript:randomAlphanumeric('pincode',10)" />
		<img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('pincodeTooltip')" />		
		
		<div id='pincodeTooltip'  style='display:none;visibility:visible' class='ToolTip'>
			<img src='images/icons/comment.png' alt='Tip' border='0' />
			<?php echo $l['Tooltip']['pincodeTooltip'] ?>
		</div>
		</li>

		<li class='fieldset'>
		<label for='group' class='form'><?php echo $l['all']['Group']?></label>
		<?php   
			include_once 'include/management/populate_selectbox.php';
			populate_groups("Select Groups", "group_pincode", "form", "disabled");
		?>
		</li>


		<li class='fieldset'>
		<br/>
		<hr><br/>
		<input type='submit' name='submit' value='<?php echo $l['buttons']['apply'] ?>' class='button' />
		</li>

		</ul>

	</fieldset>

	</div>



	<div class="tabbertab" title="<?php echo $l['title']['UserInfo']; ?>">
	<?php
		include_once('include/management/userinfo.php');
	?>
	</div>

	<div class="tabbertab" title="<?php echo $l['title']['Attributes']; ?>">
	<?php
		include_once('include/management/attributes.php');
	?>
	</div>	
	

</div>


	</form>


<?php
	include('include/config/logging.php');
?>

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

