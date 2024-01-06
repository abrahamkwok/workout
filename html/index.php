<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="HTML, CSS" />
    <meta name="description" content="..." />
    <title>Abraham Kwok</title>
    <link rel="stylesheet" type="text/css" href="current.css" />
    <script src="main.js"></script>
  </head>

  <body>
    <div id="toolbar">
      <div id="about_me">
          <a href="about.php">About Me</a>
      </div>
    </div>
  
    <div class="movement_buttons">
      <h1 id="main_title">My Workout Log</h1>
    </div>

    <div class = "submission">
      <form id="UpdateWorkout" action="connect.php" method="post">
        <label for="exercise">Exercise</label><br />
        <select id="exercise" name="exercise">
          <option value="Squat" name="exercise">Squat</option>
          <option value="Dumbbell Bench" name="exercise">Dumbbell Bench</option>
          <option value="Weighted Pull Ups" name="exercise">
            Weighted Pull Ups
          </option>
        </select>
        <br />

        <label for="date">Date</label><br />
        <input type="date" id="date" name="date" /><br />

        <label for="weight">Weight</label><br />
        <input type="text" id="weight" name="weight" /><br />

        <label for="sets">Sets</label><br />
        <input type="text" id="sets" name="sets" /><br />

        <label for="reps">Reps</label><br />
        <input type="text" id="reps" name="reps" /><br />

        <input type="submit" name="send" id="send" />
      </form>
    </div>

    <div class = "menu">
      <div class = "exerciseType">
        <form action="index.php" method="post">
          <label for="selectOption">Select A Graph To Look At:</label>
          <select id="workoutType" name = "workoutType" onchange="changeName()">
            <option value="'Squat'" selected = "selected">Squat</option>
            <option value="'Dumbbell Bench'">Dumbbell Bench</option>
            <option value="'Weighted Pull Ups'">Weighted Pull Ups</option>
          </select>
          <input type="submit" value="Submit">
        </form>
      </div>
    </div>

    <div class = "content">
      
      <div id = "graph" class = "data">
        <div id = "sqlqueries">
          <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
              // Check if the selectedOption is set in the POST data
              if (isset($_POST["workoutType"])) {
                $exercise = $_POST["workoutType"];
              }
            }
            
            $link = mysqli_connect("localhost", "root", "");
            mysqli_select_db($link, "Workout");

            $weightQ = array();
            $count = 0;
            $res = mysqli_query($link, "SELECT * FROM workouts WHERE exercise = $exercise");
            while ($row = mysqli_fetch_array($res))
            {
              $weightQ[$count]["label"] = $row["date"];
              $weightQ[$count]["y"] = $row["weight"];
              $count = $count + 1;
            }

            $repQ = array();
            $count = 0;
            $res = mysqli_query($link, "SELECT * FROM workouts WHERE exercise = $exercise");
            while ($row = mysqli_fetch_array($res))
            {
              $repQ[$count]["label"] = $row["date"];
              $repQ[$count]["y"] = $row["reps"];
              $count = $count + 1;
            }

            $setsQ = array();
            $count = 0;
            $res = mysqli_query($link, "SELECT * FROM workouts WHERE exercise = $exercise");
            while ($row = mysqli_fetch_array($res))
            {
              $setsQ[$count]["label"] = $row["date"];
              $setsQ[$count]["y"] = $row["sets"];
              $count = $count + 1;
            }

            $totalQ = array();
            $count = 0;
            $res = mysqli_query($link, "SELECT * FROM workouts WHERE exercise = $exercise");
            while ($row = mysqli_fetch_array($res))
            {
              $totalQ[$count]["label"] = $row["date"];
              $currTotal = $row["reps"] * $row["sets"] * $row["weight"];
              $totalQ[$count]["y"] = (string) $currTotal;
              $count = $count + 1;
            }
          ?>
        </div>
        <script>
          window.onload = function () {
          
          let curr = <?php echo json_encode($_POST['workoutType']); ?>.replace(/'/g, "");
          var chart1 = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            backgroundColor: "transparent",
            exportEnabled: false,
            menu: { enabled: false }, // Disable the menu
            title:{
              fontColor: "white",
              text: curr + " Weight"
            },
            axisX:{
              labelAutoFit: true,
              labelFontColor: "white"
            },
            axisY:{
              includeZero: true,
              labelFontColor: "white"
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              indexLabelFontColor: "#FFFFFF",
              indexLabelPlacement: "outside",   
              dataPoints: <?php echo json_encode($weightQ, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart1.render();
          
          var chart2 = new CanvasJS.Chart("chartContainer2", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            backgroundColor: "transparent",
            exportEnabled: false,
            menu: { enabled: false }, // Disable the menu
            title:{
              text: curr + " Reps",
              fontColor: "white"
            },
            axisX:{
              labelAutoFit: true,
              labelFontColor: "white"
            },
            axisY:{
              includeZero: true,
              labelFontColor: "white"
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              indexLabelFontColor: "#FFFFFF",
              indexLabelPlacement: "outside",   
              dataPoints: <?php echo json_encode($repQ, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart2.render();

          var chart3 = new CanvasJS.Chart("chartContainer3", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            backgroundColor: "transparent",
            exportEnabled: false,
            menu: { enabled: false }, // Disable the menu
            title:{
              text: curr + " Sets",
              fontColor: "white"
            },
            axisX:{
              labelAutoFit: true,
              labelFontColor: "white"
            },
            axisY:{
              includeZero: true,
              labelFontColor: "white"
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              indexLabelFontColor: "#FFFFFF",
              indexLabelPlacement: "outside",   
              dataPoints: <?php echo json_encode($setsQ, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart3.render();

          var chart4 = new CanvasJS.Chart("chartContainer4", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            backgroundColor: "transparent",
            exportEnabled: false,
            menu: { enabled: false }, // Disable the menu
            title:{
              text: curr + " Total Weight",
              fontColor: "white"
            },
            axisX:{
              labelAutoFit: true,
              labelFontColor: "white"
            },
            axisY:{
              includeZero: true,
              labelFontColor: "white"
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              indexLabelFontColor: "#FFFFFF",
              indexLabelPlacement: "outside",   
              dataPoints: <?php echo json_encode($totalQ, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart4.render();
          }
        </script>
        <div>
          <body>
            <div id="chartContainer1" class = "chartContainer" style="height: 300px; width: 49.857%; display: inline-block;"></div>
            <div id="chartContainer2" class = "chartContainer" style="height: 300px; width: 49.857%; display: inline-block;"></div><br/>
            <div id="chartContainer3" class = "chartContainer" style="height: 300px; width: 49.857%; display: inline-block;"></div>
            <div id="chartContainer4" class = "chartContainer" style="height: 300px; width: 49.857%; display: inline-block;"></div>
            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
          </body>
        </div>
      
        </div>
    </div>
  </body>
</html>
