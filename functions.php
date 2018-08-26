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
//todays date 
//end of the month

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
// this will be the PHP functions for creating tasks//////////////
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

// validate imput
//task name mandatory 
if (empty($task_name)) { 
		array_push($errors, "Task name is required"); 
	}
// task name not more than ? char 
// task descr no more tha char 
//if name/due date already exists throw error or rather relay sb error! 

//if task is assigned, set assigend to, assigned by and status.
if (count($errors) == 0) {
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
			// echo $query;
			mysqli_query($db, $query);
			// header('location: tasks.php');
			// exit;

			// on page reload this is saving the previous query and saving tasks twice! can fix later, probably somethign with the form action or method
		} else {
	//enter the details into the recurrent task table
			$query = "INSERT INTO  recurrent_tasks(name, details, duration, frequency, default_owner, creator) 
						  VALUES('$task_name', '$descr','$duration', '$frequency', $owner_id, $user_id)";
			// echo $query;
			mysqli_query($db, $query);
	//enter details into task schedule for 2 years of tasks with intervals as frequency set
			$task_date 	= new DateTime($due_date);
			$interval 	= new DateInterval($frequency);
			
			$end_date 	= new DateTime($due_date);
			$period 	= 'P2Y';
			$end_date->add(new DateInterval($period));

			while($task_date<$end_date){
				$task_date_str = $task_date->format('Y-m-d');
				
				$query = "INSERT INTO  task_schedule(name, details, status, due_date, duration, assigned_to, assigned_by, creator) 
							  VALUES('$task_name', '$descr', '$status', '$task_date_str', '$duration', $owner_id, $assigned_by_id, $user_id)";
				mysqli_query($db, $query);

				$task_date->add($interval);
				// echo $task_date->format('Y-m-d H:i:s');
			}
		}
	}
}
/////////////////////////////////////////////////////////
// this will be the PHP functions for viewing tasks//////////////
/////////////////////////////////////////////////////////

$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 Months"));

// find all tasks this month assigned to the current user
function find_my_tasks(){
	global $db, $errors, $date_from, $date_to;

	$user_id = $_SESSION['user']['id'];

    $query = "SELECT * FROM task_schedule WHERE assigned_to=$user_id and status='assigned' and due_date between '$date_from' and '$date_to'";
    $result = mysqli_query($db, $query);
    return $result;
}

//find all tasks this month pending for the current user
function find_pending_tasks(){
	global $db, $errors, $date_from, $date_to;

	$user_id = $_SESSION['user']['id'];
    $query = "SELECT * FROM task_schedule WHERE assigned_to=$user_id and status='pending' and due_date between '$date_from' and '$date_to'";
    $result = mysqli_query($db, $query);
    return $result;
}

//find all tasks that are open and have been created for this house
function find_open_tasks(){
	global $db, $errors, $date_from, $date_to;

	$user_house = $_SESSION['user']['house'];

    $query = "SELECT T.id as task_id, T.name as task_name, T.due_date as due_date, U.name as user_name FROM task_schedule T, users U WHERE T.status='open' and T.creator =U.id  and U.house = '$user_house' and T.due_date between '$date_from' and '$date_to'";

    // "SELECT * FROM task_schedule WHERE status='open' and creator in (SELECT id FROM users WHERE house='$user_house') and due_date between '$date_from' and '$date_to'";
    $result = mysqli_query($db, $query);
    return $result;

}

//find all tasks for this month for this house that are assigned to other users
function find_assigned_tasks(){
	global $db, $errors, $date_from, $date_to;

	$user_id = $_SESSION['user']['id'];
	$user_house = $_SESSION['user']['house'];

    $query = "SELECT T.id as task_id, T.name as task_name, T.due_date as due_date, U.name as assigned_to FROM task_schedule T, users U WHERE T.status in ('assigned','pending') and T.assigned_to =U.id and U.id !=$user_id  and U.house = '$user_house' and T.due_date between '$date_from' and '$date_to'";

    // "SELECT * FROM task_schedule WHERE status='assigned' and assigned_to in (SELECT id FROM users WHERE house='$user_house' and id !=$user_id) and due_date between '$date_from' and '$date_to'";
    $result = mysqli_query($db, $query);
    return $result;

}

