<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
     <script>
            window.onload = function(){
                document.forms[0].submit();
            }
    </script>
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
    $tripname = $_SESSION["tripname"];
    $local_currency = $_SESSION["default_currency"];
    $expenseID = $_POST["expenseID"];


    $sql = "DELETE FROM expenses WHERE ID = $expenseID";

    $conn->query($sql);


      // $msg = "<h1> Expense logged... Adding to Trip Page </h1>";
      $form = "<form method = 'post' action = 'trip.php'> <input type = 'hidden' name = 'tripid' value = $trip >
      <input type = 'hidden' name = 'tripname' value = '$tripname' >
      </form>";


    $conn->close();
    ?>
    <title></title>
  </head>
  <body>
    <?php
        //echo $msg;
        echo $form;
     ?>


  </body>
</html>
