<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php
    $servername = "localhost";
    $usernameData = "id14882043_ltaque01";
    $passwordData = "WilliamLeonKateriJulia4!";
    $database = "id14882043_itet";
    // Create connection
    $conn = new mysqli($servername, $usernameData, $passwordData, $database);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully";

    // Add trip
    // foreach($_POST as $key=>$value){
    // echo $key.' '.$value."\n";
    // }

    // Have username and password

    // prepare and bind
    //extract($_POST)
    $trip = $_SESSION["tripID"];


    $sql = "DELETE FROM trips WHERE ID = $trip";

    $conn->query($sql);

    $sql = "DELETE FROM expenses WHERE tripID = $trip";

    $conn->query($sql);

      echo "<meta http-equiv='refresh' content='0;URL=http://aboutlct.000webhostapp.com/Final/dashboard.php' />";

    $conn->close();
    ?>
    <title></title>
  </head>
  <body>



  </body>
</html>
