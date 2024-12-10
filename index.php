<?php
session_start();
include 'connection.php';

//when user login will navigate to other page
if (isset($_SESSION['id'])) {
if ($_SESSION['role'] == 'Admin') {
    header("location: Admin/index.php");
} elseif ($_SESSION['role'] == 'Employee') {
    header("location: Employee/index.php");
} elseif ($_SESSION['role'] == 'Vendor') {
    header("location: Vendoracc/index.php");
}
}

//handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$email = mysqli_real_escape_string($connection, $_POST['email']);
$password = mysqli_real_escape_string($connection, $_POST['password']);
$role = mysqli_real_escape_string($connection, $_POST['role']);
$remember_me = isset($_POST['remember_me']) ? true : false;

//check user info based from role
if ($role == 'Admin') {
    $query = "SELECT * FROM Admin WHERE admin_email = '$email' AND admin_password = '$password'";
    $result = mysqli_query($connection, $query);
} else if ($role == 'Vendor') {
    $query = "SELECT * FROM Vendors WHERE vendor_email = '$email' AND vendor_password = '$password'";
    $result = mysqli_query($connection, $query);
} else if ($role == 'Employee') {
    $query = "SELECT * FROM employee WHERE employee_email = '$email' AND employee_password = '$password'";
    $result = mysqli_query($connection, $query);
}

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row > 0) {

        if ($role  == 'Admin') {
            $_SESSION["id"] = $row['admin_id'];
            $_SESSION["name"] = $row['admin_name'];
        } else if ($role  == 'Vendor') { 
            $_SESSION["id"] = $row['vendor_id'];
            $_SESSION["name"] = $row['vendor_name'];
        } else if ($role  == 'Employee') {
            $_SESSION["id"] = $row['emp_id'];
            $_SESSION["name"] = $row['employee_name'];
        }
        $_SESSION["role"] = $role;

        //save login info
        if ($remember_me) {
            setcookie('email', $email, time() + (30 * 24 * 60 * 60));
            setcookie('password', $row['password'], time() + (30 * 24 * 60 * 60));
        }

        //login and welcome user
        if ($role == 'Admin') {
            echo "<script>alert('Welcome Back " . $_SESSION["name"] . "!'); window.location.href='Admin/index.php'</script>";
        } else if ($role == 'Vendor') {
            echo "<script>alert('Welcome Back " . $_SESSION["name"] . "!'); window.location.href='Vendoracc/index.php'</script>";
        } else if ($role == 'Employee') {
            echo "<script>alert('Welcome Back " . $_SESSION["name"] . "!'); window.location.href='Employee/index.php'</script>";
        }
        exit();
    } else {
        //incorrect user info
        echo "<script>alert('Invalid Email or Password!'); window.location.href='index.php'</script>";
        exit();
    }
    mysqli_free_result($result);
}
}

if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
$email = $_COOKIE['email'];
$password = $_COOKIE['password'];
}
?>
<!DOCTYPE html>
<html>

<head>
<!-- Basic Page Info -->
<meta charset="utf-8" />
<title>Ewallet QR System</title>

<!-- Site favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="Image/Retail360.png" />
<link rel="icon" type="image/png" sizes="32x32" href="Image/Retail360.png" />
<link rel="icon" type="image/png" sizes="16x16" href="Image/Retail360.png" />

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
<!-- CSS -->
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css" />
<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

<style>
    body {
        background-color: white !important;
    }
</style>

</head>

<body class="login-page">
<div class="login-header box-shadow" style="background:black;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <a href="index.php" style="color:black !important; font-weight:bolder  !important; font-size:x-large;">
                <img src="Image/Retail360.png" alt="" style="height: 60px; width: 60px;" />
                <h5 style="color:#eef2fe; padding-left:30px;">Ewallet QR System</h5>
            </a>
        </div>
    </div>
</div>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="Image/ewallet_image.jpeg" alt="" />
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <center>
                            <h2 class="text-center text-primary">Welcome back!<br><br>
                                <h2 style="color:black;">Login to your Account</h2>
                        </center>
                    </div>
                    <form action="" method="POST" autocomplete="off" aria-autocomplete="off">
                        <div class="input-group custom">
                            <select class="form-control form-control-lg" name="role" id="role" required>
                                <option value="" selected disabled>-- Select Role --</option>
                                <option value="Employee">Employee</option>
                                <option value="Vendor">Vendor</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="input-group custom">

                            <input
                                type="email"
                                class="form-control form-control-lg"
                                placeholder="Email"
                                name="email"
                                value="<?php echo isset($email) ? $email : ''; ?>"
                                required />
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                placeholder="Password"
                                name="password"
                                id="password"
                                value="<?php echo isset($password) ? $password : ''; ?>"
                                required />
                            <div class="input-group-append custom" id="togglePassword">
                                <span class="input-group-text"><i class="dw dw-padlock" id="toggleIcon"></i></span>
                            </div>
                        </div>

                        <div class="row pb-30">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember_me">
                                    <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Login">
                                </div>
                                <div
                                    class="font-16 weight-600 pt-10 pb-10 text-center register"
                                    data-color="#707373">
                                    OR
                                </div>
                                <div class="input-group mb-0 register">
                                    <a
                                        class="btn btn-outline-primary btn-lg btn-block"
                                        href="register.php">Create New Account</a>
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
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('dw-padlock');
            toggleIcon.classList.add('dw-eye');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('dw-eye');
            toggleIcon.classList.add('dw-padlock');
        }
    });
</script>

<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>
</body>

</html>