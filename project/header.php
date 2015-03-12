<div id="header">
	<?php if(isset($_SESSION['loggedin'])): ?>
		Hello <?php echo getUsername($_SESSION['loggedUser']); ?>
		<a href="index.php?logoutG">Log Out</a>
	<?php else: ?>
	    <a href="register.php">Sign Up</a>
	    <a href="login.php" target="_top">Login</a>
	<?php endif; ?>
	<h1><a href="index.php">Engineering Connect</a></h1>
</div>