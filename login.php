<?php
session_start();
include 'config/app.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $pass = validate($_POST['password']);

    if (empty($username)) {
        header("Location: login-template.php?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: login-template.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM login_admin WHERE username='$username' AND password='$pass'";

        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $pass) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                // $_SESSION['id'] = $row['id'];
                header("Location: index.php");
                exit();
            } else {
                header("Location: login-template.php?error=Incorect Username or password !");
                exit();
            }
        } else {
            header("Location: login-template.php?error=Incorect Username or password !");
            exit();
        }
    }
} else {
    header("Location: login-template.php");
    exit();
}
