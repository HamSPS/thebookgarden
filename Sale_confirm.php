<?php
     include 'check-login.php';
     
     //test Generate ID
     $sql = "SELECT COUNT(SlID) FROM tbsale";
     $result = mysqli_query($con, $sql);
     $row = mysqli_fetch_array($result);
    //  if (empty($row[0])) {
    //      $lnum = 1;
    //  }else{
    // }
    $lnum = $row[0] + 1;
    //  $lnum = 1000;
    //  echo $lnum;

     $fchar = "BG";
     
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

    // echo $fchar;
    // echo $znum;
    // echo $lnum;

    $autoID = $fchar.$znum.$lnum;
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
        <div class="row mx-auto d-block">
            <div class="col-md-12">
                <form action="saveorder.php" method="post" name="frmCart" id="frmCart" onsubmit="return stopChange()">
                <div class="row">
                    <div class="col-md-8 bill-background">

                        <div class="row ml-5">
                            <div class="col-md-10">
                                <img src="images/icon.svg" class="mx-auto d-block m-4 img-circle" width="150px" alt="ຮ້ານ The Book Garden">
                                <h1 class="text-center">ໃບບິນສັ່ງຊື້</h1>
                            </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="SlID">ລະຫັດການຂາຍ</label>
                                                <input class="form-control" type="text" id="SlID" name="SlID" value="<?= $autoID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" required="" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sdate">ວັນ, ເດືອນ, ປີ</label>
                                                <input class="form-control" type="datetime" id="sdate" name="sdate" value="<?= $date ?>" required="">
                                            </div>
                                        </div>
                                            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stid">ລະຫັດພະນັກງານ</label>
                                                <input class="form-control" type="text" id="stid" name="stid" value="<?= $_SESSION['empID'] ?>" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stName">ຊື່ພະນັກງານ</label>
                                                <input class="form-control" type="text" id="stName" name="stName" value="<?= $_SESSION['name'] ?>" readonly="">
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
                                if (!empty($_SESSION['cart'])) {
                                    foreach($_SESSION['cart'] as $b_id => $qty){
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
                        <h1 class="text-center">ຊຳລະເງິນ</h1>
                        <div class="form-group">
                            <label for="pay">ຈຳນວນທີ່ຈ່າຍ</label>
                            <?php
                                $pay = 0;
                            ?>
                            <input type="text" name="pay" id="pay" class="form-control" value="0" onkeyup="calc()">
                            <!-- <label for="change">ເງິນທອນ</label>
                            <input type="text" name="change" id="change" class="form-control" value="" readonly> -->
                        </div>
                            <h3>ເງິນທອນ: <span class="box-change" id="change">0</span> ກີບ</h3>
                            <?php
                                $sel = "SELECT * FROM tbcurrency";
                                $result = mysqli_query($con, $sel) or die ("Error in query: $sel". mysqli_error($sel));
                                while($row = mysqli_fetch_array($result)){
                                    $count = $total/$row['cry_num'];
                                    $dis_cur = $row['cry_num'];
                                    echo "<p class='d-flex'><span>ເປັນ$row[cry_disc]: ".number_format($count,2)."</span> <span class='ml-auto'>ອັດຕາແລກປ່ຽນ: $row[cry_num] ກີບ</span></p>";
                                }
                            ?>

                        <input type="hidden" name="total" id="total" value="<?= $total ?>">
                        <input type="submit" value="ຢືນຍັນການສັ່ງຊື້" name="confirm" id="confirm" class="form-control btn btn-primary"><br><br>
                        <a href="frmSale.php" class="form-control btn btn-danger">ກັບຄືນ</a>
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
    function calc(){
        var val=document.getElementById("pay").value;
        var total=document.getElementById("total").value;
        var change = val-total;
        // console.log(change);
        document.getElementById("change").innerHTML= change;
    }
    function stopChange(){
        // var pay=document.getElementById("pay").value;
        // var total=document.getElementById("total").value;

        // if(pay == "0" || pay == null){
        //     swal("ພິດພາດ", "ກະລຸນາປ້ອນຈຳນວນເງິນ", "error");
        //     // alert(100000 < 75000)
        //     event.preventDefault();
        //     return false;
        // }else if(pay < total){
        //     swal("ພິດພາດ", "ກະລຸນາປ້ອນຈຳນວນເງິນໃຫ້ຄົບຖ້ວນ", "error");
        //     // alert(pay < total);
        //     // console.log("ຄ່າແມ່ນ:​ "+ pay +" < "+ total);
        //     event.preventDefault();
        //     return false;
        // }
        // return true;

        let pay = document.forms["frmCart"]["pay"].value;
        let change = document.forms["frmCart"]["total"].value;
        if (pay == "" || pay == 0){
            swal("ພິດພາດ", "ກະລຸນາປ້ອນຈຳນວນເງິນ", "error");
            return false;
        }else if(pay < change){
            swal("ພິດພາດ", "ກະລຸນາປ້ອນຈຳນວນເງິນໃຫ້ຄົບຖ້ວນ", "error");
            return false;
        }else{
            
            return true;
        }
    }
</script>


</body>

</html>