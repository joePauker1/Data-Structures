<?php
echo "<HTML>";
include "dbconfig.php";

$con= new mysqli($server,$login,$password,$dbname) or die("<br>Cannot connect to Database");

$result = mysqli_query($con,"SELECT id,login,password,name,gender,dob,street,city,state,zipcode FROM Customers");
 
if($result) {
	if(mysqli_num_rows($result)>0) {
		echo "The following customers are in the database.";
		echo "<TABLE border=1>";
		echo "<TR><TH>ID<TH>Login<TH>Password<TH>Name<TH>Gender<TH>DOB<TH>Street<TH>City<TH>State<TH>Zipcode";

		while($row = mysqli_fetch_array($result)){
			$id=$row['id'];
			$login_id=$row['login'];
			$password=$row['password'];
			$name=$row['name'];
			$gender=$row['gender'];
			$DOB=$row['dob'];
			$street=$row['street'];
			$city=$row['city'];
			$state=$row['state'];
			$zipcode=$row['zipcode'];
			echo "<TR><TD>$id<TD>$login_id<TD>$password<TD>$name<TD>$gender<TD>$DOB<TD>$street<TD>$city<TD>$state<TD>$zipcode";
		}
		echo "</TABLE>";
	}
	else{
		echo "<br>No records in the database.";
		mysqli_free_result($result);
	}
}

else {
	echo "<br>Something wrong with the SQL query.";
}
mysqli_close($con);
?>