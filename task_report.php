<?php include('_initialize.php') ?>
<?php
  $users = find_house_users();
?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>Historical task report</title>
</head>

<body>

  <h1 class="header">Historical task report</h1>
    
   <section class="task_search" id="task_search"> 
    <div>
      <form method="post" action="task_report.php">
        <?php echo display_error(); ?>
        <div class="input-group">
          <label> <h2>Task Name: </h2> </label>
          <input type="text" name="taskname_search">
        </div>

        <div class="input-group">
          <label><h2 id="Owner">Owner: </h2></label> 
          <select name="owner_search">
            <option value = "any" selected="selected" >any owner</option>
            <option value = "0">not assigned</option>
    <!-- populate options with users from same house -->
            <?php while($user = mysqli_fetch_assoc($users)) { ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="input-group">
          <label><h2>Duration: </h2></label>
          <select name="duration_search" >
            <option value ="any" selected="selected">any duration</option>
            <option value ="00:00:00">not set</option>
            <option value="00:15:00">15 min</option>
            <option value="00:30:00">30 min</option>
            <option value="01:00:00">1 hour</option>
            <option value="02:00:00">2 hours</option>
            <option value="03:00:00">3 hours</option>
            <option value="24:00:00">1 day</option>
          </select>
        </div>

        <div id="DoneTaskDiv">
          <label><h2>Task status</h2></label>
          <select name="status_search" >
            <option value = "any" selected="selected">any status</option>
            <option value = "open">Open</option>
            <option value="assigned">Assigned</option>
            <option value="pending">Pending</option>
            <option value="done">Done</option>
          </select>
        </div>

        <div class="input-group">
          <label><h2 id="Date_from_search">Due date from:</h2></label>
          <input type="date" name="Date_from_search" id="Date_from_search" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="input-group">
          <label><h2 id="Date_to_search">Due date to:</h2></label>
          <input type="date" name="Date_to_search" id="Date_to_search" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <br>
        <div>
          <!-- need to disable submit button until task name is provided/there is no error div -->
          <button type="submit" class="btn" name="search_task_btn">Search</button>
        </div>
       </form>
      </section>

<section class="task_display" id="TaskResults"> 
    <table class="section table">
      <thead class="section t-head">
        <tr>
          <th>Task name</th>
          <th>Owner</th>
          <th>Duration</th>
          <th>Status</th>
          <th>Due date</th>
        </tr>
     </thead>
      <tbody id="TaskResultsBody">
       <?php
         if (isset($_POST['search_task_btn'])){  
          $tasks = get_tasks();?>
      
        <?php  while($task = mysqli_fetch_assoc($tasks)) { ?>
                <tr>
                  <td><?php echo $task["task_name"]; ?></td> 
                  <!-- if this is output as number can convert to user name from user table doesnt work bitch!!! -->
                 <!--  <?php if(!is_null($task["owner"])){ ?>
                    <?php while($user = mysqli_fetch_assoc($users)) { ?>
                      <?php if($task["owner"] === $user['id']) { ?>
                        <td><?php echo $user["name"]; ?></td>
                        <?php }else{ ?>
                        <td><?php echo $task["owner"]; ?></td>
                      <?php } ?>
                    <?php } ?>
                  <?php } ?> -->
                  
                  <td><?php echo $task["owner"]; ?></td>
                  <td><?php echo $task["duration"]; ?></td>
                  <td><?php echo $task["status"]; ?></td>
                  <td><?php echo $task["due_date"]; ?></td>
                </tr>
           <?php }?>
        <?php }?>
      </tbody>
    </table>
  </section>


<?php
      mysqli_free_result($users);
    ?>
</body>
</html>