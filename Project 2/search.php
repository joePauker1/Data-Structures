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
$keyword = $_GET['keyword'];
$result = mysqli_query($connect,"SELECT name as user FROM Customers WHERE id=$id");
       if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                        $user = $row['user'];
                }
            }

if(empty($keyword)) {
	echo "no keyword was entered";
}
else if ($keyword == '*'){
    $sum = mysqli_query($connect,"SELECT sum(amount) as sum FROM CPS3740_2019S.Money_paukerj WHERE cid=$id");
	$check = mysqli_query($connect, "SELECT m.mid,m.code,m.type,m.amount,m.mydatetime,m.note,s.name 
                FROM  CPS3740.Sources s,CPS3740_2019S.Money_paukerj m WHERE s.id=m.sid AND m.cid=$id ORDER BY mid;");

echo "The transactions in customer <strong>$user</strong>. Records matched keyword <strong>$keyword</strong> are:<br><br>";
	if($check) {
		if(mysqli_num_rows($check) > 0){
	echo "<table border = '1'>";
	echo "<tr><th>ID<th>Code<th>Type<th>Amount<th>Date Time<th>Note<th>Source";

        while($row = mysqli_fetch_array($check)){
            $mid=$row['mid'];
            $code=$row['code'];
            $type = $row['type'];
            $amount=$row['amount'];
            $mydatetime=$row['mydatetime'];
            $note=$row['note'];
            $typename=$row['name'];
                    #Checking whether transaction was withdraw or deposit
                if($type == 'W'){
                    echo "<TR><TD>$mid<TD>$code<TD>Withdraw<TD><font color='red'>$amount</font><TD>$mydatetime<TD>$note<TD>$typename";
                }
                else{
                    echo "<TR><TD>$mid<TD>$code<TD>Deposit<TD><font color ='blue'>$amount</font><TD>$mydatetime<TD>$note<TD>$typename";
                }

        }
        echo "</TABLE>";
        $add = $sum->fetch_assoc();
        echo "Total Amount: " . $add['sum'];
        
	 	}
        mysql_close($check);
        mysql_close($connect);
	}
}
else{
    $sum2 = mysqli_query($connect,"SELECT sum(m.amount) as sum2
                                    FROM  CPS3740.Sources s,CPS3740_2019S.Money_paukerj m 
                                    WHERE s.id=m.sid and note like '%$keyword%' ORDER BY mid");

	$check2 = mysqli_query($connect, "SELECT m.mid,m.code,m.type,m.amount,m.mydatetime,m.note,s.name 
                                      FROM  CPS3740.Sources s,CPS3740_2019S.Money_paukerj m 
                                      WHERE s.id=m.sid and note like '%$keyword%' ORDER BY mid");

echo "The transactions in customer <strong>$user</strong>. Records matched keyword <strong>$keyword</strong> are:<br><br>";
	if($check2) {
		if(mysqli_num_rows($check2) > 0){
	echo "<table border = '1'>";
	echo "<tr><th>ID<th>Code<th>Type<th>Amount<th>Date Time<th>Note<th>Source";

        while($row = mysqli_fetch_array($check2)){
            $mid=$row['mid'];
            $code=$row['code'];
            $type = $row['type'];
            $amount=$row['amount'];
            $mydatetime=$row['mydatetime'];
            $note=$row['note'];
            $typename=$row['name'];
                    #Checking whether transaction was withdraw or deposit
                if($type == 'W'){
                    echo "<TR><TD>$mid<TD>$code<TD>Withdraw<TD><font color='red'>$amount</font><TD>$mydatetime<TD>$note<TD>$typename";
                }
                else{
                    echo "<TR><TD>$mid<TD>$code<TD>Deposit<TD><font color ='blue'>$amount</font><TD>$mydatetime<TD>$note<TD>$typename";
                }

        }
        echo "</TABLE>";
         $add2 = $sum2->fetch_assoc();
        echo "Total Amount: " . $add2['sum2'];
        mysqli_close($connect);
		}
        else {
            echo "No record found with the search keyword: <strong>$keyword</strong>";
            mysqli_close($connect);
        }
	}
}

mysqli_close($connect);
}
?>
</body>
</html>