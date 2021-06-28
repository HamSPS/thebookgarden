<?php
     include 'check-login.php';


    @$act = $_GET['act']; //ຮັບຄ່າ action ຈາກເມັດທອດ act
    //  add product
    if (isset($_GET['b_id'])) {

        $b_id =  $_GET['b_id']; //ຮັບຄ່າໄອດີຈາກ method b_id
        //add to cart
            if ($act == 'add' && !empty($b_id)) {
                if(isset($_SESSION['order'][$b_id])){
                    $_SESSION['order'][$b_id]++;
                }else{
                    $_SESSION['order'][$b_id]=1;
                }
            }
            //remove product
            if ($act == 'remove' && !empty($b_id)){
                unset($_SESSION['order'][$b_id]);
            }

            //add from order
            if ($act == 'forder' && !empty($b_id)) {
                $qty = $_GET['oqty'];
                if(isset($_SESSION['order'][$b_id])){
                    $_SESSION['order'][$b_id]+=$qty;
                }else{
                    $_SESSION['order'][$b_id]=$qty;
                }
            }
        }
        //update cart
        if ($act == 'update') {
            $amount_array = $_POST['amount'];
            foreach($amount_array as $b_id => $amount){
                $_SESSION['order'][$b_id]=$amount;
            }
        }
        //clear cart
        if ($act == 'cancel'){
            unset($_SESSION['order']);
        }
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
    <title>The Book Garden</title>


    <script src="js/sweetalert.min.js"></script>
    <style>
    body {
        font-family: NotoSansLao;
    }

    table {
        font-size: 15px;
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
            <div class="container-fluid bg-light">
                <div class="row">
                    <div class="col-md-7">
                        <div class="d-flex">
                            <h4 class="mr-auto p-2">ການສັ່ງຊື້</h4>
                            <p class="p-2"><a href="show-order.php" class="btn btn-secondary"><i
                                        class="fa fa-newspaper"></i> ສະແດງລາຍການສັ່ງຊື້</a></p>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">ລາຍການສິນຄ້າ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="rev-tabs" data-toggle="tab" href="#reserv" role="tab"
                                    aria-controls="reserv" aria-selected="false">ລາຍການທີ່ຈອງ</a>
                            </li>
                        </ul>
                        <form method="" action="?act=update">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <table class="table table-bordered" id="example" style="width:100%;">
                                        <thead class="table-success text-center">
                                            <tr>
                                                <th>ລຳດັບ</th>
                                                <th>ຊື່ໜັງສື</th>
                                                <th>ລາຄາ</th>
                                                <th>ຈຳນວນ</th>
                                                <th>ເພີ່ມ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                        $sql = "SELECT * FROM tbbook";
                                        $result = mysqli_query($con, $sql);
                                        $index = 0;
                                        while($row = mysqli_fetch_array($result)){
                                            $index++;
                                        
                                            if($row['stock'] < 5){
                                                echo '<tr class="table-danger text-danger">';
                                                ?>
                                            <td class="text-center" width="20px">
                                                <?= $index ?>.
                                                <input type="hidden" name="bkid" value="<?= $row['bkid'] ?>">
                                            </td>
                                            <td><?= $row['BkName'] ?></td>
                                            <td class="text-right"><?= number_format($row['price'],2) ?> ກີບ</td>
                                            <td class="text-center" width="15px"><?= $row['stock'] ?></td>
                                            <td class="text-center" width="35px">
                                                <a href="order-add.php?b_id=<?= $row["Bkid"] ?>&act=add"
                                                    class="btn btn-success">ເພີ່ມ</a>
                                            </td>
                                            <?php
                                                echo '</tr>';
                                            }else {
                                                ?>
                                            <tr>
                                                <td class="text-center" width="20px">
                                                    <?= $index ?>.
                                                    <input type="hidden" name="bkid" value="<?= $row['bkid'] ?>">
                                                </td>
                                                <td><?= $row['BkName'] ?></td>
                                                <td class="text-right"><?= number_format($row['price'],2) ?> ກີບ</td>
                                                <td class="text-center" width="15px"><?= $row['stock'] ?></td>
                                                <td class="text-center" width="35px">
                                                    <a href="order-add.php?b_id=<?= $row["Bkid"] ?>&act=add"
                                                        class="btn btn-success">ເພີ່ມ</a>
                                                </td>
                                            </tr>

                                            <?php
                                            }
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="reserv" role="tabpanel" aria-labelledby="rev-tabs">
                                    <table class="display table table-hover table-border" id="show">
                                        <thead class="table-success">
                                            <tr>
                                                <th>ລຳດັບ</th>
                                                <th>ລະຫັດການຈອງ</th>
                                                <th>ໜັງສື</th>
                                                <th>ຈຳນວນ</th>
                                                <th>ຈອງໂດຍ</th>
                                                <th>ຄຳສັ່ງ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $sql="SELECT * FROM vw_show_order_sale WHERE sts_id = 1";
                                            $result = mysqli_query($con, $sql);
                                            $i=0;
                                            while(@$row = mysqli_fetch_array($result)){
                                                $i++;
                                        ?>
                                            <tr>
                                                <td><?= $i ?>.</td>
                                                <td><?= $row['rsID'] ?></td>
                                                <td><?= $row['bid'] ?> : <?= $row['bkName'] ?></td>
                                                <td><?= $row['qty'] ?></td>
                                                <td><?= $row['cusName'] ?></td>
                                                <td><a href="order-add.php?b_id=<?= $row["bid"] ?>&oqty=<?= $row["qty"]?>&act=forder"
                                                        class="btn btn-success">ເພີ່ນ</a></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5" style="background-color: #d2d9d6;">
                        <h4 class="mt-3">ລາຍການສັ່ງຊື້</h4>
                        <form action="?act=update" method="post" name="frmCart" id="frmCart">
                            <table class="table table-hover">
                                <thead align="center" style="background: #EAEAEA;">
                                    <tr>
                                        <th><strong>No.</strong></th>
                                        <th><strong>ສິນຄ້າ</strong></th>
                                        <th><strong>ລາຄາ</strong></th>
                                        <th><strong>ຈຳນວນ</strong></th>
                                        <th><strong>ລວມ</strong></th>
                                        <th><strong>ລົບ</strong></th>
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
                                    $max = $row['stock'];
                        ?>
                                    <tr>
                                        <td><?= $i ?>.</td>
                                        <td><?= $row['BkName'] ?></td>
                                        <td><?= number_format($row['price'], 2) ?> ກີບ</td>
                                        <td align="center">
                                            <?php echo "<input type='number' name='amount[$b_id]' value='$qty' min='1' style='width:50px;'/>" ?>
                                        </td>
                                        <td><?= number_format($sum,2) ?> ກີບ</td>
                                        <td align="center"><a href="order-add.php?b_id=<?= $b_id ?>&act=remove"
                                                class="btn btn-danger"><i class="fas fa-trash"></i> ລົບ</a></td>
                                    </tr>
                                    <?php 
                                
                            }
                                ?>
                                    <tr style="background:#e0d0d0;">
                                        <td colspan="5" align="right">ລາຄາລວມ:</td>
                                        <td style="width: 150px;"><?= number_format($total, 2) ?> ກີບ</td>
                                    </tr>
                                    <?php 
                                
                        }else{
                            echo '<tr style="background: #e0d0d0;">';
                            echo '<td colspan="7" align="center" style="font-size:16px;">ກະລຸນາເລືອກລາຍການສັ່ງຊື້</td>';
                            echo '</tr>';
                        }
                                ?>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <!-- <input type="button" value="ສັ່ງຊື້" name="btnSale" id="btnSale" onclick="window.location='Sale_confirm.php'" class="btn btn-primary"> -->
                                <!-- <button class="btn btn-primary" name="btnSale" onclick="window.location='Sale_confirm.php'"><i class="fas fa-shopping-cart"></i> ສັ່ງຊື້</button> -->
                                <?php
                            if (!empty($_SESSION['order'])) {
                                echo "<input type=\"button\" name=\"btnCancel\" value=\"ຍັກເລີກລາຍການສັ່ງຊື້\" onclick=\"window.location='order-add.php?act=cancel'\" class=\"btn btn-danger\">";
                                echo ' | ';
                                echo '<input type="submit" name="editCart" id="editCart" value="ຄຳນວນລາຄາໃໝ່" class="btn btn-warning">';
                                echo ' | ';
                                echo '<a href="order-confirm.php" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> ສັ່ງຊື້</a>';
                            }
                        ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php 
    include 'footer.php';
?>

        <script>
        $(document).ready(function() {
            $('#show').DataTable();
            $('[data-toggle="tooltip"]').tooltip();
        });
        </script>

</body>

</html>