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

// Add trip
extract ($_POST);

// Have username password
$sql = "SELECT ID FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $msg = "<h1> Username is taken... Sending back to Sign Up Page </h1>";
    echo "<meta http-equiv='refresh'" .
        "content='2;URL=http://aboutlct.000webhostapp.com/Final/signup.php'/>";
}
else {
    $sql = "INSERT INTO users (username, HomeCurrency, password, name)" .
        "VALUES ('$username', '$hcurrency', '$password' ,'$name')";
    $conn->query($sql);
    $sql = "SELECT ID FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    $msg = "<h1> Successful Created Account... Forwarding to Trip Page </h1>";
    echo "<meta http-equiv='refresh' content='2;" .
        "URL=http://aboutlct.000webhostapp.com/Final/dashboard.php' />";
    $userID = $result->fetch_row()[0];
    $_SESSION["HomeCurrency"] = $hcurrency;
    $_SESSION["userID"] = $userID;
}
$conn->close();
?>
<title>Loading...</title>
</head>

<body>
<?php
    echo $msg;
?>
</body>
</html>
