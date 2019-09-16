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
$id = $_COOKIE['name'];

include "dbconfig.php";
$connect = mysqli_connect($server, $login, $password, $dbname) or die("<br>Cannot connect to Database");

#Customer's transaction table and sum
$sum = mysqli_query($connect,"SELECT sum(amount) as sum FROM CPS3740_2019S.Money_paukerj WHERE cid=$id");
$check = mysqli_query($connect, "SELECT mid,code,cid,sid,type,amount,mydatetime,note FROM CPS3740_2019S.Money_paukerj WHERE cid=$id");
echo "You can only update <b>Note</b> column";
if($check) {
    if(mysqli_num_rows($check)>0) {
        echo "<TABLE border=1>";
        echo "<TR><TH>ID<TH>Code<TH>Operation<TH>Amount<TH>Date / Time<TH>Note<TH>Delete";

        while($row = mysqli_fetch_array($check)){
            $mid=$row['mid'];
            $code=$row['code'];
            $type = $row['type'];
            $amount=$row['amount'];
            $mydatetime=$row['mydatetime'];
            $note=$row['note'];
                    #Checking whether transaction was withdraw or deposit
            echo "<form action='update_transaction.php' method='post'>";
                if($type == 'W'){
                    //echo "<form action='update_transaction.php' method='post'>";
                    echo "<TR>
                    <TD>$mid
                    <input type='hidden' name='main_id[]' value='$mid'>
                    <TD>$code
                    <TD>Withdraw<TD><font color='red'>$amount</font>
                    <TD>$mydatetime
                    <TD bgcolor='yellow'>
                    <input type='text' name='update_n[]' value='$note' style='background-color:yellow;'>
                    <TD>
                    <input type='checkbox' name='checked[]' value='$mid'>
                    </td>";
                }
                else{
                    //echo "<form action='update_transaction.php' method='post'>";
                    echo "<TR>
                    <TD>$mid
                    <input type='hidden' name='main_id[]' value='$mid'>
                    <TD>$code
                    <TD>Deposit<TD><font color ='blue'>$amount</font>
                    <TD>$mydatetime
                    <TD bgcolor='yellow'>
                    <input type='text' name='update_n[]' value='$note' style='background-color:yellow;'>
                    <TD>
                    <input type='checkbox' name='checked[]' value='$mid'>
                    </td>";
                }

        }
        echo "</TABLE>";
        $add = $sum->fetch_assoc();
        echo "Total Amount: <strong>" . $add['sum'] . "</strong><br>";
        echo "<input name='delete' type='submit' value='Update transaction'>";
        echo "</form>";

}
    #If no entries recorded, show message.
    else{
        echo "<br>There are no entries in your bank account";
        mysqli_free_result($check);
    }
}
}

?>
</body>
</html>