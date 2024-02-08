<?php

session_start();

$con = mysqli_connect('localhost', 'root', '');
mysqli_select_db($con, 'userreg');

if (isset($_POST["submit"])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];

    $s = "SELECT * FROM usertable WHERE name = '$name' && password ='$pass'";
    $result = mysqli_query($con, $s);
    $num = mysqli_num_rows($result);

    if ($num === 1) {
        // Check if the email ends with @am.students.amrita.edu
        if (strpos($name, '@am.students.amrita.edu') !== false) {
            header('Location: ./students/one.html');
        } elseif (strpos($name, '@am.teachers.amrita.edu') !== false) {
            // Redirect to a different page for teachers, for example, teacher.html
            header('Location: ./teachers/teacher.html');
        } else {
            // Redirect to a default page if the email doesn't match any condition
            header('Location: login.php');
        }
    } else {
        $error_message = "Incorrect Username or Password!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Amrita Arena</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <div class="container">
        <form class="login-form" action="login.php" method="POST">
            <h2>Login</h2>
            <?php
            if (isset($error_message)) {
                echo '<p class="error-message">' . $error_message . '</p>';
            } elseif (isset($_POST["submit"])) {
                echo '<p class="success-message">Login Successful!</p>';
            }
            ?>
            <div class="input-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <br>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>
</html>
