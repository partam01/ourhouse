
// open the modal by model id passed with the button

function OpenModal(id) {
	document.getElementById(id).style.display = "block";
}


// close the modal by model id passed with the button
function CloseModal(id) {
	// var ErrorDiv = getElementsByClassName("error");
	// if (ErrorDiv===null){
		document.getElementById(id).style.display = "none";
		window.location = "tasks.php";
	// }else {
	// 	document.getElementById(id).style.display = "block";
	// }	
}

// display task frequency on create/edit task screen 
function RecurrentTasks() {
  // Get the checkbox
  var checkBox = document.getElementById("RecurrentTaskCB");
  var div1 = document.getElementById("FrequencyDiv");
  var div2 = document.getElementById("DoneTaskDiv");
  var dueDateText = document.getElementById("DueDate");
  var ownerText = document.getElementById("Owner");

  // If the checkbox is checked, reveal frequency and change due date label
  if (checkBox.checked === true){
    div1.style.display = "block"; //display frequency
    div2.style.display = "none"; //remove task completed checkbox
    dueDateText.innerText = 'Due date of the first task:';
    ownerText.innerText = 'Default task owner:';
  } else {
    div1.style.display = "none"; //remove frequency
    div2.style.display = "block"; //display task completed checkbox
    dueDateText.innerText = "Due date:";
    ownerText.innerText = 'To be done by:';
  }
}

function CompletedTasks() {
  // Get the checkbox
  var complCB = document.getElementById("TaskCompletedCB");
  var div1 = document.getElementById("RecurrentTaskDiv");
  var dueDateText = document.getElementById("DueDate");
  var ownerText = document.getElementById("Owner");

  // If the checkbox is checked, restrict recurrent task option and change due date label
  if (complCB.checked === true){
    div1.style.display = "none"; //remove recurrency div
    dueDateText.innerText = 'Completed on:';
    ownerText.innerText = 'Completed by:';
  } else {
    div1.style.display = "block"; //display recurrency div
    dueDateText.innerText = "Due date:";
    ownerText.innerText = 'To be done by:';
  }
}


//this doesn;t work for some reason 
function CompletedTasksEdit() {
  // Get the checkbox
  var complCB = document.getElementById("CompletedTasksEditCB");
  var dueDateText = document.getElementById("DueDateEdit");
  var ownerText = document.getElementById("OwnerEdit");

  // If the checkbox is checked, restrict recurrent task option and change due date label
  if (complCB.checked === true){
    dueDateText.innerText = 'Completed on:';
    ownerText.innerText = 'Completed by:';
  } else {
    dueDateText.innerText = "Due date:";
    ownerText.innerText = 'To be done by:';
  }
}

function SetToDone($task_id){
	//send the task id to php as doneid so that it can be updated
    window.location ='tasks.php?doneid='+$task_id;
}

function AcceptTask($task_id){
	//send the task id to php as doneid so that it can be updated
    window.location ='tasks.php?acceptid='+$task_id;
}

function DeclineTask($task_id){
	//send the task id to php as doneid so that it can be updated
    window.location ='tasks.php?declineid='+$task_id;
}


function RefreshTasks(){
	window.location ='tasks.php';
}

function DashboardSetToDone($task_id){
	//send the task id to php as doneid so that it can be updated
    window.location ='index.php?doneid='+$task_id;
}

function RefreshDashboard(){
	window.location ='index.php';
}

function create_graph($dat){
				var data = $dat
				var width = 420,
				    barHeight = 20;

				var x = d3.scale.linear()
				    .range([0, width]);

				var chart = d3.select(".chart")
				    .attr("width", width);

				  x.domain([0, d3.max(data, function(d) { return d.value; })]);

				  chart.attr("height", barHeight * data.length);

				  var bar = chart.selectAll("g")
				      .data(data)
				    .enter().append("g")
				      .attr("transform", function(d, i) { return "translate(0," + i * barHeight + ")"; });

				  bar.append("rect")
				      .attr("width", function(d) { return x(d.value); })
				      .attr("height", barHeight - 1);

				  bar.append("text")
				      .attr("x", function(d) { return x(d.value) - 3; })
				      .attr("y", barHeight / 2)
				      .attr("dy", ".35em")
				      .text(function(d) { return d.value; });

				function type(d) {
				  d.value = +d.value; // coerce to number
				  return d;
				}
}
