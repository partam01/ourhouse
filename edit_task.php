<?php

  $users = find_house_users();

?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>Edit Task</title>
</head>

<body>
  
<section id="edit_task">
  <h1 class="header">Edit Task</h1>
    
    <div>
      <form method="post" action="tasks.php">
        <?php echo display_error(); ?>
        <div>
         <!-- this will delete the task instead of updating it -->
          <!-- need to disable submit button until task name is provided/there is no error div -->
          <button type="submit" class="btn" name="delete_task_btn">Delete task</button> 
        </div>
        <div class="input-group">
          <label> <h2>Task Name:</h2> </label>
          <input type="text" name="taskname_edit" value="<?php echo $_SESSION['task']['name']; ?>">
        </div>
        <div class="input-group">
          <label> <h2>Description:</h2> </label>
          <input type="text" name="task_desc_edit" value="<?php echo $_SESSION['task']['details']; ?>">
        </div>
        <div class="input-group">
          <label><h2 id="OwnerEdit">To be done by:</h2></label>

          <select name="Owner_edit">
            <option value = "0">Don't know yet</option>
            <?php while($user = mysqli_fetch_assoc($users)) { ?>
              <?php if($_SESSION['task']['assigned_to'] === $user['id']) { ?>
                <option value = "<?php echo $user['name']; ?>" selected="selected"><?php echo $user['name']; ?></option>
                <?php }else{ ?>
                <option value="<?php echo $user['name']; ?>"><?php echo $user['name']; ?></option>
              <?php } ?>
            <?php } ?>
          </select>
        </div>

        <div class="input-group">
          <label><h2>Should take approximately:</h2></label>
          <select name="duration_edit" >
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
        <div>
          <label><h2>Task already done</h2></label>
          <?php if($_SESSION['task']['status'] === 'done') { ?>
                <input type="hidden" name="CompletedTasksEditCB" value="0" />
                <input type="checkbox" id="CompletedTasksEditCB" name="CompletedTasksEditCB" onload="CompletedTasksEdit()" value="1" checked/>
              <?php }else{ ?>
                <input type="hidden" name="CompletedTasksEditCB" value="0" />
                <input type="checkbox" id="CompletedTasksEditCB" name="CompletedTasksEditCB" onload="CompletedTasksEdit()" value="1"/>
              <?php } ?>
        </div>

        <div class="input-group">
          <label><h2 id="DueDateEdit">Due date:</h2></label>
          <input type="date" name="due_date_edit" value="<?php echo $_SESSION['task']['due_date']; ?>">
        </div>
        <br>
        <div>
          <!-- need to disable submit button until task name is provided/there is no error div -->
          <button type="submit" class="btn" name="edit_task_btn">Save changes</button>
        </div>
       </form>
       <div>
              <button class="btn" onclick="CloseModal('EditTaskModal')">Cancel</button>

        </div>
    </div>
  </section>

<?php
      mysqli_free_result($users);
    ?>
</body>
</html>