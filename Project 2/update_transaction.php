<!DOCTYPE html>
<html>
<head>
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
$sumChecked = count($_POST['checked']);
$sumUpdate = count($_POST['update_n']);
$upp = 0;

if($sumChecked > 0){
for($j = 0; $j < $sumChecked; $j++){
	$row1 = mysqli_fetch_array($checkcode);
	$del_mid = $_POST['checked'][$j];
	$trash = mysqli_query($connect,"DELETE FROM CPS3740_2019S.Money_paukerj WHERE mid='$del_mid'");

	echo "Delete Successful: DELETE from Money_paukerj.<br>";
	$upp++;
	}
}
mysqli_free_result($trash);
mysqli_close($connect);


$connect2 = mysqli_connect($server, $login, $password, $dbname) or die("<br>Cannot connect to Database");
$fetchupdate=mysqli_query($connect2, "SELECT note, code FROM CPS3740_2019S.Money_paukerj");
$rowz=mysqli_num_rows($fetchupdate);
$up = 0;

if($sumUpdate > 0){
for($i = 0; $i < $rowz; $i++){
	$row = mysqli_fetch_array($fetchupdate);
	$update_n = $_POST['update_n'][$i];
	$main_id = $_POST['main_id'][$i];
	$code = $row['code'];
	if($update_n != $row['note']) {
		$update = "UPDATE CPS3740_2019S.Money_paukerj SET note = '$update_n' WHERE mid='$main_id'";

			$pass = mysqli_query($connect2,$update);
			echo "Update Successful: Comment changed to '$update_n' where code='$code'.<br>";
			$up++;
		}
	}
}
echo "$upp Transactions been deleted, $up Transactions been updated.";

mysqli_close($connect2);
}
?>
</body>
</html>