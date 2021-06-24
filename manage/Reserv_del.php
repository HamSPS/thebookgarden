<?php
    include '../connectdb.php';

    $getID = $_POST['rsid'];

    $sql1 = "SELECT * FROM reserv_detail WHERE rsID = '$getID'";
    $result1 = mysqli_query($con, $sql1);
    while($row = mysqli_fetch_array($result1)){
        $sql = "DELETE FROM reserv_detail WHERE rsID = '$getID'";
        mysqli_query($con, $sql);
    }

    $sql = "DELETE FROM tbreserv WHERE rsID = '$getID'";
    mysqli_query($con, $sql);
?>