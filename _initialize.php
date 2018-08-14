<?php 
	include('functions.php');
	if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>

<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script type="text/javascript" src ="scriptsmulti.js"></script>
</head>
<body>
	<!-- this is to display the menu and logo -->
	<div id="sidebar">
	  <h2>OurHouse LOGO</h2>
	  <nav id="MainMenu" class="Menu">
	     <a href="index.php" class="menu_btn">Home</a>
	     <a href="tasks.php" class="menu_btn">Tasks</a>
	     <a href="#" class="menu_btn">Messages</a>
	     <a href="#" class="menu_btn">Events</a>
	     <a href="profile.php" class="menu_btn">Edit Profile</a>
	  </nav>
	</div>
		<!-- logged in user information -->
	<div class="profile_info">
		<?php  if (isset($_SESSION['user'])) : ?>
			<strong><?php echo $_SESSION['user']['name']; ?></strong>

			<small>
				<a href="index.php?logout='1'" style="color: red;">Log out</a>
			</small>
		<?php endif ?>
	</div>
</body>
</html>
