<html>
<head>
<?php

$cookie_n = "name";
	if(!isset($_COOKIE['name'])){
		echo "Please login in first<br>";
		echo "<a href='cps3740_p2.html'>Login page</a>";
	}
else {
$cid = $_COOKIE['name'];
include "dbconfig.php";
$connect = mysqli_connect($server, $login, $password, $dbname) or die("<br>Cannot connect to Database");

$code=$_POST['code'];
$src=$_POST['src'];
$type=$_POST['type'];
$money=$_POST['money'];
$note=$_POST['note'];

$check = mysqli_query($connect,"SELECT sum(amount) as sum2 FROM CPS3740_2019S.Money_paukerj WHERE cid=$cid");
       if(mysqli_num_rows($check)>0){
                while($row = mysqli_fetch_array($check)){
  						$cur_sum = $row['sum2'];
  					}
  				}

if($money <= 0){
	echo "Amount can not be less or equal to 0.";
}

else if($type == 'W' AND ($money > $cur_sum)){
	echo "Can not withdraw more than your current balance";
}

else {
	$pcheck = mysqli_query($connect,"SELECT code FROM CPS3740_2019S.Money_paukerj WHERE code like '%$code%'");
	$row_p = mysqli_num_rows($pcheck);

	if(($row_p > 0) AND ($type=='W' or $type='D')){
		echo "Transaction code already used, please use other code.";
	}
	else{
		if ($type == 'W') {
			echo "<a href = 'logout.php'>Logout</a><br>";
			$insert =mysqli_query($connect,"INSERT INTO CPS3740_2019S.Money_paukerj (mid, code, cid, sid, type,amount , mydatetime , note)
			VALUES ('' , '$code' , '$cid' , '$src' , '$type' , -'$money' , NOW() , '$note')");

			$check2 = mysqli_query($connect,"SELECT sum(amount) as add2 FROM CPS3740_2019S.Money_paukerj WHERE cid=$cid");
       			if(mysqli_num_rows($check2)>0){
                while($row = mysqli_fetch_array($check2)){
  						$cur_sum2 = $row['add2'];
  					}
  					echo "Update was successful<br><br><br>";
  					echo "New Balance: $cur_sum2";
  				}
		}

		else if($type == 'D') {
			echo "<a href = 'logout.php'>Logout</a><br>";
			$insert =mysqli_query($connect,"INSERT INTO CPS3740_2019S.Money_paukerj (mid, code, cid, sid, type,amount , mydatetime , note)
			VALUES ('' , '$code' , '$cid' , '$src' , '$type' , '$money' , NOW() , '$note')");

			$check3 = mysqli_query($connect,"SELECT sum(amount) as add3 FROM CPS3740_2019S.Money_paukerj WHERE cid=$cid");
       				if(mysqli_num_rows($check3)>0){
                	while($row = mysqli_fetch_array($check3)){
  						$cur_sum3 = $row['add3'];
  					}
  					echo "Update was succesful<br><br><br>";
  					echo "New Balance: $cur_sum3";
  				}
		}
		else {
			echo "Update was not successful";
		}
	}
}
}
mysqli_close($connect);
	
?>

</head>
</HTML>
