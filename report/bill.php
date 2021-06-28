<?php 
    session_start();
    include '../connectdb.php';

    $getID = $_SESSION['bill'];
    // echo $getID;
    $sql = "SELECT slID,sl_date,tbsale.stid,firstname, lastName, total_price, sl_pay FROM tbsale inner JOIN tbstaff on tbsale.stID=tbstaff.stid WHERE slID = '$getID'";
    $query = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
    $row = mysqli_fetch_array($query);

    $sl_id = $row['slID'];
    $sl_name = $row['firstname'] .' '. $row['lastName'];
    $sl_date = date("Y-m-d");
    $sl_time = date("H:i:s");
    $sl_total = $row['total_price'];
    $sl_pay = $row['sl_pay'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>ໃບບິນສິນຄ້າ</title>
    <style>
    body {
        font-family: NotoSansLao;
    }

    .background {
        background: url("../images/bill-background.png");
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

<body onload="myPrint()">
    <div class="background"></div>
    <div class="container" style="max-width: 720px;">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="text-center">
                    <img src="../images/icon.svg" alt="ໂລໂກ້ຮ້ານ" width="150px">
                    <h4>The Book Garden<br />ສວນໜັງສື</h4>
                    <h1 class="mt-5"><u>ໃບບິນສິນຄ້າ</u></h1>
                </div>
                <p>
                    ສະຖານທີ່: ບ້ານ ຫ້ວຍຫົງ ເມືອງ ໄຊທານີ<br>
                    ເບີໂທ: 020 28 216 900<br>
                    facebook: ຮ້ານປຶ້ມ Book Garden ສວນໜັງສື
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <h5>ລະຫັດໃບບິນ: <?= $sl_id ?></h5>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-right">ວັນທີຂາຍ: <?= $sl_date ?></h5>
                    </div>
                    <div class="col-md-6">
                        <h5>ພະນັກງານ: <?= $sl_name ?></h5>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-right">ເວລາ: <?= $sl_time ?></h5>
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
                                $sql = "SELECT slNo,sale_detail.bkID,bkName,tbbook.price AS b_price,qty,sale_detail.price as t_price FROM sale_detail inner JOIN tbbook on sale_detail.bkID=tbbook.Bkid WHERE slID = '$sl_id'";
                                $result = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
                                $i=0;
                                while($row = mysqli_fetch_array($result)){
                                $i++;
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
                                <td align="right"><?= number_format($sl_total, 2) ?> ກີບ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex">
                    <div>
                        <p>ເງິນຈ່າຍ: <?= number_format($sl_pay, 2) ?> ກີບ</p>
                        <?php
                            $sel = "SELECT * FROM tbcurrency";
                            $result = mysqli_query($con, $sel) or die ("Error in query: $sel". mysqli_error($sel));
                            while($row = mysqli_fetch_array($result)){
                                $count = $sl_total/$row['cry_num'];
                                $dis_cur = $row['cry_num'];
                                echo "<p>ເປັນ$row[cry_disc]: ".number_format($count,2)."</span></p>";
                            }
                            ?>
                    </div>
                    <div class="ml-auto text-right">
                        <p>ເງິນທອນ: <?= number_format($sl_pay -  $sl_total, 2) ?> ກີບ</p>
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
    </div>
    </div>
    <script src="../js/sweetalert.min.js"></script>
</body>

</html>

<script>
//print on load
function myPrint() {
    newwin = window.print();
    // newwin.close()
    var prt = 1;
    //    newwin.print();
    if (prt == 1) {
        // alert("ບັນທຶກຂໍ້ມູນສຳເລັດ");
        swal("ສຳເລັດ", "ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ", "success").then(function() {
            window.location = "../frmSale.php"
        })
        // setTimeout(function(){location.href="../frmSale.php"} , 5000);
    }
}
</script>