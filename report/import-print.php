<?php 
    session_start();
    include '../connectdb.php';

    $getID = $_GET['impid'];
    
    $sql = "SELECT impid,imp_date,st.stid,FirstName,LastName FROM tbimport im INNER JOIN tbstaff st ON im.stid = st.stid WHERE impid = '$getID'";
    $result = mysqli_query($con, $sql) or die("Error in: $sql". mysqli_error($sql));
    $row = mysqli_fetch_array($result);
    
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

<body>
    <div class="background"></div>
    <div class="container" style="max-width: 720px;">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="text-center">
                    <img src="../images/icon.svg" alt="ໂລໂກ້ຮ້ານ" width="150px">
                    <h4>The Book Garden<br />ສວນໜັງສື</h4>
                    <h1 class="mt-5"><u>ລາຍການນຳເຂົ້າ</u></h1>
                </div>
                <p>
                    ສະຖານທີ່: ບ້ານ ຫ້ວຍຫົງ ເມືອງ ໄຊທານີ<br>
                    ເບີໂທ: 020 28 216 900<br>
                    facebook: ຮ້ານປຶ້ມ Book Garden ສວນໜັງສື
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <h5>ລະຫັດນຳເຂົ້າ: <?= $row['impid'] ?></h5>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-right">ວັນທີ: <?= $row['imp_date'] ?></h5>
                    </div>
                    <div class="col-md-6">
                        <h5>ພະນັກງານ: <?= $row['FirstName'] ?> <?= $row['LastName'] ?></h5>
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
                                $sql = "SELECT impNO,bid,bkName,qty,bk.price as b_price,imd.price as total FROM import_detail imd INNER JOIN tbbook bk ON imd.bid=bk.Bkid WHERE impid = '$getID'";
                                $result = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
                                $i=0;
                                $sum = 0;
                                while($row = mysqli_fetch_array($result)){
                                $i++;
                                $sum += $row['total'];
                            ?>
                            <tr>
                                <td><?= $i ?>.</td>
                                <td><?= $row['bkName'] ?></td>
                                <td align="right"><?= number_format($row['b_price'], 2) ?> ກີບ</td>
                                <td align="center"><?= $row['qty'] ?></td>
                                <td align="right"><?= number_format($row['total'], 2) ?> ກີບ</td>
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
                    <div class="ml-auto text-right">
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