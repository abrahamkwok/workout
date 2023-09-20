function ClearFields() {

  document.getElementById("exercise").value = "";
  document.getElementById("weight").value = "";
  document.getElementById("sets").value = "";
  document.getElementById("reps").value = "";
}

function getWorkout() {
  var e = document.getElementById("workoutType");
  var value = e.value;
  console.log(value);
}
