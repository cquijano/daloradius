<?php

    include ("menu-home.php");
	
?>	
		<div id="contentnorightbar">
		
				<h2 id="Intro"><a href="#">System Logfile</a></h2>
				<p>

<?php
	include 'library/exten-syslog_log.php';
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
