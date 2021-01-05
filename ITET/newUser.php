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
echo "Connected successfully";

// Add User
extract ($_POST);
$sql = "INSERT INTO users (username, name, HomeCurrency, password)" .
    "VALUES ('$username', '$name', '$hcurrency', '$password')";
?>
