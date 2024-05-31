<nav>
	<a class="<?php
	if (PATH_PARTS ['filename'] == "admin-report"){
		print 'activePage';
	}
	?>" href="admin-report.php">Admin Report</a>
	
	<a class="<?php
	if (PATH_PARTS ['filename'] == "register"){
		print 'activePage';
	}
	?> " href="register.php">Admin Register</a>
	
	<a class="<?php
	if (PATH_PARTS ['filename'] == "form"){
		print 'activePage';
	}
	?> " href="form.php">Admin Form</a>
</nav>
