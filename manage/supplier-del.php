<?php
    include_once '../connectdb.php';

    $sup_id = $_POST['sup_id'];

    // $sql = "DELETE FROM tbsuppliers WHERE sup_id = '$sup_id'";
    // mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));

    $sql = "DELETE FROM tbsuppliers WHERE sup_id ='$sup_id'";
    mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));