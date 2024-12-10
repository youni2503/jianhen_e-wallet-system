<?php
session_start();
include 'connection.php';

// Check Auth
if (isset($_SESSION['id'])) {
	if ($_SESSION['role'] == 'Admin') {
		header("location: Admin/index.php");
	} elseif ($_SESSION['role'] == 'Employee') {
		header("location: Employee/index.php");
	} elseif ($_SESSION['role'] == 'Vendor') {
		header("location: Vendoracc/index.php");
	}
	}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$role = mysqli_real_escape_string($connection ,$_POST['role']);

//employee register
if($role == 'Employee'){

$employee_name = mysqli_real_escape_string($connection ,$_POST['employee_name']);
$employee_id = mysqli_real_escape_string($connection, $_POST['employee_id']);
$employee_email = mysqli_real_escape_string($connection, $_POST['employee_email']);
$employee_password = mysqli_real_escape_string($connection, $_POST['employee_password']);

$sqlemail = "SELECT * FROM employee WHERE employee_email = '$employee_email'";
$resultemail = mysqli_query($connection,$sqlemail);

$sqlempid = "SELECT * FROM employee WHERE employee_id= '$employee_id'";
$resultempid = mysqli_query($connection,$sqlempid);

if(mysqli_num_rows($resultemail) >0){
echo "<script>alert('Email already Exist. Please try again!'); window.location.href='register.php'</script>";
}
else if(mysqli_num_rows($resultempid) >0){
echo "<script>alert('Employee ID already Exist. Please try again!'); window.location.href='register.php'</script>";
}
else{
$insert = "INSERT INTO employee (employee_name,employee_id,employee_email,employee_password,employee_ewallet_balance) 
VALUES ('$employee_name','$employee_id','$employee_email','$employee_password','0')";
mysqli_query($connection,$insert);

echo "<script>alert('Registration success! Kindly login to your Account!'); window.location.href='index.php'</script>";
}

}

else{
//vendor register	
$vendor_name = mysqli_real_escape_string($connection ,$_POST['vendor_name']);
$vendor_email = mysqli_real_escape_string($connection, $_POST['vendor_email']);
$vendor_password = mysqli_real_escape_string($connection, $_POST['vendor_password']);

$sqlemail = "SELECT * FROM Vendors WHERE vendor_email = '$vendor_email'";
$resultemail = mysqli_query($connection,$sqlemail);

if(mysqli_num_rows($resultemail) >0){
echo "<script>alert('Email already Exist. Please try again!'); window.location.href='register.php'</script>";
}
else{
$insert = "INSERT INTO Vendors (vendor_name,vendor_email,vendor_password,vendor_ewallet_balance) 
VALUES ('$vendor_name','$vendor_email','$vendor_password','0')";
mysqli_query($connection,$insert);

echo "<script>alert('Registration success! Kindly login to your Account!'); window.location.href='index.php'</script>";
}
}
}
?>

<!--layout-->
<!DOCTYPE html>
<html>
<head>
<!-- Basic Page Info -->
<meta charset="utf-8" />
<title>Ewallet QR System</title>

<!-- Site favicon -->
<link
rel="apple-touch-icon"
sizes="180x180"
href="Image/Retail360.png"
/>
<link
rel="icon"
type="image/png"
sizes="32x32"
href="Image/Retail360.png"
/>
<link
rel="icon"
type="image/png"
sizes="16x16"
href="Image/Retail360.png"
/>

<!-- Mobile Specific Metas -->
<meta
name="viewport"
content="width=device-width, initial-scale=1, maximum-scale=1"
/>

<!-- Google Font -->
<link
href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet"
/>
<!-- CSS -->
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
<link
rel="stylesheet"
type="text/css"
href="vendors/styles/icon-font.min.css"
/>
<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

<style>
.login-box{
max-width: 100% !important;
}

