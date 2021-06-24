<?php 
    session_start();
    include 'connectdb.php';
?>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- <script src="js/sweetalter.min.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // echo '<hr>';

    // echo '<pre>';
    // print_r($_SESSION['cart']);
    // echo '</pre>';
    // // exit;
        mysqli_query($con, "BEGIN");
        $sID = $_POST['SlID'];
        $stID = $_POST['stid'];
        $sdate = $_POST['sdate'];
        $total = $_POST['total'];
        $pay = $_POST['pay'];
        //insert ຂໍ້ມູນລົງໃນ tbsale
        $sql1 = "INSERT INTO tbsale VALUES('$sID','$sdate','$stID','$total','$pay')";
        $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1". mysqli_error($sql1));


        // echo $sql1;
        //insert ຂໍ້ມູນລົງໃນ sale_detail


        foreach($_SESSION['cart'] as $b_id => $qty){
            $sql2 = "SELECT * FROM tbbook WHERE Bkid = '$b_id'";
            $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql2". mysqli_error($sql2));
            $row2 = mysqli_fetch_array($result2);
            $sum_price = $row2['price'] * $qty;

            $sql3 = "INSERT INTO sale_detail VALUES(null,'$b_id','$qty','$sum_price','$sID')";
            $result3 = mysqli_query($con, $sql3) or die ("Error in query: $sql3". mysqli_error($sql3));
        //     // echo '<br/>';
        //     // echo $sql3;
            $sql4 = "UPDATE tbbook SET stock = stock - $qty WHERE Bkid = '$b_id'";
            $result4 = mysqli_query($con, $sql4) or die ("Error in query: $sql4". mysqli_error($sql4));
        }

        if ($result1 && $result3) {
            mysqli_query($con, "COMMIT");
            $_SESSION['bill'] = $sID;
            $msg = "success";
            foreach($_SESSION['cart'] as $b_id){
                unset($_SESSION['cart']);
            }
            header("location: report/bill.php");
        }else{
            mysqli_query($con, "ROLLBACK");
            $msg="error";
        }
    // exit;

    
?>


<script type="text/javascript">
// alert.log("<?php echo $msg; ?>");
window.location = "report/bill.php";
</script>