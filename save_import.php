<?php 
    session_start();
    include 'connectdb.php';

    $getID = $_GET['pcid'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/sweetalert.min.js"></script>

</head>

<body>
    <?php

        mysqli_query($con, "BEGIN");
        $impid = $_POST['impid'];
        $pdate = $_POST['pdate'];
        $stid = $_POST['stid'];

        $sql1 = "INSERT INTO tbimport VALUES('$impid','$pdate','$stid')";
        $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1". mysqli_error($sql1));


        // echo $sql1;
        //insert ຂໍ້ມູນລົງໃນ sale_detail


        foreach($_SESSION['import'] as $b_id => $qty){
            $sql2 = "SELECT * FROM tbbook WHERE Bkid = '$b_id'";
            $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql2". mysqli_error($sql2));
            $row2 = mysqli_fetch_array($result2);
            $sum_price = $row2['price'] * $qty;

            $sql3 = "INSERT INTO import_detail VALUES(null,'$impid','$b_id','$qty','$sum_price')";
            $result3 = mysqli_query($con, $sql3) or die ("Error in query: $sql3". mysqli_error($sql3));
        //     // echo '<br/>';
        //     // echo $sql3;
            $sql4 = "UPDATE tbbook SET stock = stock + $qty WHERE Bkid = '$b_id'";
            $result4 = mysqli_query($con, $sql4) or die ("Error in query: $sql4". mysqli_error($sql4));
        }

        if ($result1 && $result3) {
            mysqli_query($con, "COMMIT");
            foreach($_SESSION['import'] as $b_id){
                unset($_SESSION['import']);
            }
            mysqli_query($con, "UPDATE tbpurchase SET sts_id = 4 WHERE pcid = '$getID'");

            echo '<script type="text/javascript">
            swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success")
            .then((value) => {
                    window.location = "import.php";
            }) 
            </script>';
            
            // header("refresh:2;url=import.php");
        }else{
            mysqli_query($con, "ROLLBACK");
            echo '<script type="text/javascript"> swal("ຜິດພາດ", "ກະລຸນາກວດສອບຂໍ້ມູນ", "danger") </script>';
        }

?>




    <script>
    // window.location = "import.php";
    </script>
</body>

</html>