<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheet.css">
    <style>
        input{
            font-family: Times New Roman;
            font-variant: none;
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
        $sql = "SELECT DISTINCT codes FROM codes";
        $result = $conn->query($sql);
        ?>


</head>
<body>
    <header><a class="header" href="login.html">International Travel Expense Tracker</a></header>

    <nav>
        <ul>
            <div class="leftnav">
                <li><a href = "about.html">About</a></li>
                <div class="rightnav">
                    <li><a href = "signup.html"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href = "login.html" class= "currpage"><span class="glyphicon glyphicon-log-in"></span> Login</a> </li>
                </div>
            </div>
        </ul>
    </nav>
    <div class="logcontainer">
        <div class="login">
            <h1>Login</h1>
            <form method="post" action="login-validation.php">
                Username: <input type="text" name="username" value=""><br><br>
                Password: <input type="Password" name="password" value=""><br><br>
                Currency: <select name = "currency" size = '1'>
                          <?php
                          foreach($result as $row){
                              echo "<option>". $row['codes'] ."</option>";
                              }
                          ?>
                        </select><br><br>
                <input type="submit" value="Login"/>
            </form>

        </div>
    </div>


    <footer>ITET</footer>


</body>
