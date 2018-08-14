<?php include('_initialize.php') ?>

<html lang="en">
<head>
	<title>Profile information</title>
</head>
<body>
	<section id="profile">
	<h1>Profile</h1>
		<div>
			<form method="post" action="profile_pic">
				<div class="profile_pic">
					<label> <h2>Profile picture:</h2> </label>
					<img src="imgs/delete.png">
					<input type="hidden" name="MAX_FILE_SIZE" value="102400">
					<input type="file" name="profilePic" id="profilePic" accept="image/*">
					<a href="">Change</a>	
				</div>
			</form>
			<form method="post" action="profile.php">
				<?php echo display_error(); ?>
				<div class="input-group">
					<label> <h2>Name:</h2> </label>
					<input type="text" name="username" value="<?php echo $_SESSION['user']['name']; ?>">
				</div>
				<div class="input-group">
					<label> <h2>House:</h2> </label>
					<input type="text" name="house" value="<?php echo $_SESSION['user']['house']; ?>">
				</div>
				<div class="input-group">
					<label><h2>Email address:</h2></label>
					<input type="email" name="email" value="<?php echo $_SESSION['user']['email'] ?>">
				</div>
				<div class="input-group">
					<label><h2>Password:</h2></label>
					<input type="password" name="new_password">
				</div>
				<br>
				<button type="submit" class="btn" name="update_prof_btn">Submit new details</button>
			</form>
		</div>
	</section>
</body>
</html>
