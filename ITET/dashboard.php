<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
        h1 {
            text-align: center;
            font-family: Times New Roman;
            font-variant: small-caps;
            font-size: 50px;
            padding-bottom: 10px;
            color: black;
        }
        .bod{
            width: 70%;
            margin: 0 auto;
            /*background-color: #EAEFFA;*/
        }
        table{
            width:70%;
            margin: 0 auto;
        }

        tr{
            padding: 10px 10px;
        }
        td {
                padding-bottom: 20px;
                padding-right: 10px;
                padding-left: 10px;
        }

        input{
            font-family: Times New Roman;
            font-variant: none;
        }
        button {
            width: 100%;
            text-align: center;
            margin: 0 auto;
            padding: 5px 5px;
            font-size: 20px;
            font-family: Times New Roman;
            font-variant: small-caps;
            border-radius: 15px;
            border-width: 5px;
            border-color: #4380FE;


        }
        button:hover {
                background-color: #4380FE;
                color: white;
        }
        .lbutton {
            margin: 0 auto;
            width: 100%;
            background-color: black;
            color: #00508F;
            border: 2px solid black;
            padding: 20px 20px;
            border-radius: 15px;
            border-width: 5px;
            border-color: #4380FE;
            font-family: Times New Roman;
            font-variant: small-caps;
            font-size: 18px;

            color: white;
        }
        .lbutton:hover{
            background-color: #4380FE;
        }

        #addTripForm {
            display: none;
            margin: 0 auto;
            padding-left: 40px;

        }
        #addtripbuttonsubmit {
                margin: 0 auto;
            padding: 5px 5px;
            font-size: 18px;
            font-family: Times New Roman;
            font-variant: small-caps;
            border-radius: 15px;
            border-width: 5px;
            border-color: #4380FE;
        }

        label{
                font-family: Times New Roman;
                font-variant: small-caps;
                font-size: 15px;
        }
    </style>

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

    ?>

    <script type="text/javascript">
        function AddTripShow() {
            document.getElementById("addTripForm").style.display='block';
            document.getElementById("addtripbutton").style.display='none';
        }
    </script>

</head>
<body>

    <header><a class="header" href="dashboard.php">International Travel Expense Tracker</a></header>

    <nav>
        <ul>
            <div class="leftnav">
                <li><a href = "aboutdash.html">About</a></li>
                <li><a href = "dashboard.php" class="currpage">Dashboard</a></li>
                <div class="rightnav">

                    <!-- END SESSION IF CLICKED -->
                    <li><a href = "logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a> </li>

                </div>
            </div>
        </ul>
    </nav>

    <div class="bod">

    <h1>My Dashboard</h1>


    <?php
        $count = 0;
        $userID = $_SESSION["userID"];
        $sql = "SELECT * FROM trips WHERE userID = '$userID'";
        $result = $conn->query($sql);
        print "<table>";
        foreach($result as $row){
            if ($count % 2 == 0) {
                print "<tr><td align='center'>";
                print "<form action='http://aboutlct.000webhostapp.com/Final/trip.php' method='post'>
                  <input type = 'hidden' name = 'tripid' value ='". $row['ID']."'>
              <input type='submit' class='lbutton' name='tripname' value='" . $row['tripname'];
                print "'/> </form></td>";
            }
            else {
                print "<td align='center'>";
                print "<form action='http://aboutlct.000webhostapp.com/Final/trip.php' method='post'>
                  <input type = 'hidden' name = 'tripid' value ='". $row['ID']."'>
              <input type='submit' class='lbutton' name='tripname' value='" . $row['tripname'];
                print "'/> </form></td></tr>";
            }
            // print "<td>";
            // print $row['tripname'];
            // //SHOW ALL FIELDS
            // // for ($row as $name=>$value){
            // //     print " <td>$value</td>";
            // // } // end field loop
            // print " </td></tr>";
            $count += 1;
        } // end record loop
        if ($count % 2 ==0) {
            print "</tr>";
        }
        print "</table>";


        //UPDATE PAGE ON ADDITION//
    ?>

    <?php
      $sql = "SELECT DISTINCT codes FROM codes ORDER BY codes";
      $result = $conn->query($sql);
     ?>

    <br><br>

        <button type="button" id="addtripbutton" onclick="AddTripShow()">Add Trip</button>
        <div id="addTripForm">
        <form method="post" action="newTrip.php">
            <label>Trip Name:&nbsp</label><input type="text" name="tripName" required />
            &nbsp &nbsp &nbsp
            <label>Default Currency:&nbsp</label>
            <select name = "defaultCurrency" size = '1'>
                            <?php
                            foreach($result as $row){
                                if ($row['codes'] == 'USD')
                                  echo "<option value = '".$row['codes']."' selected>". $row['codes'] ." </option>";
                                else
                                  echo "<option value = '".$row['codes']."' >". $row['codes'] ."</option>";
                            }
                            ?>
                            </select><br><br>

            &nbsp &nbsp &nbsp
            <input type="submit" value="Add" id="addtripbuttonsubmit" />
        </form>
    </div>
    <br><br>
    </div>
    <br><br>
    <br><br>


    <footer>ITET</footer>


</body>
</html>
