<?php 
    session_start();
    session_destroy(); 
    $msg = "<h1> Successful Log Out... Forwarding to Login Page </h1>";
    echo "<meta http-equiv='refresh' content='2;URL=http://aboutlct.000webhostapp.com/Final/login.html' />";
?>

<html>
<body>
    <?php 
        echo $msg;
    ?>
</body>

</html>