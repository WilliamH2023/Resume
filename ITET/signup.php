<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>New User Sign Up</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="Stylesheet.css">
<style>
    input {
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
$sql = "SELECT DISTINCT codes FROM codes ORDER BY codes";
$result = $conn->query($sql);
?>
</head>
<body>
<header><a class="header" href="login.html">International Travel Expense
    Tracker</a></header>

<nav>
    <ul>
        <div class="leftnav">
            <li><a href = "about.html">About</a></li>
            <div class="rightnav">
                <li><a href = "signup.html" class= "currpage">
                    <span class="glyphicon glyphicon-user"></span> Sign Up</a>
                </li>
                <li><a href = "login.html">
                    <span class="glyphicon glyphicon-log-in"></span> Login</a>
                </li>
            </div>
        </div>
    </ul>
</nav>
<div class="logcontainer">
    <div class="login">
        <h1>Sign Up</h1>
        <h3>Please fill in all fields below:<br></h3>
        <form method="post" action="signup-validation.php" >
            <br>
            Username*: <input type="text" name="username" value=""/><br><br>
            Password*: <input type="Password" name="password" value=""/><br><br>
            Name*: <input type="text" name="name" value=""/><br><br>
            Home Currency: <select name = "hcurrency" size = '1'>
            <?php
            foreach($result as $row) {
                if ($row['codes'] == 'USD')
                  echo "<option value = '" . $row['codes'] . "' selected>" .
                      $row['codes'] . " </option>";
                else
                  echo "<option value = '" . $row['codes'] . "'>" .
                    $row['codes'] . " </option>";
            }
            ?>
            </select><br><br>
            <input type="submit" value="Sign Up"/>
        </form>
    </div>
</div>

<footer>ITET</footer>
</body>
