<?php include('_initialize.php') ?>

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
        <tr>
          <!-- this will be populated form the db -->
          <td>Clean the bathroom</td>
          <td>yesterday</td>
          <td><input type="checkbox" name="name1" />&nbsp;</td>
        </tr> 
      </tbody>
    </table>
  </section>

  <section class="task_display" id="MyPTasks"> 
    <h2 class="section header">My Pending Tasks</h2>  
    <table class="section table">
      <thead class="section t-head">
        <tr>
   <!-- this will be populated form the db -->
          <th></th>
          <th></th>
          <th>decline</th> 
          <th>accept</th>
        </tr>
     </thead>
      <tbody id="MyPTaskResults">
        <tr>
          <td width="230">Polina assigned you: Clean the bathroom</td>
          <td>Sunday</td>
          <td><input type="checkbox" name="name1" />&nbsp;</td>
          <td><input type="checkbox" name="name1" />&nbsp;</td>
        </tr> 
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
        <tr>
   <!-- this will be populated form the db -->
          <td>Clean the bathroom</td>
          <td>today</td>
<!-- need to populate names form the house to assign to -->
          <td>(assign)</td>
          <td><img src="https://ourhouse.000webhostapp.com/imgs/delete.png"></td>
        </tr>
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
        <tr>
   <!-- this will be populated form the db -->
          <td>Clean the bathroom</td>
          <td>today</td>
          <td>Phil</td>
          <td><img src="https://ourhouse.000webhostapp.com/imgs/delete.png"></td>
        </tr>
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
        <tr>
          <td>Clean the bathroom</td>
          <td>Phil</td>
          <td>(send reward)</td>
        </tr>
      </tbody>
    </table>
  </section>  
</body>
</html>