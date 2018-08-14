
// open the modal by model id passed with the button

function OpenModal(id) {
	document.getElementById(id).style.display = "block";
}


// close the modal by model id passed with the button
function CloseModal(id) {
	document.getElementById(id).style.display = "none";
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

