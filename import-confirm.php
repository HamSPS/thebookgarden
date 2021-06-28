<?php
     include 'check-login.php';
     
    $getID = $_GET['pcid'];
    $act = $_GET['act'];

    if ($act == 'add') {
        $add_order = "SELECT bid,bkName,qty,price,price * qty as total FROM purchase_detail pd inner JOIN tbbook bk on pd.bid=bk.Bkid WHERE pcid = '$getID'";
        $query = mysqli_query($con, $add_order);
        while ($row = mysqli_fetch_array($query)) {
            $_SESSION['import'][$row['bid']] = $row['qty'];
        }
    }

    if ($act == 'remove') {
        $b_id = $_GET['b_id'];
        
        unset($_SESSION['import'][$b_id]);
    }
    
    if (isset($_POST['update'])) {
        $amount_array = $_POST['amount'];
        foreach($amount_array as $b_id => $amount){
            $_SESSION['import'][$b_id]=$amount;
        }
    }

    //  if (isset($_POST['confirm'])) {
    //     mysqli_query($con, "BEGIN");
    //     $impid = $_POST['impid'];
    //     $pdate = $_POST['pdate'];
    //     $stid = $_POST['stid'];

    //     $sql1 = "INSERT INTO tbimport VALUES('$impid','$pdate','$stid')";
    //     $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1". mysqli_error($sql1));


    //     // echo $sql1;
    //     //insert ຂໍ້ມູນລົງໃນ sale_detail


    //     $sql2 = "SELECT bid,bkName,qty,price,price * qty as total FROM purchase_detail pd inner JOIN tbbook bk on pd.bid=bk.Bkid WHERE pcid = '$getID'";
    //     $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql2". mysqli_error($sql2));
    //     while ($row = mysqli_fetch_array($result2)) {
    //         $sql3 = "INSERT INTO import_detail VALUES(null,'$impid','$row[bid]','$row[qty]','$row[total]')";
    //         $result3 = mysqli_query($con, $sql3) or die("Error in query: $sql3". mysqli_error($sql3));

    //         $sql4 = "UPDATE tbbook SET stock = stock + $row[qty] WHERE Bkid = '$row[bid]'";
    //         $result4 = mysqli_query($con, $sql4) or die("Error in query: $sql4". mysqli_error($sql4));
    //     }

    //     if ($result1 && $result3) {
    //         mysqli_query($con, "COMMIT");
    //         $msg = '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
    //         mysqli_query($con, "UPDATE tbpurchase SET sts_id = 4 WHERE pcid = '$getID'");
    //         header("refresh:2;url=import.php");
    //     }else{
    //         mysqli_query($con, "ROLLBACK");
    //         $msg = '<script type="text/javascript"> swal("ຜິດພາດ", "ກະລຸນາກວດສອບຂໍ້ມູນ", "danger") </script>';
    //     }
    //  }
     //test Generate ID
     $sql = "SELECT COUNT(impid) FROM tbimport";
     $count = mysqli_query($con, $sql);
     $row = mysqli_fetch_array($count);
     if ($row[0] == 0) {
         $lnum = 1;
     }else{
        $lnum = $row[0] + 1;
     }

     $fchar = "IM";
     
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
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
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
    body {
        font-family: NotoSansLao;
    }

    .fit-image {
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
            <div class="container-fluid">
                <div class="row mx-auto d-block">
                    <div class="col-md-8 p-2 m-auto">
                        <div class="card">
                            <div class="card-body">
                                <form action="save_import.php?pcid=<?= $getID ?>" method="post" name="frmCart"
                                    id="frmImport">
                                    <div class="row">
                                        <div class="col-md-10 m-auto">
                                            <!-- <img src="images/icon.svg" class="mx-auto d-block m-4 img-circle"
                                                width="100px" alt="ຮ້ານ The Book Garden"> -->
                                            <h1 class="text-center">ລາຍການນຳເຂົ້າ</h1>
                                        </div>
                                        <div class="col-md-10 m-auto">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="impid">ລະຫັດການສັ່ງຊື້</label>
                                                        <input class="form-control" type="text" id="impid" name="impid"
                                                            value="<?= $autoID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ"
                                                            required="" readonly="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdate">ວັນ, ເດືອນ, ປີ</label>
                                                        <input class="form-control" type="datetime" id="pdate"
                                                            name="pdate" value="<?= $date ?>" required="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="stid">ພະນັກງານ</label>
                                                        <input class="form-control" type="text" id="stName"
                                                            name="stName" value="<?= $_SESSION['name'] ?>" readonly="">
                                                        <input class="form-control" type="hidden" id="stid" name="stid"
                                                            value="<?= $_SESSION['empID'] ?>" readonly="">
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
                                        $sum = 0;
                                        $i = 0;
                                        // $sql ="SELECT bid,bkName,qty,price,price * qty as total FROM purchase_detail pd inner JOIN tbbook bk on pd.bid=bk.Bkid WHERE pcid = '$getID'";
                                        // $query = mysqli_query($con, $sql);
                                        
                                        if (!empty($_SESSION['import'])) {
                                            // while($row = mysqli_fetch_array($query)){
                                                foreach($_SESSION['import'] as $b_id => $qty){
                                                $i++;
                                                $book = mysqli_query($con, "SELECT * FROM tbbook WHERE Bkid = '$b_id'");
                                                $row = mysqli_fetch_array($book);
                                                $sum += $row['price'] * $qty;
                                                
                                    ?>
                                            <tr>
                                                <td><?= $i ?>.</td>
                                                <td><?= $row['BkName'] ?></td>
                                                <td align="right"><?= number_format($row['price'], 2) ?> ກີບ</td>
                                                <td align="center">
                                                    <?= $qty ?>
                                                </td>
                                                <td align="right"><?= number_format($row['price'] * $qty,2) ?> ກີບ</td>
                                            </tr>
                                            <?php 
                                            
                                        }
                                            ?>
                                            <tr style="background:#e0d0d0;">
                                                <td colspan="4" align="right">ລາຄາລວມ:</td>
                                                <td align="right"><?= number_format($sum, 2) ?> ກີບ</td>
                                            </tr>
                                            <?php 
                                            
                                    }
                                    else{
                                        echo '<tr style="background: #e0d0d0;">';
                                        echo '<td colspan="6" align="center" style="font-size:16px;">ກະລຸນາເລືອກລາຍການສັ່ງຊື້</td>';
                                        echo '</tr>';
                                    }
                                            ?>
                                        </tbody>
                                    </table>
                                    <input type="submit" value="ຢືນຍັນການສັ່ງຊື້" name="confirm" id="confirm"
                                        class="btn btn-primary">
                                    <a href="#" class="btn btn-success click_update" data-toggle="modal"
                                        data-target="#updateform">ແກ້ໄຂ</a>
                                    <!-- <button type="submit" class="btn btn-success" name="update"
                                        id="update">ແກ້ໄຂ</button> -->
                                    <a href="import.php?act=cancel" class="btn btn-danger">ກັບຄືນ</a>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <form action="" method="post">
            <div class="modal fade" id="updateform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" style="max-width: 720px" role="document">
                    <div class="modal-content">
                        <div class="modal-header alert alert-success">
                            <h5 class="modal-title" id="exampleModalLabel">ແກ້ໄຂລາຍການນຳເຂົ້າ</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-hover">
                                <thead align="center" style="background: #EAEAEA;">
                                    <tr>
                                        <th><strong>No.</strong></th>
                                        <th><strong>ສິນຄ້າ</strong></th>
                                        <th><strong>ລາຄາ</strong></th>
                                        <th><strong>ຈຳນວນ</strong></th>
                                        <th><strong>ລວມ</strong></th>
                                        <th>ລົບ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sum = 0;
                                        $i = 0;
                                        // $sql ="SELECT bid,bkName,qty,price,price * qty as total FROM purchase_detail pd inner JOIN tbbook bk on pd.bid=bk.Bkid WHERE pcid = '$getID'";
                                        // $query = mysqli_query($con, $sql);
                                        
                                        if (!empty($_SESSION['import'])) {
                                            // while($row = mysqli_fetch_array($query)){
                                                foreach($_SESSION['import'] as $b_id => $qty){
                                                $i++;
                                                $book = mysqli_query($con, "SELECT * FROM tbbook WHERE Bkid = '$b_id'");
                                                $row = mysqli_fetch_array($book);
                                                $sum += $row['price'] * $qty;
                                                
                                    ?>
                                    <tr>
                                        <td><?= $i ?>.</td>
                                        <td><?= $row['BkName'] ?></td>
                                        <td align="right"><?= number_format($row['price'], 2) ?> ກີບ</td>
                                        <td align="center">
                                            <?php echo "<input type='number' name='amount[$b_id]' value='$qty' min='1' style='width:50px;'/>" ?>
                                        </td>
                                        <td align="right"><?= number_format($row['price'] * $qty,2) ?> ກີບ</td>
                                        <td>
                                            <a href="import-confirm.php?b_id=<?= $b_id ?>&act=remove"
                                                class="btn btn-danger"><i class="fas fa-trash"></i>
                                                ລົບ</a>
                                        </td>
                                    </tr>
                                    <?php 
                                            
                                        }
                                            ?>
                                    <tr style="background:#e0d0d0;">
                                        <td colspan="4" align="right">ລາຄາລວມ:</td>
                                        <td align="right"><?= number_format($sum, 2) ?> ກີບ</td>
                                        <td></td>
                                    </tr>
                                    <?php 
                                            
                                    }
                                    else{
                                        echo '<tr style="background: #e0d0d0;">';
                                        echo '<td colspan="6" align="center" style="font-size:16px;">ກະລຸນາເລືອກລາຍການສັ່ງຊື້</td>';
                                        echo '</tr>';
                                    }
                                            ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">ປິດ</button>
                            <button type="submit" name="update" class="btn btn-outline-success">ແກ້ໄຂ</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php 
    include 'footer.php';
?>

</body>

</html>