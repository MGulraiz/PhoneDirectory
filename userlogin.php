<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
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
$emailErr=$passwordErr="";	//variables to display errors
$email=$password="";	//php variables to store html input elements

if($_SERVER['REQUEST_METHOD']=="POST")
{

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
	
	
	//Data Insertion After Validation
	if(empty($emailErr) && empty($passwordErr))
	{
	$sql="SELECT personid, personname, personemail FROM person";
	$result=$conn->query($sql);
	
		if($result->num_rows>0)
		{
			while($row=$result->fetch_assoc())
			{
				echo "Person Id: ".$row['personid']." - Person Name: ".$row['personname']." - Person Email: ".$row['personemail']."<br>";
			}
		}
		else
			{
				echo "0 results!!";
			}
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


$conn->close();
?>


<h2>Login Form</h2>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <div class="imgcontainer">
    <img src="img_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter your registered email" name="email" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>

</body>
</html>
