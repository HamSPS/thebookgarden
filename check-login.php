<?php
session_start();
include_once 'connectdb.php';

if (isset($_SESSION['username']) && isset($_SESSION['pwd'])) {
    $username = $_SESSION['username'];
    $pwd = $_SESSION['pwd'];
    $sql = "SELECT * FROM tbstaff WHERE username ='$username' AND pwd = md5('$pwd')";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) < 0) {
        header("Location: login-form.php");
    }
} else {
    header("Location: login-form.php");
}