//find all completed tasks with due date of this and last months 
function find_compl_tasks(){
	global $db, $errors, $date_from, $date_to;

	$date_from = date('Y-m-d',strtotime("-1 Months"));

	$user_house = $_SESSION['user']['house'];

    $query = "SELECT T.id as task_id, T.name as task_name, U.name as assigned_to FROM task_schedule T, users U WHERE T.status='done' and T.assigned_to =U.id and U.house = '$user_house' and T.due_date between '$date_from' and '$date_to'";
    // in (SELECT id FROM users WHERE house='$user_house') and due_date between '$date_from' and '$date_to'";
    $result = mysqli_query($db, $query);
    return $result;

}

//maybe need past due date tasks? due date befor today and status not done

//display a modal with task details 
function display_task($id) {
	global $db, $errors;

	$query = "SELECT * FROM task_schedule  WHERE id = $id";

    $result = mysqli_query($db, $query);
    $task = mysqli_fetch_assoc($result);

	$_SESSION['task'] = $task;

	echo '<style type="text/css">
        #EditTaskModal {
            display: block;
        }
        </style>';
}


/////////////////////////////////////////////////////////
// this will be the PHP functions for editing and deleting tasks//////////////
/////////////////////////////////////////////////////////

//functions for the form submit to update tasks
if (isset($_POST['edit_task_btn'])) {
	edit_task();
}

function edit_task() {
global $db, $errors;

//get form values

	$task_id 	 = $_SESSION['task']['id'];
	$task_name   =  e($_POST['taskname_edit']);
	$descr       =  e($_POST['task_desc_edit']);
	$owner_name  =  e($_POST['Owner_edit']);
	$duration    =  e($_POST['duration_edit']);
	$completed   =  e($_POST['CompletedTasksEditCB']);
	$due_date    =  e($_POST['due_date_edit']);
	$status 	 = 'open';
	$user_id     = $_SESSION['user']['id'];

// validate imput
//task name mandatory 
if (empty($task_name)) { 
		array_push($errors, "Task name is required"); 
	}
// task name not more than ? char 
// task descr no more tha char 
//if name/due date already exists throw error or rather relay sb error! 

//if task is assigned, set assigend to, assigned by and status.
if (count($errors) == 0) {
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

	//if complete change status to done
	if ($completed == '1') {
		$status = 'done';
	}
	$query = "UPDATE  task_schedule SET name = '$task_name', details='$descr', status='$status', due_date='$due_date', duration='$duration', assigned_to=$owner_id, assigned_by=$assigned_by_id, creator=$user_id WHERE id = $task_id";
	mysqli_query($db, $query);
	
	unset($_SESSION['task']);

	}
}

//functions for the form submit to delete tasks
if (isset($_POST['delete_task_btn'])) {
	delete_task();
}

function delete_task() {
global $db, $errors;

	$task_id 	 = $_SESSION['task']['id'];

	$query = "DELETE FROM task_schedule WHERE id = $task_id";
	mysqli_query($db, $query);
	
	unset($_SESSION['task']);

}

//this will update the row of the tsk id sent by get doneid request to done
function set_task_to_done($doneid) {
global $db, $errors;
	$query = "UPDATE task_schedule SET status='done' WHERE id = $doneid";
	mysqli_query($db, $query);
}

function accept_task($acceptid) {
global $db, $errors;
	$query = "UPDATE task_schedule SET status='assigned' WHERE id = $acceptid";
	mysqli_query($db, $query);
}

function decline_task($declineid) {
global $db, $errors;
// when you decline apending task, it will go to the person who originally assigned it to you but the status will stay pending so that they an see its been declined. might add a default string into description here. the new assigned person wil then see it in pending and either accept and change status to assigned or decline in which case nothing will happen. 
	$query = "UPDATE task_schedule SET assigned_to = assigned_by  WHERE id = $declineid";
	mysqli_query($db, $query);
}

function find_tasks(){
	global $db, $errors;

	$user_house = $_SESSION['user']['house'];

	$query = "SELECT U.name as name, count(*) as value FROM users U, task_schedule T  WHERE T.status='done' and T.assigned_to =U.id and U.house = '$user_house' group by T.assigned_to";
	$result = mysqli_query($db, $query);
	$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $data;
}