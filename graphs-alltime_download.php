<?php

    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

        $username = $_POST['username'];
        $type = $_POST['type'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />

</head>
 
<body>

<div id="wrapper">
<div id="innerwrapper">

		<div id="header">
		
				<form action="">
				<input value="Search" />
				</form>
				
				<h1><a href="index.php">daloRADIUS</a></h1>
				
				<h2>
				
						Radius Reporting, Billing and Management by <a href="http://www.enginx.com">Enginx</a>
				
				</h2>
				
				<ul id="nav">
				
						<li><a href="index.php"><em>H</em>ome</a></li>
						
						<li><a href="mng-main.php"><em>M</em>anagment</a></li>
						
						<li><a href="rep-main.php"><em>R</em>eports</a></li>
						
						<li><a href="acct-main.php"><em>A</em>ccounting</a></li>

						<li><a href="bill-main.php"><em>B</em>illing</a></li>
						<li><a href="gis-main.php"><em>GIS</em></a></li>
						<li><a href="graph-main.php" class="active"><em>G</em>raphs</a></li>

						<li><a href="help-main.php"><em>H</em>elp</a></li>
				
				</ul>
				<ul id="subnav">
				
						<li>Welcome, <?php echo $operator; ?></li>

						<li><a href="logout.php">[logout]</a></li>
				
				</ul>
		
		</div>
		
		<div id="sidebar">
		
				<h2>Graphs</h2>
				
				<h3>Users plotting</h3>
				<ul class="subnav">

						<li><a href="javascript:document.overall_logins.submit();"><b>&raquo;</b>Overall Logins/Hits</a>
							<form name="overall_logins" action="graphs-overall_logins.php" method="post" class="sidebar">
							<input name="username" type="text" value="username">
							<select name="type" type="text">
								<option value="daily"> Daily
								<option value="monthly"> Monthly
								<option value="yearly"> Yearly
							</select>
							</form></li>






                                                <li><a href="javascript:document.overall_download.submit();"><b>&raquo;</b>Overall Download Stat</a>
                                                        <form name="overall_download" action="graphs-overall_download.php" method="post" class="sidebar">
                                                        <input name="username" type="text" value="username">
                                                        <select name="type" type="text">
                                                                <option value="daily"> Daily
                                                                <option value="monthly"> Monthly
                                                                <option value="yearly"> Yearly
                                                        </select>
                                                        </form></li>



                                                <li><a href="javascript:document.overall_upload.submit();"><b>&raquo;</b>Overall Upload Stat</a>
                                                        <form name="overall_upload" action="graphs-overall_upload.php" method="post" class="sidebar">
                                                        <input name="username" type="text" value="username">
                                                        <select name="type" type="text">
                                                                <option value="daily"> Daily
                                                                <option value="monthly"> Monthly
                                                                <option value="yearly"> Yearly
                                                        </select>
                                                        </form></li>

				<h3>All-time Statistics</h3>
				<ul class="subnav">


                                                <li><a href="javascript:document.alltime_logins.submit();"><b>&raquo;</b>Alltime Logins/Hits Stat</a>
                                                        <form name="alltime_logins" action="graphs-alltime_logins.php" method="post" class="sidebar">
                                                        <select name="type" type="text">
                                                                <option value="daily"> Daily
                                                                <option value="monthly"> Monthly
                                                                <option value="yearly"> Yearly
                                                        </select>
                                                        </form></li>



                                                <li><a href="javascript:document.alltime_traffic_compare.submit();"><b>&raquo;</b>Alltime Traffic comparison</a>
                                                        <form name="alltime_traffic_compare" action="graphs-alltime_traffic_compare.php" method="post" class="sidebar">
                                                        <select name="type" type="text">
                                                                <option value="daily"> Daily
                                                                <option value="monthly"> Monthly
                                                                <option value="yearly"> Yearly
                                                        </select>
                                                        </form></li>





				</ul>


				<br/><br/>
				<h2>Search</h2>
				<input name="" type="text" value="Search" />
				
		
		</div>		
		
		
		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#">Overall Usage</a></h2>

<?php

	include 'library/graph-alltime_download.php';
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
