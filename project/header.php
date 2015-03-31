<div id="topbar">
	<?php if(isset($_SESSION['loggedin'])): ?>
		<p>Hello, <?php echo getUsername($_SESSION['loggedUser']); ?></p>
		<a href="index.php?logoutG">Log Out</a>
	<?php else: ?>
		<a href="register.php">Sign Up</a><a href="login.php" target="_top">Log In</a>
	<?php endif; ?>
</div>
<header>
	<h1><a href="index.php">Engineering Connect</a></h1>
	<nav>
		<a href="index.php">Home</a> |
		<a href="add_topic.php">Topics</a> |
		<a href="index.php">FAQs</a>
	</nav>
</header>
	