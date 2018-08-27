<?php

  $users = find_house_users();

?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>Create New Task</title>
</head>

<body>
  
<section id="create_task">
  <h1 class="header">Create a New Task</h1>
    
    <div>
      <form method="post" action="tasks.php">
        <?php echo display_error(); ?>
        <div class="input-group">
          <label> <h2>Task Name:</h2> </label>
          <input type="text" name="taskname">
        </div>
        <div class="input-group">
          <label> <h2>Description:</h2> </label>
          <input type="text" name="task_desc" >
        </div>
        <div class="input-group">
          <label><h2 id="Owner">To be done by:</h2></label>
          
          <select name="Owner">
            <option value = "21" selected="selected" >Don't know yet</option>
    <!-- populate options with users from same house -->
            <?php while($user = mysqli_fetch_assoc($users)) { ?>
                <option value="<?php echo $user['name']; ?>"><?php echo $user['name']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="input-group">
          <label><h2>Should take approximately:</h2></label>
          <select name="duration" >
            <option value = "00:00:00" selected="selected">Depends who does it</option>
            <option value="00:15:00">15 min</option>
            <option value="00:30:00">30 min</option>
            <option value="01:00:00">1 hour</option>
            <option value="02:00:00">2 hours</option>
            <option value="03:00:00">3 hours</option>
            <option value="24:00:00">1 day</option>
          </select>
        </div>
        <div id="DoneTaskDiv">
          <label><h2>Task already done</h2></label>
          <input type="hidden" name="TaskCompletedCB" value="0" />
          <input type="checkbox" id="TaskCompletedCB" name="TaskCompletedCB" onclick="CompletedTasks()" value="1" />
        </div>

        <div class="input-group">
          <label><h2 id="DueDate">Due date:</h2></label>
          <input type="date" name="due_date" id="due_date" value="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div id="RecurrentTaskDiv">
          <div>
          <label><h2>This task is recurrent</h2></label>
          <input type="hidden" name="RecurrentTaskCB" value="0" />
          <input type="checkbox" id="RecurrentTaskCB" name="RecurrentTaskCB"  onclick="RecurrentTasks()" value="1"/>    
          </div>

          <div class="input-group" id="FrequencyDiv" style="display:none">
            <label><h2>Repeat:</h2></label>
            <select name="frequency" >
              <option value="P1D">Daily</option>
              <option value="P7D" selected="selected">Weekly</option>
              <option value="P1M">Monthly</option>
              <option value="P1Y">Yearly</option>
            </select>
          </div>
        </div>

        <br>
        <div>
          <!-- need to disable submit button until task name is provided/there is no error div -->
          <button type="submit" class="btn" name="create_task_btn">Save</button>
        </div>
       </form>
       <div>
              <button id="cancelbtn" class="btn" onclick="CloseModal('CreateTaskModal')">Cancel</button>

        </div>
    </div>
  </section>

<?php
      mysqli_free_result($users);
    ?>
</body>
</html>