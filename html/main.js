function ClearFields() {

  document.getElementById("exercise").value = "";
  document.getElementById("weight").value = "";
  document.getElementById("sets").value = "";
  document.getElementById("reps").value = "";
}

function getWorkout() {
    selectElement = document.querySelector('workoutType');
    output = selectElement.value;
    document.querySelector('.output').textContent = output;
}
