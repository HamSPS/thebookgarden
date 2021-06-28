<?php

session_start();
unset($_SESSION['username']);
unset($_SESSION['pwd']);

unset($_SESSION['empID']);
unset($_SESSION["name"]);
unset($_SESSION['img']);


if (empty($_SESSION['username']) && empty($_SESSION['pwd'])) {
    header("Location: login-form.php");
}