.avatar-upload {
position: relative;
max-width: 205px;
margin: 50px auto;
}
.avatar-upload .avatar-edit {
position: absolute;
right: 12px;
z-index: 1;
top: 10px;
}
.avatar-upload .avatar-edit input {
display: none;
}
.avatar-upload .avatar-edit input + label {
display: inline-block;
width: 34px;
height: 34px;
margin-bottom: 0;
border-radius: 100%;
background: #FFFFFF;
border: 1px solid transparent;
box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
cursor: pointer;
font-weight: normal;
transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
background: #f1f1f1;
border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
content: "\f040";
font-family: 'FontAwesome';
color: #757575;
position: absolute;
top: 10px;
left: 0;
right: 0;
text-align: center;
margin: auto;
}
.avatar-upload .avatar-preview {
width: 192px;
height: 192px;
position: relative;
border-radius: 100%;
border: 6px solid #F8F8F8;
box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
width: 100%;
height: 100%;
border-radius: 100%;
background-size: cover;
background-repeat: no-repeat;
background-position: center;
}

</style>

<style>
			body{
				background-color: white !important;
			}
		</style>

</head>
<body class="login-page">
<div class="login-header box-shadow" style="background:black;">
<div
class="container-fluid d-flex justify-content-between align-items-center"
>
<div class="brand-logo">
<a href="index.php" style="	color:black !important;
font-weight:bolder  !important; font-size:x-large;">
	<img src="Image/Retail360.png" alt="" style="height: 60px; width: 60px;" /> <h5 style="color:#eef2fe; padding-left:30px;">Ewallet QR System</h5>
</a>
</div>
</div>
</div>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
>
<div class="container">
<div class="row align-items-center">
<div class="col-md-6 col-lg-6">
<img src="Image/register.png"  alt="" />
</div>
<div class="col-md-6 col-lg-6">
	<div class="login-box bg-white box-shadow border-radius-10">
		<div class="login-title">
			<center>
			<h2 class="text-center text-primary">Create New Account</h2></h2>
			</center>
		</div>
		<form action=" " method="POST" autocomplete="off" aria-autocomplete="off" enctype="multipart/form-data">

<div class="row">
<div class="col-md-12 col-sm-12">
<div class="form-group">
<select
type="text"
class="form-control form-control-lg"
name="role"
id="role"
required
>
<option value="" selected disabled>-- Select Role --</option>
<option value="Employee">Employee</option>
<option value="Vendor">Vendor</option>
</select>

</div>
</div>
</div>

<div class="row employee" style="display: none;">
<div class="col-md-12 col-sm-12">
<div class="form-group">
<label>Employee Name</label>
<input type="text" class="form-control employee" name="employee_name" required>
</div>
</div>
<div class="col-md-12 col-sm-12">
<div class="form-group">
<label>Employee ID</label>
<input type="text" class="form-control employee" name="employee_id" required>
</div>
</div>
</div>

<div class="row employee" style="display: none;">
<div class="col-md-6 col-sm-12">
<div class="form-group">
<label>Email</label>
<input type="email" class="form-control employee" name="employee_email" required>
</div>
</div>
<div class="col-md-6 col-sm-12">
<div class="form-group">
<label>Password</label>
<input type="password" class="form-control employee" name="employee_password" required>
</div>
</div>
</div>

<div class="row vendor" style="display: none;">
<div class="col-md-12 col-sm-12">
<div class="form-group">
<label>Vendor Name</label>
<input type="text" class="form-control vendor" name="vendor_name" required>
</div>
</div>
</div>

<div class="row vendor" style="display: none;">
<div class="col-md-6 col-sm-12">
<div class="form-group">
<label>Email</label>
<input type="email" class="form-control vendor" name="vendor_email" required>
</div>
</div>
<div class="col-md-6 col-sm-12">
<div class="form-group">
<label>Password</label>
<input type="password" class="form-control vendor" name="vendor_password" required>
</div>
</div>
</div>
				
			<div class="row">
				<div class="col-sm-12">
					<div class="input-group mb-0">
					
						<input class="btn btn-primary btn-lg btn-block" type="submit" value="Register">
					
					</div>
					<div
						class="font-16 weight-600 pt-10 pb-10 text-center register"
						data-color="#707373"
					>
						OR
					</div>
					<div class="input-group mb-0 register">
						<a
							class="btn btn-outline-primary btn-lg btn-block"
							href="index.php"
							>Login</a
						>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
</div>
</div>
<!-- js -->

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>

<script>
	$(document).on('change', '#role', function() {
  	let role = $('#role :selected').text();

	if(role == 'Employee'){
		$('.employee').show().val('').attr('required',true);
		$('.vendor').hide().val('').attr('required',false);
	}
	else{
		$('.vendor').show().val('').attr('required',true);
		$('.employee').hide().val('').attr('required',false);
	}
});
</script>
</body>
</html>