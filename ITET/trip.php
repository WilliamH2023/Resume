<?php
// Start the session
session_start();
//From Dashboard
extract($_POST);
$loginID = $_SESSION["userID"];
$homeCurrency = $_SESSION["HomeCurrency"];
$_SESSION["tripID"] = $tripid;
$_SESSION["tripname"] = $tripname;
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link rel="stylesheet" href="Stylesheet.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"
integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
crossorigin="anonymous">
</script>
<title>Trip Detail</title>
<style>
    h1 {
        text-align: center;
        font-family: Times New Roman;
        font-variant: small-caps;
        font-size: 50px;
        padding-bottom: 10px;
        color: black;
        }
    .bod {
        width: 70%;
        margin: 0 auto;
    }
    table {
        width:100%;
        margin: 0 auto;
        border: 3px solid black;
        padding: 10px 10px;
    }
    th {
      border: 1px solid black;
      text-align: center;
      padding:3px 3px;
      font-family: Times New Roman;
      font-variant: small-caps;
      font-size: 18px;
    }
    tr {
        padding: 10px 10px;
        border: 1px solid black;
        text-align: center;
    }
    td {
        padding-bottom: 10px;
        padding-right: 10px;
        padding-left: 10px;
        border: 1px solid black;
        text-align:center;
        vertical-align: center;
    }
    input {
        font-family: Times New Roman;
        font-variant: none;
    }
    button, .button {
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
    button:hover, .button:hover {
        background-color: #4380FE;
        color: white;
    }
    label {
        font-family: Times New Roman;
        font-variant: small-caps;
        font-size: 15px;
    }
    .total {
        font-size: 20px;
    }
    .totaldiv {
        border: 3px solid black;
        width: 100%;
        padding: 5px 5px 5px 5px;
        text-align: center;
    }
    .deletebutton {
        margin: 0 auto;
        padding: 5px 30px;
        margin-bottom: 5px;
        margin-top: 10px;
        border-radius: 15px;
        background-color: red;
    }
    #deleteTrip{
        background-color: red;
        color: black;
        font-family: Times New Roman;
        font-variant: small-caps;
        font-size: 15px;
        border-radius: 15px;
        border-width: 3px;
        padding: 5px 5px;
        width:40%;
        margin: 0 auto;
        text-align:center;
    }

    #back {
        font-size:15px;
        width:130px;
    }
    #backlink {
        text-decoration: none;
        text-align: center;
        color: black;
        display: inline-block;
        padding-right: 40px;
        padding-left:40px;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    #backlink:hover {
        color:white;
    }
    #addExpenseForm {
        display: none;
        margin: 0 auto;
        padding-left:40px;
    }
    #addexpensebuttonsubmit {
        margin: 0 auto;
        padding: 5px 5px;
        font-size: 18px;
        font-family: Times New Roman;
        font-variant: small-caps;
        border-radius: 15px;
        border-width: 5px;
        border-color: #4380FE;
    }
    .errMsg {
        color: #FF0000;
        border: solid 1px #d20e11;
        display: none;
        padding: 1px 15px;
    }
</style>
<script language="javascript">

function getDate()
{
    today = new Date();
    day = today.getDate();
    if (day < 10)
        day = "0" + day;
    month = today.getMonth() + 1;
    if (month < 10)
        month = "0" + month;
    fullDate = today.getFullYear() + "-" + month + "-" + day;
    return fullDate;
}

function checkDate(dateS)
{
    // Check that date entered is in valid format
    if (dateS.length != 10)
        return false;
    for (i = 0; i < 10; i++)
    {
        if (i == 4 || i == 7)
        {
            if (dateS[i] != "-")
                return false;
        }
        else if (isNaN(parseInt(dateS[i])))
            return false;
    }
    // Check that date is not in the future
    today = new Date();
    if (parseInt(dateS.substring(0,4)) > today.getFullYear())
        return false;
    else if (parseInt(dateS.substring(5,7)) > (today.getMonth()+1))
        return false;
    else if (parseInt(dateS.substring(8)) > today.getDate())
        return false;
    return true;
}

