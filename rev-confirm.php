<?php
     include 'check-login.php';
     
     echo $_SESSION['cusName'];
    // ບັນທຶກການຈອງ
    if (isset($_POST['confirm'])) {
        mysqli_query($con, "BEGIN");
        $rsID = $_POST['rsID'];
        $rdate = $_POST['rdate'];
        $stid = $_POST['stid'];
        $cusid = $_POST['cusid'];

        $sql1 = "INSERT INTO tbreserv VALUES('$rsID','$rdate',null,'$stid','$cusid',1)";
        $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1". mysqli_error($sql1));

        foreach($_SESSION['rev'] as $b_id => $qty){
            $sql2 = "SELECT * FROM tbbook WHERE Bkid = '$b_id'";
            $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql2". mysqli_error($sql2));
            $row2 = mysqli_fetch_array($result2);
            $sum_price = $row2['price'] * $qty;

            $sql3 = "INSERT INTO reserv_detail VALUES(null,'$rsID','$b_id','$qty','$sum_price')";
            $result3 = mysqli_query($con, $sql3) or die ("Error in query: $sql3". mysqli_error($sql3));
        //     // echo '<br/>';
        //     // echo $sql3;
            // $sql4 = "UPDATE tbbook SET stock = stock - $qty WHERE Bkid = '$b_id'";
            // $result4 = mysqli_query($con, $sql4) or die ("Error in query: $sql4". mysqli_error($sql4));
        }

        if ($result1 && $result3) {
            mysqli_query($con, "COMMIT");
            $msg = '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
            foreach($_SESSION['rev'] as $b_id){
                unset($_SESSION['rev']);
            }
            unset($_SESSION['cusid']);
            unset($_SESSION['cusName']);
            header("refresh:2; url=Reserv-manage.php");
        }else{
            mysqli_query($con, "ROLLBACK");
            $msg='<script type="text/javascript"> swal("ຜິດພາດ", "ກະລຸນາກວດສອບຂໍ້ມູນ", "danger") </script>';
        }
    }

     //test Generate ID
     $sql = "SELECT COUNT(rsID) FROM tbreserv";
     $result = mysqli_query($con, $sql);
     $row = mysqli_fetch_array($result);
    //  if (empty($row[0])) {
    //      $lnum = 1;
    //  }else{
    // }
    $lnum = $row[0] + 1;
    //  $lnum = 1000;
    //  echo $lnum;

     $fchar = "RS";
     
     if(strlen($lnum) == 1){
         $znum = "00000";
     }else if(strlen($lnum) == 2){
         $znum = "0000";
     }else if(strlen($lnum) == 3){
        $znum = "000";
    }else if(strlen($lnum) == 4){
        $znum = "00";
    }else{
        $znum = "0";
    }

    //check id
    $chk = $fchar.$znum.$lnum;
    $ch_id = "SELECT * FROM tbreserv WHERE rsID = '$chk'";
    $qchk = mysqli_query($con, $ch_id);
    if ($row = mysqli_fetch_array($qchk) > 0) {
        $lnum +=1;
        $autoID = $fchar.$znum.$lnum;
    }else{
        $autoID = $fchar.$znum.$lnum;
    }
    $date = date("Y-m-d G:i:s");
    // echo '<br>';
    // echo $autoID;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/adminlte.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/all.min.lte.css">
    <title>Book Garden</title>
    
    
    <script src="js/sweetalert.min.js"></script>
    <style>
        body{
            font-family: NotoSansLao;
        }
        .fit-image{
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .box-change{
            display: inline-block;
            width: 64%;
            background: #58c8be;
            color: #fff;
            border-radius: 10px;
            padding: 5px 15px;
        }
        .bill-background{
            background: #d2d9d6;

        }
        .background {
            background: url("images/bill-background.png");
            background-size: cover;
            /* background-attachment: fixed; */
            position: fixed;
            width: 100%;
            height: 100%;
            opacity: 20%;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">
<?php 
     include 'menu.php';
?>
<div class="content">
    <?= @$msg ?>
<div class="background"></div>
    <div class="container-fluid" style="background:white;height:100%;">
        <div class="row mx-auto d-block">
            <div class="col-md-12">
                <form action="" method="post" name="frmCart" id="frmCart">
                <div class="row">
                    <div class="col-md-8 bill-background">

                        <div class="row ml-5">
                            <div class="col-md-10">
                                <img src="images/icon.svg" class="mx-auto d-block m-4 img-circle" width="150px" alt="ຮ້ານ The Book Garden">
                                <h1 class="text-center">ລາຍການສັ່ງຈອງ</h1>
                            </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rsID">ລະຫັດການຈອງ</label>
                                                <input class="form-control" type="text" id="rsID" name="rsID" value="<?= $autoID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" required="" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rdate">ວັນ, ເດືອນ, ປີ</label>
                                                <input class="form-control" type="datetime" id="rdate" name="rdate" value="<?= $date ?>" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stName">ຊື່ພະນັກງານ</label>
                                                <input class="form-control" type="hidden" id="stid" name="stid" value="<?= $_SESSION['empID'] ?>" readonly="">
                                                <input class="form-control" type="text" id="stName" name="stName" value="<?= $_SESSION['name'] ?>" readonly="">
                                            </div>
                                        </div>
                                            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cusName">ລູກຄ້າ</label>
                                                <input type="text" class="form-control" name="cusName" id="cusName" value="<?= $_SESSION['cusName'] ?>">
                                                <input type="hidden" name="cusid" id="cusid" value="<?= $_SESSION['cusID'] ?>">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <table class="table table-hover">
                            <thead align="center" style="background: #EAEAEA;">
                                    <tr>
                                        <th><strong>No.</strong></th>
                                        <th><strong>ສິນຄ້າ</strong></th>
                                        <th><strong>ລາຄາ</strong></th>
                                        <th><strong>ຈຳນວນ</strong></th>
                                        <th><strong>ລວມ</strong></th>
                                    </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $total = 0;
                                $i = 0;
                                if (!empty($_SESSION['rev'])) {
                                    foreach($_SESSION['rev'] as $b_id => $qty){
                                        $i++;
                                        $sql = "SELECT * FROM tbbook WHERE Bkid = '$b_id'";
                                        $query = mysqli_query($con, $sql);
                                        $row = mysqli_fetch_array($query);
                                        $sum = $row['price'] * $qty; //ເອົາລາຄາສິນຄ້າມາຄູນຈຳນວນສິນຄ້າ
                                        $total += $sum; //ລວມລາຄາສິນຄ້າ
                            ?>
                                    <tr>
                                        <td><?= $i ?>.</td>
                                        <td><?= $row['BkName'] ?></td>
                                        <td align="right"><?= number_format($row['price'], 2) ?> ກີບ</td>
                                        <td align="center"><?= $qty ?></td>
                                        <td align="right"><?= number_format($sum,2) ?> ກີບ</td>
                                    </tr>
                                    <?php 
                                    
                                }
                                    ?>
                                    <tr style="background:#e0d0d0;">
                                        <td colspan="4" align="right">ລາຄາລວມ:</td>
                                        <td align="right"><?= number_format($total, 2) ?> ກີບ</td>
                                    </tr>
                                    <?php 
                                    
                            }else{
                                echo '<tr style="background: #e0d0d0;">';
                                echo '<td colspan="6" align="center" style="font-size:16px;">ກະລຸນາເລືອກລາຍການສັ່ງຊື້</td>';
                                echo '</tr>';
                            }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <h1 class="text-center">ອັດຕາແລກປ່ຽນ</h1>
                            <h3>ເງິນກີບ: <span class="box-change" id="change"><?= number_format($total,2) ?></span> ກີບ</h3>
                            
                            <?php
                                $sel = "SELECT * FROM tbcurrency";
                                $result = mysqli_query($con, $sel) or die ("Error in query: $sel". mysqli_error($sel));
                                while($row = mysqli_fetch_array($result)){
                                    $count = $total/$row['cry_num'];
                                    $dis_cur = $row['cry_num'];
                                    echo "<h5 class='d-flex'><span>ເປັນ$row[cry_disc]: <span class='box-change'>".number_format($count,2)."</span></span> <span class='ml-auto'>ອັດຕາແລກປ່ຽນ: <span class='box-change'>$row[cry_num]</span> ກີບ</span></h5>";
                                }
                            ?>

                        <input type="hidden" name="total" id="total" value="<?= $total ?>">
                        <input type="submit" value="ບັນທຶກການຈອງ" name="confirm" id="confirm" class="form-control btn btn-primary"><br><br>
                        <a href="reserv_add.php" class="form-control btn btn-danger">ກັບຄືນ</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<?php 
    include 'footer.php';
?>
<script>
    // function myPrint(frmCart){
    //     var printdata = document.getElementById(frmCart)
    //     newwin = window.open("");
    //     newwin.document.write(printdata.outerHTML)
    //     newwin.print();
    //     newwin.close();
    // }
    //check price
    // function stopChange(){
    //     var pay=document.getElementById("pay").value;
    //     var total=document.getElementById("total").value;

    //     if(pay == 0 || pay < total){
    //         swal("ພິດພາດ", "ກະລຸນາປ້ອນຈຳນວນເງິນ", "error");
    //         event.preventDefault();
    //         return false;
    //     }
    //     return true;
    // }
</script>


</body>

</html>