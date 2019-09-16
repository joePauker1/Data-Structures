<!DOCTYPE html>
<html>
<body>
<?php
	
$cookie_n = "name";
	if(!isset($_COOKIE['name'])){
		echo "Please login in first<br>";
		echo "<a href='cps3740_p2.html'>Login page</a>";
	}
else {
		echo "<a href = 'logout.php'>Logout</a><br>";
		echo "<br><font size=4><b>Add Transaction</b></font>";
$id = $_COOKIE['name'];
include "dbconfig.php";
$user = $_POST['customer_n'];
$con = mysqli_connect($server, $login, $password, $dbname) or die("<br>Cannot connect to Database");
$sum = mysqli_query($con,"SELECT sum(amount) as sum FROM CPS3740_2019S.Money_paukerj WHERE cid=$id");
       if(mysqli_num_rows($sum)>0){
                while($row = mysqli_fetch_array($sum)){
  						$add = $row['sum'];
                }
                echo " <br><strong>$user</strong> Current Balance: <strong>$add</strong><br>";
            }
           


echo "<form name='input' action='insert_transaction.php' method='post' required='required'>";
echo "<input type='hidden' name='customer_n' value=$name>";
echo "Transaction code: <input type='text' name='code' required='required'>";
echo "<br><input type='radio' name='type' value='D'>Deposit";
echo "<input type='radio' name='type' value='W'3>Withdraw";
echo "<br> Amount: <input type='text' name='money' required='required'>";
echo "<input type='hidden' name='sum' value='$add'>";
echo "<br> Select a Source: <select name='src'>";
echo "<option value=''</option>";

        $dlist=mysqli_query($con,"SELECT * FROM Sources");
        while($row=mysqli_fetch_array($dlist)){
        	$id = $row['id'];
        	$s_name = $row['name'];
    echo  "<option value=$id>$s_name</option>";
            }
echo "</SELECT>";
echo "<BR>Note: <input type='text' name='note'><br>";
echo "<input type='submit' value='Submit'>";
}
	mysqli_close($con);
	?>

</form>
</HTML>