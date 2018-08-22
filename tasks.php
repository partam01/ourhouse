<?php include('_initialize.php') ?>
<?php
  $mytasks = find_my_tasks();
  $pendingtasks = find_pending_tasks();
  $openstasks = find_open_tasks();
  $assignedtasks = find_assigned_tasks();
  $compltasks = find_compl_tasks();
?>
<!-- if a task id is passed inthe url by clicking on a task name, edit task modal will pop up -->
<?php
  if (isset($_GET['id'])) {
    echo display_task($_GET['id']);
  }
?>
<!-- this might call a php function to update task to done when checkbox is set -->
<?php
  if (isset($_GET['doneid'])) {
    echo set_task_to_done($_GET['doneid']);?>
    <script type="text/javascript">
    RefreshTasks();
    </script>

<?php } ?>
<!-- this will call accept task update -->
<?php
  if (isset($_GET['acceptid'])) {
    echo accept_task($_GET['acceptid']);?>
    <script type="text/javascript">
    RefreshTasks();
    </script>

<?php } ?>
<!-- this calls decline task update -->
<?php
  if (isset($_GET['declineid'])) {
    echo decline_task($_GET['declineid']);?>
    <script type="text/javascript">
    RefreshTasks();
    </script>

<?php } ?>

<!DOCTYPE html>

<html lang="en">

<head>
	<title>OurHouse Tasks</title> 
</head>

<body>
  <h1 class="header">Tasks</h1>
  <div>
    <button id="CreateTaskBtn" class="Btn" onclick="OpenModal('CreateTaskModal')">Crete new task</button>
  </div>

  <!-- The Modal pop up window for task create -->
<div id="CreateTaskModal" class="modal">

  <!-- task create content -->
  <div class="modal-content">
    <span id="close" class="close" onclick="CloseModal('CreateTaskModal')">&times;</span>
    <?php include('create_task.php') ?>
  </div>

</div>

<!-- this might display the edit task modal -->
 <div id="EditTaskModal" class="modal">
  <div class="modal-content">
 <span id="close" class="close" onclick="CloseModal('EditTaskModal')">&times;</span>
 <?php include('edit_task.php') ?>
  </div>
 </div>
  
  <section class="task_display" id="MyOTasks"> 
    <h2 class="section header">My Open Tasks</h2>  
    <table class="section table">
      <thead class="section t-head">
        <tr>
          <th>Task name</th>
          <th>Due date</th>
          <th>Done</th>
        </tr>
     </thead>
      <tbody id="MyOTaskResults">
        <?php while($mytask = mysqli_fetch_assoc($mytasks)) { ?>
                <tr>
                  <td > <a href="tasks.php?id=<?php echo $mytask['id']; ?>"> <?php echo $mytask['name']; ?> </a>  </td>
                  <td><?php echo $mytask['due_date']; ?></td> 
                  <td><input type="checkbox"  onclick="SetToDone('<?php echo $mytask['id']; ?>')" />&nbsp;</td>
                </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>

  <section class="task_display" id="MyPTasks"> 
    <h2 class="section header">My Pending Tasks</h2>  
    <table class="section table">
      <thead class="section t-head">
        <tr>
          <th></th>
          <th></th>
          <th>Decline</th> 
          <th>Accept</th>
        </tr>
     </thead>
      <tbody id="MyPTaskResults">
        <?php while($pendingtask = mysqli_fetch_assoc($pendingtasks)) { ?>
                <tr>
                  <td > <a href="tasks.php?id=<?php echo $pendingtask['id']; ?>"> <?php echo $pendingtask['name']; ?> </a>  </td>
                  <td><?php echo $pendingtask['due_date']; ?></td> 
                  <td><input type="checkbox" onclick="DeclineTask('<?php echo $pendingtask['id']; ?>')" />&nbsp;</td>
                  <td><input type="checkbox" onclick="AcceptTask('<?php echo $pendingtask['id']; ?>')" />&nbsp;</td>
                </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>

  <section class="task_display" id="UnTasks"> 
    <h2 class="section header">Unassigned Tasks</h2>  
    <table class="section table">
      <thead class="section t-head">
        <tr>
   <!-- this will be populated form the db -->
          <th>Task name</th>
          <th>Due date</th>
        </tr>
     </thead>
      <tbody id="UnTaskResults">
        <?php while($openstask = mysqli_fetch_assoc($openstasks)) { ?>
                <tr>
                  <td > <a href="tasks.php?id=<?php echo $openstask['task_id']; ?>"> <?php echo $openstask['task_name']; ?> </a>  </td>
                  <td><?php echo $openstask['due_date']; ?></td> 
                  <td>(assign)</td>
                  <td><img src="https://ourhouse.000webhostapp.com/imgs/delete.png"></td>
                </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>

  <section class="task_display" id="ATasks"> 
    <h2 class="section header">Assigned Tasks</h2>  
    <table class="section table">
      <thead class="section t-head">
        <tr>
   <!-- this will be populated form the db -->
          <th>Task name</th>
          <th>Due date</th>
          <th>Owner</th>
        </tr>
     </thead>
      <tbody id="ATaskResults">
        <?php while($assignedtask = mysqli_fetch_assoc($assignedtasks)) { ?>
                <tr>
                  <td > <a href="tasks.php?id=<?php echo $assignedtask['task_id']; ?>"> <?php echo $assignedtask['task_name']; ?> </a>  </td>
                  <td><?php echo $assignedtask['due_date']; ?></td> 
                  <td><?php echo $assignedtask['assigned_to']; ?></td>
                  <td><img src="https://ourhouse.000webhostapp.com/imgs/delete.png"></td>
                </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>

  <section class="task_display" id="CompTasks"> 
    <h2 class="section header">Completed Tasks</h2>  
    <table class="section table">
      <thead class="section t-head">
        <tr>
   <!-- this will be populated form the db -->
          <th>Task name</th>
          <th>Owner</th>
        </tr>
     </thead>
      <tbody id="ATaskResults">
        <?php while($compltask = mysqli_fetch_assoc($compltasks)) { ?>
                <tr>
                  <td > <a href="tasks.php?id=<?php echo $compltask['task_id']; ?>"> <?php echo $compltask['task_name']; ?> </a>  </td>
                  <td><?php echo $compltask['assigned_to']; ?></td>
                  <td>(send reward)</td>
                </tr>
        <?php } ?>
      </tbody>
    </table>
    <br>
  </section>  
</body>
</html>