<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];


	$type = "";
	if (isset($_POST['submit'])) {
		// $type = $_POST['type'];
	        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';


		if (trim($type) != "") {
			include 'library/config.php';
			include 'library/opendb.php';

			// delete all attributes associated with a username
			$sql = "DELETE FROM rates WHERE type='$type'";
			$res = mysql_query($sql) or die('Query failed: ' . mysql_error());

			echo "success<br/>";
			include 'library/closedb.php';

		}


	}


?>

<?php

    include ("menu-billing.php");

?>		
		
		<div id="contentnorightbar">
		
				<h2 id="Intro">Delete Rate entry</h2>
				
				<p>
				Provide the rate entry type which you would like to remove
				<br/><br/>
<?php
		if (trim($type) == "") { echo "error: missing rate type to delete <br/>";  }

?>
				</p>
				<form action="bill-rates-del.php" method="post">

						<b>Type</b>
						<input value="<?php echo $type ?>" name="type"/><br/>

						<br/><br/>
						<input type="submit" name="submit" value="Apply"/>

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
