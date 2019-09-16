	<?php
		setcookie("name", '', time() - 3600, '/');
		echo 'You are logged out<br><br>';
	
		echo "<a href='cps3740_p2.html'>Log back in</a>";
		
	?>
