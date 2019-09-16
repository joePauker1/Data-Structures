<!DOCTYPE html>
<html>
<body>
<?php
echo "<HTML>";

echo "<a href='logout.php'>User Logout</a><br>";

if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$IPv4 = explode(".",$ip);
    echo "<br>Your IP: $ip<br>";
if($IPv4[0] == 10){
    echo "You are from Kean University<br>";
}
elseif($IPv4[0] == 131 && $IPv4[1] == 125) {
    echo "You are from Kean University<br>";
}
else {
    echo "You are NOT from Kean University<br>";
}

include "dbconfig.php";
$con = new mysqli($server, $login, $password, $dbname) or die("<br>Cannot connect to Database");
$cookie_n = "name";
$login = strtolower($_POST["login"]);
$password = ($_POST["password"]);

#password check
$result = mysqli_query($con,"SELECT name,id,dob,street,city,zipcode,state FROM Customers WHERE (login='$login') and (password='$password')");
$passcheck = mysqli_num_rows($result);
$result2 = mysqli_query($con, "SELECT * FROM Customers WHERE Login='$login'");
$passcheck2 = mysqli_num_rows($result2);
#if either field is left blank
if ($_POST['login']=='' or $_POST['password']=='') {
    echo "<br>One or more required fields were left blank. Please fill them in and try again.";
        mysqli_close($con);
}
#if user does not exist in database
else if($passcheck2 == 0) {
    echo "<br>Login  " . "'" . $_POST['login'] . "'" . " doesn't exist in the database";
        mysqli_close($con);
}
#if user exist but password was does not match.
else if($_POST['login'] == $passcheck and $_POST['password'] != $passcheck) {
    echo "<br>Login " . "'" . $_POST['login'] . "'" . " exists, but password does not match";
        mysqli_close($con);
                }
else
 #If password and login correct, run   
if($result){
        if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                   $cookie_id = $row['id'];
                   setcookie($cookie_n, $cookie_id, time() + (3600), "/");
                   $id=$row['id'];
                   $DOB=$row['dob'];
                   $name=$row['name'];
                   $street=$row['street'];
                   $city=$row['city'];
                   $state=$row['state'];
                   $zipcode=$row['zipcode'];
                   $age= floor((time() - strtotime($row['dob'])) / 31556926);
                        echo "<br>Welcome: $name<br>"; 
                        echo "Age: $age <br>";
                        echo "Address: $street, $city, $state, $zipcode<hr/>";
                    }               
#Customer's transaction table and sum
$sum = mysqli_query($con,"SELECT sum(amount) as sum FROM CPS3740_2019S.Money_paukerj WHERE cid=$id");
$check = mysqli_query($con, "SELECT mid,code,cid,sid,type,amount,mydatetime,note FROM CPS3740_2019S.Money_paukerj WHERE cid=$id");
echo "The transactions for customer " . $row['name'] . " are: Savings account";
if($check) {
    if(mysqli_num_rows($check)>0) {
        echo "<TABLE border=1>";
        echo "<TR><TH>ID<TH>Code<TH>Operation<TH>Amount<TH>Date / Time<TH>Note";

        while($row = mysqli_fetch_array($check)){
            $mid=$row['mid'];
            $code=$row['code'];
            $type = $row['type'];
            $amount=$row['amount'];
            $mydatetime=$row['mydatetime'];
            $note=$row['note'];
                    #Checking whether transaction was withdraw or deposit
                if($type == 'W'){
                    echo "<TR><TD>$mid<TD>$code<TD>Withdraw<TD><font color='red'>$amount</font><TD>$mydatetime<TD>$note";
                }
                else{
                    echo "<TR><TD>$mid<TD>$code<TD>Deposit<TD><font color ='blue'>$amount</font><TD>$mydatetime<TD>$note";
                }

        }
        echo "</TABLE>";
        $add = $sum->fetch_assoc();
        echo "Total Amount: <strong>" . $add['sum'] . "</strong>";

}
    #If no entries recorded, show message.
    else{
        echo "<br>There are no entries in your bank account";
        mysqli_free_result($check);
    }
}
    mysqli_close($con); 
    }
}
?>

    <br><br><TABLE border=0>
    <TR><TD><form action='add_transaction.php' method='POST'>
    <input type='hidden' name='customer_n' value='<?php echo "$name"?>'>
    <input type='submit' value='Add transaction'></form>
    <TD><a href='display_update_transaction.php'>Display and update transaction</a>
    <TR><TD colspan=2>
    <form name="form" action="search.php" method="get">
    Keyword: <input type="text" name="keyword" required="required">
    <input type="submit" value="Search transaction"></form>
    </TABLE></HTML>

</body>
</html>