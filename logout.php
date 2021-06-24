<?php

session_start();
unset($_SESSION['username']);
unset($_SESSION['pwd']);
if (empty($_SESSION['username']) && empty($_SESSION['pwd'])) {
    header("Location: login-form.php");
}