function checkAmount(amount)
{
    if (amount == "" || isNaN(parseInt(amount)))
        return false;
    else
        return true;
}

function validate()
{
    err = false;
    document.getElementById("errName").style.display = "none";
    document.getElementById("errAmount").style.display = "none";
    document.getElementById("errDate").style.display = "none";
    with (document.forms[0])
    {
        if (expenseName.value == "")
        {
            document.getElementById("errName").style.display = "inline-block";
            expenseName.focus();
            err = true;
        }
        if (!checkAmount(amountForeign.value))
        {
            document.getElementById("errAmount").style.display = "inline-block";
            amountForeign.focus();
            err = true;
        }
        if (!checkDate(expenseDate.value))
        {
            document.getElementById("errDate").style.display = "inline-block";
            expenseDate.focus();
            err = true;
        }
        return !err;
    }
    //return !err;
}

function useAPI(foreign, home, date, amount) {
    $("#amountForeign").val(parseFloat(amount).toFixed(2));
    request = new XMLHttpRequest();
    request.open("GET", "http://api.currencylayer.com/"
        + "historical?access_key=c89da602020150d12ed555a532a020eb&date=" + date
        + "&currencies=" + foreign + "," + home, true);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200)
        {
            parsed = JSON.parse(request.responseText);
            conversion = (amount / parsed.quotes["USD" +
               foreign]) * parsed.quotes["USD" + home];
            $("#amountHome").val(conversion.toFixed(2));
        }
    } // end of state change function
    request.send();
} // end of useAPI function

$(document).ready(function() {
    <?php
    echo "var home = '$homeCurrency';";
    ?>
    foreign = $("input[name^='foreignCurr']").val();
    $("#amountForeign").change(function() {
        if (checkDate($("#expenseDate").val()) && checkAmount($("#amountForeign").val()))
            useAPI(foreign, home, $("#expenseDate").val(), $("#amountForeign").val());
    });
    $("#expenseDate").change(function() {
        if (checkDate($("#expenseDate").val()) && checkAmount($("#amountForeign").val()))
            useAPI(foreign, home, $("#expenseDate").val(), $("#amountForeign").val());
    });
    $('#addexpense').click(function() {
        $("#addExpenseForm").slideToggle(500);
    });
}); // end of doc ready function
</script>
</head>

<body>
<header><a class="header" href="dashboard.php">International Travel Expense
    Tracker</a></header>
<nav>
	<ul>
		<div class="leftnav">
			<li><a href = "aboutdash.html">About</a></li>
			<li><a href = "dashboard.php">Dashboard</a></li>
			<div class="rightnav">
				<!-- END SESSION IF CLICKED -->
				<li><a href = "logout.php">
                    <span class="glyphicon glyphicon-log-out"></span> Logout</a>
                </li>
			</div>
		</div>
	</ul>
</nav>

