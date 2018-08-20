<?php

  $users = find_house_users();

?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>Edit Task</title>
</head>

<body>
  
<section id="create_task">
  <h1 class="header">Edit Task</h1>
    
    <div>
      <form method="post" action="tasks.php">
        <?php echo display_error(); ?>
        <div class="input-group">
          <label> <h2>Task Name:</h2> </label>
          <input type="text" name="taskname" value="<?php echo $_SESSION['task']['name']; ?>">
        </div>
        <div class="input-group">
          <label> <h2>Description:</h2> </label>
          <input type="text" name="task_desc" value="<?php echo $_SESSION['task']['details']; ?>">
        </div>
        <div class="input-group">
          <label><h2 id="Owner">To be done by:</h2></label>
          <!-- can change the user name function or can include assigned to user into the session task  -->
          <select name="Owner">
            <option value = "<?php echo $_SESSION['task']['assigned_to']; ?>" selected="selected"><?php echo $_SESSION['task']['assigned_to']; ?></option>
            <option value = "0">Don't know yet</option>
            <?php while($user = mysqli_fetch_assoc($users)) { ?>
                <option value="<?php echo $user['name']; ?>"><?php echo $user['name']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="input-group">
          <label><h2>Should take approximately:</h2></label>
          <select name="duration" >
            <option value = "<?php echo $_SESSION['task']['duration']; ?>" selected="selected"><?php echo $_SESSION['task']['duration']; ?></option>
            <option value = "00:00:00">Depends who does it</option>
            <option value="00:15:00">15 min</option>
            <option value="00:30:00">30 min</option>
            <option value="01:00:00">1 hour</option>
            <option value="02:00:00">2 hours</option>
            <option value="03:00:00">3 hours</option>
            <option value="03:00:00">all your life</option>
          </select>
        </div>
        <div id="DoneTaskDiv">
          <label><h2>Task already done</h2></label>
          <?php if($_SESSION['task']['status'] === 'done') { ?>
                <input type="hidden" name="TaskCompletedCB1" value="0" />
                <input type="checkbox" id="TaskCompletedCB1" name="TaskCompletedCB" onclick="CompletedTasks()" value="1" checked/>
              <?php }else{ ?>
                <input type="hidden" name="TaskCompletedCB2" value="0" />
                <input type="checkbox" id="TaskCompletedCB2" name="TaskCompletedCB" onclick="CompletedTasks()" value="1"/>
              <?php } ?>
        </div>

        <div class="input-group">
          <label><h2 id="DueDate">Due date:</h2></label>
          <input type="date" name="due_date" id="due_date" value="<?php echo $_SESSION['task']['due_date']; ?>">
        </div>
        <!-- should not be able to edit recurrent tasks at all I think -->
          <!-- need to disable submit button until task name is provided/there is no error div -->
          <button type="submit" class="btn" name="edit_task_btn">Save</button>
        </div>
       </form>
       <div>
              <button id="cancelbtn" class="btn" onclick="CloseModal('EditTaskModal')">Cancel</button>

        </div>
    </div>
  </section>

<?php
      mysqli_free_result($users);
    ?>
</body>
</html>