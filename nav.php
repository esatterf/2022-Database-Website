<nav>
	<a class="<?php
	if (PATH_PARTS ['filename'] == "index"){
		print 'activePage';
	}
	?>" href="index.php">Featured Teams</a>
	
	<a class="<?php
	if (PATH_PARTS ['filename'] == "teams"){
		print 'activePage';
	}
	?>" href="teams.php">All Teams</a>
	
	<a class="<?php
	if (PATH_PARTS['filename'] == "about"){
		print 'activePage';
	}
	?>" href="about.php">About</a>
	
	<a class="<?php
	if (PATH_PARTS ['filename'] == "register"){
		print 'activePage';
	}
	?> " href="register.php">Register</a>
	
	<a class="<?php
	if (PATH_PARTS ['filename'] == "form"){
		print 'activePage';
	}
	?> " href="form.php">Submit a Team!</a>
</nav>
