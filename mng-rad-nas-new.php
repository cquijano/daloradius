<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];
        
	include('library/check_operator_perm.php');



	// declaring variables
	$nashost = "";
	$nassecret = "";
	$nasname = "";
	$nasports = "";
	$nastype = "";
	$nasdescription = "";
	$nascommunity = "";

	$logDebugSQL = "";

	if (isset($_POST['submit'])) {
	
		$nashost = $_POST['nashost'];
		$nassecret = $_POST['nassecret'];
		$nasname = $_POST['nasname'];
		$nasports = $_POST['nasports'];
		$nastype = $_POST['nastype'];
		$nasdescription = $_POST['nasdescription'];
		$nascommunity = $_POST['nascommunity'];

		
		include 'library/opendb.php';

		$sql = "SELECT * FROM nas WHERE nasname='".$dbSocket->escapeSimple($nashost)."'";
		$res = $dbSocket->query($sql);
		$logDebugSQL .= $sql . "\n";

		if ($res->numRows() == 0) {

			if (trim($nashost) != "" and trim($nassecret) != "") {

				if (!$nasports) {
					$nasports = 0;
				}
				
				// insert nas details
				$sql = "INSERT INTO nas values (0, '".$dbSocket->escapeSimple($nashost)."', '".$dbSocket->escapeSimple($nasname)."',
'".$dbSocket->escapeSimple($nastype)."', ".$dbSocket->escapeSimple($nasports).", '".$dbSocket->escapeSimple($nassecret)."',
'".$dbSocket->escapeSimple($nascommunity)."', '".$dbSocket->escapeSimple($nasdescription)."')";
				$res = $dbSocket->query($sql);
				$logDebugSQL .= $sql . "\n";
			
				$actionStatus = "success";
				$actionMsg = "Added new NAS to database: <b> $nashost </b>  ";
				$logAction = "Successfully added nas [$nashost] on page: ";
			} else {
				$actionStatus = "failure";
				$actionMsg = "no NAS Host or NAS Secret was entered, it is required that you specify both NAS Host and NAS Secret";
				$logAction = "Failed adding (missing nas/secret) nas [$nashost] on page: ";
			}
		} else {
			$actionStatus = "failure";
			$actionMsg = "The NAS IP/Host $nashost already exists in the database";	
			$logAction = "Failed adding already existing nas [$nashost] on page: ";
		}

		include 'library/closedb.php';
	}
	

	include_once('library/config_read.php');
    $log = "visited page: ";

	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>

<script src="library/javascript/pages_common.js" type="text/javascript"></script>

<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

</head>


<?php
        include_once ("library/tabber/tab-layout.php");
?> 
 
<?php
	include ("menu-mng-rad-nas.php");
?>
		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#" onclick="javascript:toggleShowDiv('helpPage')"><?php echo $l['Intro']['mngradnasnew.php'] ?>
				<h144>+</h144></a></h2>

				<div id="helpPage" style="display:none;visibility:visible" >				
					<?php echo $l['helpPage']['mngradnasnew'] ?>
					<br/>
				</div>
				<br/>
				
                                <form name="newnas" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div class="tabber">

     <div class="tabbertab" title="<?php echo $l['title']['NASInfo']; ?>">

	<fieldset>

		<h302> <?php echo $l['title']['NASInfo'] ?> </h302>
		<br/>

                <label for='nashost' class='form'><?php echo $l['FormField']['mngradnasnew.php']['NasIPHost'] ?></label>
                <input name='nashost' type='text' id='nashost' value='' tabindex=100 />
                <br />


                <label for='nassecret' class='form'><?php echo $l['FormField']['mngradnasnew.php']['NasSecret'] ?></label>
                <input name='nassecret' type='text' id='nassecret' value='' tabindex=101 />
                <br />


                <label for='nastype' class='form'><?php echo $l['FormField']['mngradnasnew.php']['NasType'] ?></label>
                <input name='nastype' type='text' id='nastype' value='' tabindex=102 />
                <select onChange="javascript:setStringText(this.id,'nastype')" id="optionSele" tabindex=103 class='form'>
	                <option value="other">other</option>
	                <option value="cisco">cisco</option>
	                <option value="livingston">livingston</option>
        	        <option value="computon">computon</option>
		        <option value="max40xx">max40xx</option>
		        <option value="multitech">multitech</option>
		        <option value="natserver">natserver</option>
		        <option value="pathras">pathras</option>
		        <option value="patton">patton</option>
	                <option value="portslave">portslave</option>
	                <option value="tc">tc</option>
	                <option value="usrhiper">usrhiper</option>
       	        </select>
                <br />
		

                <label for='nasname' class='form'><?php echo $l['FormField']['mngradnasnew.php']['NasShortname'] ?></label>
                <input name='nasname' type='text' id='nasname' value='' tabindex=104 />
                <br />

                <br/><br/>
                <hr><br/>

                <input type='submit' name='submit' value='<?php echo $l['buttons']['apply'] ?>' class='button' />

        </fieldset>


     </div>
     <div class="tabbertab" title="<?php echo $l['title']['NASAdvanced']; ?>">

	<fieldset>

		<h302> <?php echo $l['title']['NASAdvanced'] ?> </h302>
		<br/>

                <label for='nasports' class='form'><?php echo $l['FormField']['mngradnasnew.php']['NasPorts'] ?></label>
                <input name='nasports' type='text' id='nasports' value='' tabindex=105 />
                <br />

                <label for='nascommunity' class='form'><?php echo $l['FormField']['mngradnasnew.php']['NasCommunity'] ?></label>
                <input name='nascommunity' type='text' id='nascommunity' value='' tabindex=106 />
                <br />

                <label for='nasdescription' class='form'><?php echo $l['FormField']['mngradnasnew.php']['NasDescription'] ?></label>
                <input name='nasdescription' type='text' id='nasdescription' value='' tabindex=107 />
                <br />

                <br/><br/>
                <hr><br/>

                <input type='submit' name='submit' value='<?php echo $l['buttons']['apply'] ?>' class='button' />

        </fieldset>

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
