let workoutName = "";

function ClearFields() {

  document.getElementById("exercise").value = "";
  document.getElementById("weight").value = "";
  document.getElementById("sets").value = "";
  document.getElementById("reps").value = "";
}

function changeName() {
  var sel = document.getElementById("workoutType");
  workoutName = sel.options[sel.selectedIndex].value;
}

function getCurrName() {
  return workoutName;
}