<div class="bod">
    <br>
    <button id="back"><a href='dashboard.php' id="backlink">Back</a></button>
    <?php
    echo "<h1>$tripname</h1>";

    //for server page
    $servername = "localhost";
    $username = "id14882043_ltaque01";
    $password = "WilliamLeonKateriJulia4!";
    $dbname = "id14882043_itet";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT tripname, categories.name, expense_date, expense_name,
				cost_local, local_currency, default_currency, cost_home,
				tripID, local_currency, CategoryID, expenses.ID
			FROM expenses INNER JOIN categories INNER JOIN trips
			ON CategoryID = categories.ID AND tripID = trips.ID
			WHERE tripID = $tripid ORDER BY expense_date";
    $result = $conn->query($sql);

    echo "<table>
        <tr>
            <th> Date </th>
            <th> Name </th>
        	<th> Category </th>
          	<th> Local Cost </th>
        	<th> Home Cost </th>
            <th> Delete </th>
        </tr>";
    if (mysqli_num_rows($result) > 0) {
        $local = 0;
        $home = 0;

        while($row = $result->fetch_assoc()) {
            $eName = $row["expense_name"];
            echo "<tr> <td>" . $row["expense_date"] . "</td><td>" .
                $row["expense_name"] . "</td><td>" . $row["name"] .
                "</td><td>" . number_format($row["cost_local"],2) .
                $row["local_currency"] . "</td><td>" .
                number_format($row["cost_home"],2) . $homeCurrency .
                "</td><td><form method = 'post' action = 'delete-expense.php'" .
                "onsubmit = \"return confirm('Delete $eName?');\" ".
                "class='deleteform'><input type='submit'  value=''" .
                "class='deletebutton'><input type = 'hidden' name =" .
                "'expenseID' value =" . $row['ID']."></form></td></tr>";
            $local += $row["cost_local"];
            $home += $row["cost_home"];

        	$tripID = $row["tripID"];
        	$localCurrency = $row["local_currency"];
        }
        echo "</table>";
    }
    else {
    	$local = 0;
    	$home = 0;
        echo "</table>";
    }

    $sql = "SELECT DISTINCT name, ID FROM categories ORDER BY name";
    $result = $conn->query($sql);
    ?>
    <br>
    <div class="totaldiv">
        <label class="total">Total
            <?php echo "(" . $homeCurrency . "): " . number_format($home,2);
            ?>
        </label>
        <br>
    </div>
    <br>
    <button type="button" id="addexpense">Add Expense</button>
    <div id="addExpenseForm">
        <br>
        <form method="post" onsubmit="return validate()"
            action="expense-validation.php">
            <label>Expense Name: &nbsp</label><input type="text"
                id="expenseName" name="expenseN" value="">
            &nbsp &nbsp &nbsp
            <label>Amount in Foreign Currency: &nbsp</label>
            <input type="text" id="amountForeign" name="expenseForeign"
                value="">
            <br>
            <div id="errName" class="errMsg">Please enter an expense name.</div>
            &nbsp &nbsp &nbsp
            <div id="errAmount" class="errMsg">Please enter a numerical expense
                amount.</div>
            <br>
            <label>Category: &nbsp</label>
            <select name = "categoryID" size = '1'>
            <?php
            foreach($result as $row) {
                if ($row['ID'] == 5)
                  echo "<option value = ".$row['ID'] . " selected>" .
                      $row['name'] . " </option>";
                else
                  echo "<option value = ".$row['ID'].">". $row['name'] .
                      " </option>";
            }
    	    ?>
            </select>
            <div id="errType" class="errMsg">Please enter an expense type.</div>
            &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
            &nbsp
            <label>Amount in Home Currency: &nbsp</label>
            <input type="text" id="amountHome" name="expenseHome">
            <?php
                $sql = "SELECT default_currency FROM trips WHERE ID = $tripid";
                $result = $conn->query($sql);
                foreach($result as $row) {
                    echo "<input type='hidden' value = '" .
                        $row['default_currency'] . "' name = 'foreignCurr'>";
                    $_SESSION["default_currency"] = $row['default_currency'];
                }
                $conn->close();
            ?>
            <br><br>
            <script type="text/javascript">
                code = "<label>Date: &nbsp</label><input type='text'" +
                    "id='expenseDate'name='date'value='" + getDate() + "'>";
                document.writeln(code);
            </script>
            <div id="errDate" class="errMsg">Please enter a valid date in the
                form "YYYY-MM-DD".</div>
            <br><br>
            <input type="submit" id="addexpensebuttonsubmit"
                value="Submit Expense">
        </form>
    </div>
    <br><br><hr>
    <form method = 'post' action = 'delete-trip.php' onsubmit = "return confirm('Delete this trip?');" class='deleteTrip'>
        <input type=submit id='deleteTrip' value="Delete Trip">
    </form>
</div>
<br><br><br>

<footer>ITET</footer>
</body>
</html>
