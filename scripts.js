// Get the modal
var modal = document.getElementById('taskModal');

// Get the button that opens the modal
var btn = document.getElementById("CreateTaskBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

var cancel = document.getElementById("cancelbtn");

// When the user clicks on cancel, close the modal
cancel.onclick = function() {
    modal.style.display = "none";
}