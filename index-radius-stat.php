<?php

    include ("menu-home.php");
        
	include_once('library/config_read.php');
    $log = "visited page: ";
    include('include/config/logging.php');
	
?>	
		
		
		<div id="contentnorightbar">
		
		<h2 id="Intro"><a href="#"><? echo $l[Intro][indexradiusstat.php]; ?></a></h2>
				<p>

<?php
	include 'library/exten-radius_server_info.php';
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
