<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    background-color: white;
}

* {
    box-sizing: border-box;
}

/* Add padding to containers */
.container {
    padding: 16px;
    background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}

/* Overwrite default styles of hr */
hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}

.registerbtn:hover {
    opacity: 1;
}

/* Add a blue text color to links */
a {
    color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
    background-color: #f1f1f1;
    text-align: center;
}
</style>
</head>
<body>

<?php
$servername="localhost";
$username="root";
$pwd="";
$dbname="phonedir";

//creating connection
$conn=new mysqli($servername, $username,$pwd, $dbname);

//checking connection 
if($conn->connect_error)
{
	die("Connection Failed: ".$conn->connect_error);
}
else
{
	echo "connected successfuly";
}
////////////////////////////////////////////////////////////////////////
$nameErr=$emailErr=$passwordErr=$levelErr=$addressErr=$cityErr=$provinceErr="";	//variables to display errors
$name=$email=$password=$level=$address=$city=$province="";	//php variables to store html input elements

if($_SERVER['REQUEST_METHOD']=="POST")
{
	if(empty($_POST["name"]))
	{
		 $nameErr="Name is required";
	}
	else
	{
	$name=test_input($_POST["name"]);
		if(!preg_match("/^[a-zA-Z ]*$/", $name))
		{
			$nameErr="Only characters and spaces are allowed.";
		}
	}
	
	if(empty($_POST["email"]))
	{
		$emailErr=" Email is required";
	}
	else
	{
	$email=test_input($_POST["email"]);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$emailErr="Invalid Email ";
	}
	}
	
	if(empty($_POST["password"]))
	{
		$passwordErr="Password is required";
	}
	else
	{
	$password=test_input($_POST["password"]);
	}
	
	if(empty($_POST["level"]))
	{
		$levelErr="Please Select an Account level";
	}
	else
	{
	$level=test_input($_POST["level"]);
	}
	
	if(empty($_POST["address"]))
	{
		$addressErr=" Address is required";
	}
	else
	{
	$address=test_input($_POST["address"]);
	}

	if(empty($_POST["city"]))
	{
		 $cityErr="City is required";
	}
	else
	{
	$city=test_input($_POST["city"]);
		if(!preg_match("/^[a-zA-Z ]*$/", $city))
		{
			$cityErr="Only characters and spaces are allowed.";
		}
	}
	
	if(empty($_POST["province"]))
	{
		 $provinceErr="province is required";
	}
	else
	{
	$province=test_input($_POST["province"]);
		if(!preg_match("/^[a-zA-Z ]*$/", $province))
		{
			$provinceErr="Only characters and spaces are allowed.";
		}
	}
	
	//Data Insertion After Validation
	if(empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($levelErr) && empty($addressErr) && empty($cityErr) && empty($provinceErr))
	{
	$sql="INSERT INTO person(personname, personemail, personpwd, personlevel,personadrs, personcity, personprovince) VALUES('$name', '$email', '$password', '$level', '$address', '$city', '$province')";
	$conn->query($sql);
	
	echo "<br>Query Status: New record created successfully!!";
	}

}

//Testing function to avoid XSS attacks
function test_input($data)
{
	$data=trim($data);
	$data=stripslashes($data);
	$data=htmlspecialchars($data);

	return $data;
}
/*
//Insertion Query
$sql=NULL;
if(empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($levelErr) && empty($addressErr) && empty($cityErr) && empty($provinceErr))
{
global $sql;
$sql="INSERT INTO person(personname, personemail, personpwd, personlevel,personadrs, personcity, personprovince) VALUES('$name', '$email', '$password', '$level', '$address', '$city', '$province')";
//$conn->query($sql);
}

//checking query 
if($conn->query($sql)===TRUE)
{
	echo "New record created successfully!!";
}
else
{
	echo "<br>Error: ".$sql."<br>".$conn->error;
}
*/

$conn->close();


?>

<form method="post">
  <div class="container">
    <h1>User Registeration</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

	<label for="name"><b>Name</b></label>
    <input type="text" placeholder="Enter your name" name="name" required>
	<?php if(!empty($nameErr)) echo "<br>".$nameErr."<br>"; ?>
	
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter your Email" name="email" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <label for="level"><b>Account Level</b></label>
    <input type="text" placeholder="e.g; premium or gold" name="level" required>
   
	<label for="address"><b>Address</b></label>
    <input type="text" placeholder="Enter your address" name="address" required>

	<label for="city"><b>City</b></label>
    <input type="text" placeholder="e.g; Lahore" name="city" required>

	<label for="province"><b>Province</b></label>
    <input type="text" placeholder="e.g; Balochistan" name="province" required>

   <hr>
    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="#">Sign in</a>.</p>
  </div>
</form>

</body>
</html>