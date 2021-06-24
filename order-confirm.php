<?php
     include 'check-login.php';
     

     if (isset($_POST['confirm'])) {
        mysqli_query($con, "BEGIN");
        $pcid = $_POST['pcid'];
        $pdate = $_POST['pdate'];
        $stid = $_POST['stid'];
        $sup_id = $_POST['supplier'];

        $sql1 = "INSERT INTO tbPurchase VALUES('$pcid','$pdate','$stid','$sup_id',2)";
        $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1". mysqli_error($sql1));


        // echo $sql1;
        //insert ຂໍ້ມູນລົງໃນ sale_detail


        foreach($_SESSION['order'] as $b_id => $qty){
            $sql2 = "INSERT INTO purchase_detail VALUES(null,'$pcid','$b_id','$qty')";
            $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql2". mysqli_error($sql2));
        //     // echo '<br/>';
        //     // echo $sql2;
        }

        if ($result1 && $result2) {
            mysqli_query($con, "COMMIT");
            $msg = '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
            foreach($_SESSION['order'] as $b_id){
                unset($_SESSION['order']);
            }
            header("refresh:2;url=order-add.php");
        }else{
            mysqli_query($con, "ROLLBACK");
            $msg= '<script type="text/javascript"> swal("ຜິດພາດ", "ກະລຸນາກວດສອບຂໍ້ມູນ", "danger") </script>';
        }
     }
     //test Generate ID
     $sql = "SELECT COUNT(pcid) FROM tbPurchase";
     $result = mysqli_query($con, $sql);
     $row = mysqli_fetch_array($result);
    //  if (empty($row[0])) {
    //      $lnum = 1;
    //  }else{
    // }
    $lnum = $row[0] + 1;
    //  $lnum = 1000;
    //  echo $lnum;

     $fchar = "PC";
     
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
    $ch_id = "SELECT * FROM tbPurchase WHERE pcid = '$chk'";
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
    <!-- <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
    <link rel="stylesheet" href="css/adminlte.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="css/all.min.lte.css">  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
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
    </style>
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">
<?php 
     include 'menu.php';
?>
<div class="content">
    <?= @$msg ?>
    <div class="container-fluid" style="background:white;height:100%;">
        <div class="row mx-auto d-block" style="background: #d2d9d6;">
            <div class="col-md-6 p-2 m-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" name="frmCart" id="frmCart">
                                <div class="row">
                                    <div class="col-md-10 m-auto">
                                        <img src="images/icon.svg" class="mx-auto d-block m-4 img-circle" width="150px" alt="ຮ້ານ The Book Garden">
                                        <h1 class="text-center">ລາຍການສັ່ງຊື້</h1>
                                    </div>
                                        <div class="col-md-10 m-auto">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pcid">ລະຫັດການສັ່ງຊື້</label>
                                                        <input class="form-control" type="text" id="pcid" name="pcid" value="<?= $autoID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" required="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdate">ວັນ, ເດືອນ, ປີ</label>
                                                        <input class="form-control" type="datetime" id="pdate" name="pdate" value="<?= $date ?>" required="">
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="stid">ພະນັກງານ</label>
                                                        <input class="form-control" type="text" id="stName" name="stName" value="<?= $_SESSION['name'] ?>" readonly="">
                                                        <input class="form-control" type="hidden" id="stid" name="stid" value="<?= $_SESSION['empID'] ?>" readonly="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="supplier">ຜູ້ສະໜອງ</label>
                                                        <select name="supplier" id="supplier" required="true" class="form-control">
                                                            <option value="">----ເລືອກຜູ້ສະໜອງ----</option>
                                                            <?php
                                                                $sql = "SELECT * FROM tbsuppliers";
                                                                $result = mysqli_query($con, $sql);
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    ?>
                                                                    <option value="<?= $row['sup_id'] ?>"  <?php if (@$sup_id == $row['sup_id']) echo 'selected'; ?>  ><?= $row['sup_Name'] ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                        </select>
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
                                        if (!empty($_SESSION['order'])) {
                                            foreach($_SESSION['order'] as $b_id => $qty){
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
                                <input type="submit" value="ຢືນຍັນການສັ່ງຊື້" name="confirm" id="confirm" class="btn btn-primary"> 
                                <a href="order-add.php" class="btn btn-danger">ກັບຄືນ</a>
        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
    include 'footer.php';
?>



</body>

</html>