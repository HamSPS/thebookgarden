<?php 
    session_start();
    include 'connectdb.php';

    $getID = $_GET['revID'];
    
    $sql = "SELECT rsID,revDate,tbreserv.stid AS empID,firstname, lastName,tbreserv.cusid,cusName FROM tbreserv inner JOIN tbstaff on tbreserv.stID=tbstaff.stid inner JOIN tbcustomer on tbreserv.cusid = tbcustomer.cusID WHERE rsID = '$getID'";
    $query = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
    $row = mysqli_fetch_array($query);

    $rs_id = $row['rsID'];
    $rs_emp = $row['empID'];
    $rs_name = $row['firstname'] .' '. $row['lastName'];
    $rs_rdate = $row['revDate'];
    $rs_cdate = date("Y-m-d H:i:s");
    $rs_cus = $row['cusName'];
    $p_sum = 0;
    // $rs_total = $row['total_price'];
    // $rs_pay = $row['sl_pay'];

    $sql2 = "SELECT rsNO,bid,bkName,tbbook.price AS b_price,qty,reserv_detail.price as t_price FROM reserv_detail inner JOIN tbbook on reserv_detail.bid=tbbook.Bkid WHERE rsID = '$rs_id'";
    $result2 = mysqli_query($con, $sql2) or die("Error in query: $sql2". mysqli_error($sql2));
    while($orderRow = mysqli_fetch_assoc($result2)){
        $b_id = $orderRow['bid'];
        $qty = $orderRow['qty'];

        $p_sum += $orderRow['t_price'];

        $_SESSION['rev_bill'][$b_id]=$qty;
    }

    if(isset($_POST['goBack'])){
        unset($_SESSION['rev_bill']);
        header("location: Reserv-manage.php");
    }

    if (isset($_POST['saveorder'])) {
        mysqli_query($con, "BEGIN");
        $sID = $rs_id;
        $stID = $rs_emp;
        $sdate = $rs_cdate;
        $total = $p_sum;


        //insert ຂໍ້ມູນລົງໃນ tbsale
        $sql1 = "INSERT INTO tbsale VALUES('$sID','$sdate','$stID','$total',null)";
        $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1". mysqli_error($sql1));


        $sql5 = "UPDATE tbreserv SET receiveDate = '$sdate', sts_ID = '4' WHERE rsID = '$sID'";
        $result5 = mysqli_query($con, $sql5) or die ("Error in query: $sql5". mysqli_error($sql5));
        // echo $sql1;
        //insert ຂໍ້ມູນລົງໃນ sale_detail


        foreach($_SESSION['rev_bill'] as $b_id => $qty){
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
            $msg = '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
            foreach($_SESSION['rev_bill'] as $b_id){
                unset($_SESSION['rev_bill']);
            }
            header("refresh:2; url=Reserv-manage.php");
        }else{
            mysqli_query($con, "ROLLBACK");
            $msg='<script type="text/javascript"> swal("ຜິດພາດ", "ກະລຸນາກວດສອບຂໍ້ມູນ", "danger") </script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>ໃບບິນສິນຄ້າ</title>

    <script src="js/sweetalert.min.js"></script>

    <style>
        body {
            font-family: NotoSansLao;
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

        p {
            font-size: larger;
        }
    </style>
</head>

<body>
    <div class="background"></div>
        <div class="container" style="max-width: 720px;">
            <form action="" method="post">
                <?= @$msg ?>
                <div class="row">
                    <div class="col-md-12 mt-3 text-center">
                        <input type="submit" value="ບັນທຶກການຂາຍ" id="saveorder" name="saveorder" class="btn btn-success">
                        <button type="submit" class="btn btn-primary" id="print" onclick="PrintDiv()"><i class="fas fa-print"></i> ພິມໃບບິນ</button>
                        <button class="btn btn-danger" id="goBack" name="goBack" onclick="goBack()">ກັບຄືນ</button>
                    </div>
                </div>
                <div class="row" id="bill-print">
                    <div class="col-md-12 mt-5">
                        <div class="text-center">
                            <img src="images/icon.svg" alt="ໂລໂກ້ຮ້ານ" width="150px">
                            <h4>The Book Garden<br />ສວນໜັງສື</h4>
    
    
    
    
    
    
                            <h1 class="mt-5"><u>ໃບບິນສິນຄ້າ</u></h1>
                        </div>
                        <p>
                            ສະຖານທີ່: ບ້ານ ຫ້ວຍຫົງ ເມືອງ ໄຊທານີ<br>
                            ເບີໂທ: 020 28 216 900<br>
                            facebook: ຮ້ານປຶ້ມ Book Garden ສວນໜັງສື
                        </p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                    <h5>ລະຫັດໃບບິນ: <span class=""><?= $rs_id ?></span></h5>
                                    <h5>ພະນັກງານ: <?= $rs_name ?></h5>
                                    <h5>ລູກຄ້າ: <?= $rs_cus ?></h5>
                            </div>
                            <div class="col-md-6">
                                    <h5 class="text-right">ວັນທີຂາຍ: <?= $rs_rdate ?></h5>
                                    <h5 class="text-right">ວັນທີຮັບ: <?= $rs_cdate ?></h5>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                        $sql = "SELECT rsNO,bid,bkName,tbbook.price AS b_price,qty,reserv_detail.price as t_price FROM reserv_detail inner JOIN tbbook on reserv_detail.bid=tbbook.Bkid WHERE rsID = '$rs_id'";
                                        $result = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
                                        $i=0;
                                        $sum=0;
                                        while($row = mysqli_fetch_array($result)){
                                        $i++;
                                        $total_price = $row['b_price'] * $row['qty'];
                                        $sum+= $total_price;
                                    ?>
                                    <tr>
                                        <td><?= $i ?>.</td>
                                        <td><?= $row['bkName'] ?></td>
                                        <td align="right"><?= number_format($row['b_price'], 2) ?> ກີບ</td>
                                        <td align="center"><?= $row['qty'] ?></td>
                                        <td align="right"><?= number_format($row['t_price'], 2) ?> ກີບ</td>
                                    </tr>
                                    <?php } ?>
                                    <tr style="background:#e0d0d0;">
                                        <td colspan="4" align="right">ລາຄາລວມ:</td>
                                        <td align="right"><?= number_format($sum, 2) ?> ກີບ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
    
                        <div class="d-flex">
                            <div>
                                <!-- <p>ເງິນຈ່າຍ: <?= number_format($rs_pay, 2) ?> ກີບ</p> -->
                                <?php
                                    $sel = "SELECT * FROM tbcurrency";
                                    $result = mysqli_query($con, $sel) or die ("Error in query: $sel". mysqli_error($sel));
                                    while($row = mysqli_fetch_array($result)){
                                        $count = $sum/$row['cry_num'];
                                        $dis_cur = $row['cry_num'];
                                        echo "<p>ເປັນ$row[cry_disc]: ".number_format($count,2)."</span></p>";
                                    }
                                    ?>
                            </div>
                            <div class="ml-auto text-right">
                                <!-- <p>ເງິນທອນ: <?= number_format($sum -  $total_price, 2) ?> ກີບ</p> -->
                                <p><u>ອັນຕາແລກປ່ຽນ</u></p>
                                <?php
                                    $sel = "SELECT * FROM tbcurrency";
                                    $result = mysqli_query($con, $sel) or die ("Error in query: $sel". mysqli_error($sel));
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<p>$row[cry_disc]: $row[cry_num] ກີບ</p>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <form action="" method="get">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ເລືອກຂໍ້ມູນລູກຄ້າ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped" id="cuShow">
            <thead class="table-info">
                <tr>
                    <th>ລະຫັດ</th>
                    <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th>ເພດ</th>
                    <th>ທີ່ຢູ່</th>
                    <th>ເບີໂທ</th>
                    <th>ອີເມວ</th>
                    <th>ເລືອກ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM tbbook";
                    $result = mysqli_query($con, $sql);

                    while($row = mysqli_fetch_array($result)){
                    ?>
                        <tr>
                            <td><?= $row['Bkid'] ?></td>
                            <td><?= $row['BkName'] ?></td>
                            <td><?= $row['price'] ?></td>
                            <td><?= $row['stock'] ?></td>
                            <td><?= $row['author'] ?></td>
                            <td><?= $row['img'] ?></td>
                            <td><a href="reserv_add.php?act=acus&cusid=<?= $row['cusID'] ?>&cusName=<?= $row['cusName'] ?>" class="btn btn-success">ເພີ່ມ</a></td>
                        </tr>
                    <?php
                    }
                ?>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <button type="button" class="btn btn-danger" data-dismiss="modal">ຍົກເລີກ</button>
      </div>
    </div>
    </form>
  </div>
</div>

    <script>
        var hidden = false;
        var pbody = `
        <html>
        <head><link rel="stylesheet" href="css/style.css"> <link rel="stylesheet" href="css/bootstrap.min.css"><style>body{font-family:NotoSansLao;}</style></head>

        <body onload="window.print()">
        `+ divToPrint.innerHTML +`
        </body>
        </html>
        `;
        function PrintDiv() {    
            var divToPrint = document.getElementById('bill-print');
            var popupWin = window.open('', '_blank', 'width=1280,height=720');
            popupWin.document.open();
            popupWin.document.write('<html><head><link rel="stylesheet" href="css/style.css"> <link rel="stylesheet" href="css/bootstrap.min.css"><style>body{font-family:NotoSansLao;}</style></head><body onload="window.print()">'+ divToPrint.innerHTML +'</body></html>');
            popupWin.document.close();
            }
        function goBack(){
            window.history.back()
        }
    </script>
</body>

</html>