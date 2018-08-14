<?php 
session_start();
$servername = "localhost";
$dbusername = "id6479224_polina";
$password = "ourhouse";
$database = "id6479224_ourhouse";

// connect to database
$db = mysqli_connect($servername, $dbusername, $password, $database);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

//////////////////////////////////////////////////////////////////////
// this will be the PHP functions for user create, login and update //
//////////////////////////////////////////////////////////////////////

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

			$query = "INSERT INTO users (name, email, password) 
					  VALUES('$username', '$email', '$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');				
		}
	}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

//check if user is logged in
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}	

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grab form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE name='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			$logged_in_user = mysqli_fetch_assoc($results);

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

// call the update_profile() function if edit_prof_btn is clicked
if (isset($_POST['update_prof_btn'])) {
	update_profile();
}
function update_profile(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$house       =  e($_POST['house']);
	$password    =  e($_POST['new_password']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}

	// update user if there are no errors in the form
	if (count($errors) == 0) {
		$user_id = $_SESSION['user']['id'];

		$query = "UPDATE users SET name='$username', house='$house', email = '$email' WHERE id = $user_id ";
		mysqli_query($db, $query);

		if (!empty($password)){
			$password = md5($password);//encrypt the password before saving in the database
			$query = "UPDATE users SET password='$password' WHERE id = $user_id ";
			mysqli_query($db, $query);
		} 

		$_SESSION['user'] = getUserById($user_id); // update session details	
		//header('location: profile.php');		
		}
	}
/////////////////////////////////////////////////////////
// this will be the PHP functions for tasks//////////////
/////////////////////////////////////////////////////////

//find all users within the same house to display valid assign options
function find_house_users(){
	  global $db, $errors; 

	$user_house = $_SESSION['user']['house'];
    $query = "SELECT * FROM users WHERE house='$user_house'";
    $result = mysqli_query($db, $query);
    return $result;
  }

 function find_user_id($name){
    global $db, $errors; 

    $id = null;

	$users = find_house_users();

	while($user = mysqli_fetch_assoc($users)){
		if($user['name']==$name){
			$id =$user['id'];
		}
	}
	return $id;
}
   
//functions for the form submit to create tasks
if (isset($_POST['create_task_btn'])) {
	create_task();
}

function create_task() {
global $db, $errors;

// validate imput
//task name mandatory 
// due date is mandatory  
// task name not more than ? char 
// task descr no more tha char 
//if name/due date already exists throw error or rather relay sb error! 

//get form values

	$recurrent   =  e($_POST['RecurrentTaskCB']);
	$task_name   =  e($_POST['taskname']);
	$descr       =  e($_POST['task_desc']);
	$owner_name  =  e($_POST['Owner']);
	$duration    =  e($_POST['duration']);
	$completed   =  e($_POST['TaskCompletedCB']);
	$due_date    =  e($_POST['due_date']);
	$frequency   =  e($_POST['frequency']);
	$status 	 = 'open';
	$user_id     = $_SESSION['user']['id'];

//if task is assigned, set assigend to, assigned by and status.
if ($owner_name=='0'){
	$owner_id = "NULL";
	$assigned_by_id = "NULL";
}else {
	$owner_id = find_user_id($owner_name);
	$assigned_by_id = $user_id;
	if($owner_id == $assigned_by_id){
		$status = 'assigned';
	}else{
		$status = 'pending';
	}	
}

//check if the task is recurrent
	if ($recurrent == '0') {
		//if complete change status to done
		if ($completed == '1') {
			$status = 'done';
		}
		$query = "INSERT INTO  task_schedule(name, details, status, due_date, duration, assigned_to, assigned_by, creator) 
					  VALUES('$task_name', '$descr', '$status', '$due_date', '$duration', $owner_id, $assigned_by_id, $user_id)";
		echo $query;
		mysqli_query($db, $query);
		// header('location: tasks.php');
		// exit;

		// on page reload this is saving the previous query and saving tasks twice! can fix later, probably somethign with the form action or method
	} else {
//enter the details into the recurrent task table
		$query = "INSERT INTO  recurrent_tasks(name, details, duration, frequency, default_owner, creator) 
					  VALUES('$task_name', '$descr','$duration', '$frequency', $owner_id, $user_id)";
		echo $query;
		mysqli_query($db, $query);
//enter details into task schedule for 2 years of tasks with intervals as frequency set
		$task_date = new DateTime($due_date);
		$interval = new DateInterval($frequency);
		
		$end_date = new DateTime($due_date);
		$end_date->add(new DateInterval('P2Y'));

		while($task_date<$end_date){

			$task_date_str = $task_date->format('Y-m-d');

			$query = "INSERT INTO  task_schedule(name, details, status, due_date, duration, assigned_to, assigned_by, creator) 
						  VALUES('$task_name', '$descr', '$status', '$task_date_str', '$duration', $owner_id, $assigned_by_id, $user_id)";
			mysqli_query($db, $query);

			$task_date->add($interval);
			// echo $task_date->format('Y-m-d H:i:s');
		}
	}

	//IT works but due date is coming back as today even when not set, so need to set it to today always as its mandatory!
}

