<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');



	include_once('library/config_read.php');
    $log = "visited page: ";
    $logQuery = "performed query on page: ";
    include('include/config/logging.php');

?>

<?php

    include ("menu-reports-logs.php");
  	
?>	
		<div id="contentnorightbar">
		
		<h2 id="Intro"><a href="#"><? echo $l['Intro']['indexsystemlog.php']; ?></a></h2>
				<p>

<?php
	include 'library/exten-boot_log.php';
?>
				</p>
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
