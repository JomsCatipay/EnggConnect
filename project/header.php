<div id="topbar">
	<?php if(isset($_SESSION['loggedin'])): ?>
		<p>Hello, <?php echo $_SESSION['loggedUser']['username']; ?></p>
		<a href="index.php?logoutG">Log Out</a>
	<?php else: ?>
		<a href="register.php">Sign Up</a><a href="login.php" target="_top">Log In</a>
	<?php endif; ?>
</div>
<header>
	<h1><a href="index.php"><img src="images/EnggConnect-logo.png" alt="Engineering Connect" /></a></h1>
	<nav>
	<ul>
		<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedUser']['type']=='Administrator'): ?>
		<li><a href="users.php">Manage</a> |
			<ul>
				<li><a href="add_topic.php">Add</a></li>
				<li><a href="users.php">Users</a></li>
			</ul>
		</li>
		<?php endif; ?>
		<li><a href="topics.php">Topics</a> |</li>
		<li><a href="faq.php">FAQ</a></li>
	</ul>
	</nav>
</header>
	