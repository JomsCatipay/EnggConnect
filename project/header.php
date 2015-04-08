<div id="topbar">
	<?php if(isset($_SESSION['loggedin'])): ?>
		<p>Hello, <?php echo $_SESSION['loggedUser']['username']; ?>
		<a href="index.php?logoutG">Log Out</a>
	<?php else: ?>
		<a href="register.php">Sign Up</a><a href="login.php" target="_top">Log In</a>
	<?php endif; ?>
</div>
<header>
	<h1><a href="index.php">Engineering Connect</a></h1>
	<nav>
		<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedUser']['type']=='Administrator'): ?>
		<a href="add_topic.php">Add</a> |
		<a href="users.php">Users</a> |
		<?php endif; ?>
		<a href="topics.php">Topics</a> |
		<a href="faq.php">FAQ</a>
	</nav>
</header>
	