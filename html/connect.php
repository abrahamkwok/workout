<?php
    $exercise = $_POST['exercise'];
    $weight = $_POST['weight'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];

    //$conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        echo "failed";
        die('Connection Failed:  '.$conn->connect_error);   
    } else {
        $stmt = $conn -> prepare("insert into registration(exercise, weight, sets, reps)
        values(?, ?, ?, ?)");
        $stmt->bind_param("siii", $exercise, $weight, $sets, $reps);
        $stmt->execute();
        echo "registration successful";
        $stmt->close();
        $conn->close();
    }