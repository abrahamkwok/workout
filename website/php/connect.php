<?php
    $exercise = $_POST['exercise'];
    $weight = $_POST['weight'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $date = $_POST['date'];

    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "Workout";
    $conn = "";

    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

    if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into workouts(exercise, weight, sets, reps, date) values(?, ?, ?, ?, ?)");
		$stmt->bind_param("siiis", $exercise, $weight, $sets, $reps, $date);
		$execval = $stmt->execute();
		echo $execval;
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
		$stmt->close();
		$conn->close();
	}
?>