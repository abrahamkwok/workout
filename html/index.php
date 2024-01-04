<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="HTML, CSS" />
    <meta name="description" content="..." />
    <title>Abraham Kwok</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
  </head>

  <body>
    <div class="movement_buttons">
      <h1 id="main_title">My Workout Log</h1>
      <a href="#Goals">Current Goals</a>
      <a href="#Recording">Record Workout</a>
      <a href="#Progress">Progress</a>
    </div>

    <div>
      <h2 class="Goals">Current Goals</h2>
      <p>
        <li>Dunk A Ball</li>
        <li>Hit Plate On Overhead Press</li>
        <li>Hit Plate On Weighted Pull Ups</li>
        <li>Hit Plate On Weighted Dips</li>
      </p>
    </div>

    <div>
      <form id="UpdateWorkout" action="connect.php" method="post">
        <label for="exercise">Exercise</label><br />
        <select id="exercise" name="exercise">
          <option value="squat" name="exercise">Squat</option>
          <option value="dumbbell_bench" name="exercise">Dumbbell Bench</option>
          <option value="weighted_pullups" name="exercise">
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
          <select id="workoutType" name = "workoutType">
            <option value="'squat'" selected = "selected">Squat</option>
            <option value="'dumbbell_bench'">Dumbbell Bench</option>
            <option value="'weighted_pullups'">Weighted Pull Ups</option>
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
          
          let temp = document.getElementById("workoutType");
          var chart1 = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            backgroundColor: "transparent",
            exportEnabled: false,
            menu: { enabled: false }, // Disable the menu
            title:{
              text: temp.value,
              fontColor: "white"
            },
            axisX:{
              labelAutoFit: true
            },
            axisY:{
              includeZero: true
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              //indexLabel: "{y}", //Shows y value on all Data Points
              indexLabelFontColor: "#5A5757",
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
              text: temp.options[temp.selectedIndex].text,
              fontColor: "white"
            },
            axisX:{
              labelAutoFit: true
            },
            axisY:{
              includeZero: true
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              //indexLabel: "{y}", //Shows y value on all Data Points
              indexLabelFontColor: "#5A5757",
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
              text: temp.options[temp.selectedIndex].text,
              fontColor: "white"
            },
            axisX:{
              labelAutoFit: true
            },
            axisY:{
              includeZero: true
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              //indexLabel: "{y}", //Shows y value on all Data Points
              indexLabelFontColor: "#5A5757",
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
              text: temp.options[temp.selectedIndex].text,
              fontColor: "white"
            },
            axisX:{
              labelAutoFit: true
            },
            axisY:{
              includeZero: true
            },
            data: [{
              type: "line", //change type to bar, line, area, pie, etc
              //indexLabel: "{y}", //Shows y value on all Data Points
              indexLabelFontColor: "#5A5757",
              indexLabelPlacement: "outside",   
              dataPoints: <?php echo json_encode($totalQ, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart4.render();
          }
        </script>
        <div>
          <body>
            <div id="chartContainer1" style="height: 300px; width: 49.857%; display: inline-block;"></div>
            <div id="chartContainer2" style="height: 300px; width: 49.857%; display: inline-block;"></div><br/>
            <div id="chartContainer3" style="height: 300px; width: 49.857%; display: inline-block;"></div>
            <div id="chartContainer4" style="height: 300px; width: 49.857%; display: inline-block;"></div>
            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
          </body>
        </div>
      
        </div>
    </div>
    
    <!-- <div id="graphs">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <script>

        $(document).ready(function() {
          $("#workoutType").on('change', function() {
            $(".data").hide();
            $("#" + $(this).val()).fadeIn(700);
          }).change();
        })
      </script>
    </div> -->

    <div>
      <h2 class="Progress">Progress</h2>
    </div>

    <a href="company/about.html">About Me</a>
    <a href="images/spiderman.jpg">My photo</a>
    <a href="#section-css">css</a>
    <a href="https://google.com" target="_blank">Google</a>
    <a href="mailto:abrahamkwok628@gmail.com">Email Me</a>
    <p class="htmlpara">
      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quis mollitia a
    </p>
    <img src="images/spiderman.jpg" alt="yes" />
    <h2 id="section-css">css</h2>
    <a href="#">Jump to top</a>
    <script src="main.js"></script>
  </body>
</html>
