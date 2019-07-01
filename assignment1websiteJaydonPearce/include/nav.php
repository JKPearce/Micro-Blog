<header>
		<nav>
			<div class="nav-links">
				<ul>
					<li>
						<a href="index.php">Home</a>
					</li>
					<li>
						<a href="createpost.php">Create Post</a>
					</li>
					<li>
						<a href="memberlist.php">Member List</a>
					</li>
					<li>
						<a href="stats.php">Member Stats</a>
					</li>
					<li>
						<a href="top20posts.php">Top 20 Posts</a>
					</li>
					<li>
						<a href="signup.php">Sign up</a>
					</li>
					<li>
						<a href="login.php">Log In</a>
					</li>
				</ul>
			</div>
		<?php //only display logout if logged in
		if(isset($_SESSION['username'])): ?> 
		<div class="logoutdiv">
			<p>You are logged in as: <?php echo $_SESSION['username'];?></p>
			<form class="logoutbutton" action="include/logout.php" method="POST">
				<button type="submit" name="submit">Logout</button>
			</form>
		</div>
		<?php endif;?>
		</nav>
</header>