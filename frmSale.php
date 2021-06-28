<?php
     include 'check-login.php';
     
    $where = " ";
    $category = "";
    if (isset($_GET['cat'])) {
        $category = $_GET['cat'];
        $where = empty($category) ? " " : "WHERE catID='$category'";
    }


    //ຄົ້ນຫາ
    @$term = "";
    if (isset($_GET['src'])) {
        $term = $_GET['term'];
    }

    @$act = $_GET['act']; //ຮັບຄ່າ action ຈາກເມັດທອດ act
    //  add product
    if (isset($_GET['b_id'])) {

        $b_id =  $_GET['b_id']; //ຮັບຄ່າໄອດີຈາກ method b_id
        //add to cart
            if ($act == 'add' && !empty($b_id)) {
                if(isset($_SESSION['cart'][$b_id])){
                    $_SESSION['cart'][$b_id]++;
                }else{
                    $_SESSION['cart'][$b_id]=1;
                }
            }
            //remove product
            if ($act == 'remove' && !empty($b_id)){
                unset($_SESSION['cart'][$b_id]);
            }
        }
        //update cart
        if ($act == 'update') {
            $amount_array = $_POST['amount'];
            foreach($amount_array as $b_id => $amount){
                $_SESSION['cart'][$b_id]=$amount;
            }
        }
        //clear cart
        if ($act == 'cancel'){
            unset($_SESSION['cart']);
        }
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
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/all.min.lte.css">
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8">
                        <h4>ສະແດງໜັງສື</h4>
                        <div class="form-row">
                            <div class="col-md-4">
                                <form action="" method="get" class="form-inline">
                                    <label>
                                        <input type="text" name="term" class="form-control" id="term"
                                            placeholder="ຄົ້ນຫາໜັງສືຈາກຊື່ໜັງສື" value="<?= @$term ?>">
                                        <input type="submit" name="src" class="btn btn-success ml-2" value="ຄົ້ນຫາ">
                                    </label>
                                </form>
                            </div>
                            <div class="col-md-5">
                                <form method="get" class="form-inline">
                                    <label id="cat" class="my-1 mr-2">ເລືອກປະເພດ : </label>
                                    <select class="form-control" style="width: 150px;" id="cat" name="cat"
                                        onchange="form.submit()">
                                        <option value="">ເລືອກປະເພດ</option>
                                        <?php
                                    $sql = "SELECT * FROM tbcategory";
                                    $result = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?= $row['catID'] ?>"
                                            <?php if ($row['catID'] == @$category) echo "selected"; ?>>
                                            <?= $row['catName'] ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>


                                </form>
                            </div>
                            <div class="text-right"><a href="sale_show.php" class="btn btn-secondary"><i
                                        class="fas fa-receipt"></i>
                                    ສະແດງປະຫວັດການຂາຍ</a>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <?php
                            //  if (empty($category)) {
                            //      $sql = "SELECT * FROM tbbook order by bkid DESC";
                            //  }else{
                            //      $sql = "SELECT * FROM tbbook WHERE catID = '$category' order by bkid DESC";
                            //  }
                            if (!empty($term)) {
                                $sql = "SELECT * FROM tbbook WHERE BkName like '%$term%' ORDER BY bkid DESC";
                            }elseif (!empty($category)) {
                                $sql = "SELECT * FROM tbbook WHERE catID like '%$category%' ORDER BY bkid DESC";
                            }else{
                                $sql = "SELECT * FROM tbbook ORDER BY bkid DESC";
                            }
                            $result = mysqli_query($con ,$sql);
                            // echo $sql;
                        
                        while($row = mysqli_fetch_assoc($result)){
                            
                        ?>
                            <div class="col-12 col-sm-3">
                                <div class="card card-product-grid">

                                    <img class="card-img-top fit-image" src="<?= $row['img'] ?>" alt="ຮູບໜັງສ່">
                                    <div class="card-body">
                                        <p><u>ຊື່ໜັງສື:</u> <?= $row['BkName'] ?></p>
                                        <p class="card-text">ລາຄາ: <?= number_format($row['price'], 2) ?> ກີບ</p>
                                        <p class="card-text">ຈຳນວນ: <?= $row['stock'] ?></p>
                                        <input type="hidden" name="hidden_name" value="<?= $row['bkName'] ?>">
                                        <input type="hidden" name="hidden_price" value="<?= $row['price'] ?>">
                                        <!-- <input type="submit" name="add" class="btn btn-success" form-control value="ເພີ່ນສິນຄ້າ"> -->
                                        <!-- <a href="frmSale.php?b_id=<?= $row['bkID'] ?>&act=add" class="btn btn-success"><i class="fas fa-shopping-cart"></i> ເພີ່ມສິນຄ້າ</a> -->
                                        <?php
                                        if ($row['stock'] == 0 || $row['stock'] < 0) {
                                            echo '<div class="ribbon ribbon-top-left"><span>ສິນຄ້າໜົດ</span></div>';
                                            echo '<input type="submit" value="ສິນຄ້າໝົດ" class="btn btn-danger" disabled>';
                                        }else{
                                            echo "<a href=\"frmSale.php?b_id=$row[Bkid]&act=add\" class=\"btn btn-success\"><i class=\"fas fa-shopping-cart\" style=\"color: green\"></i> ເພີ່ມສິນຄ້າ</a>";
                                        }
                                        ?>
                                        <!-- <a href="frmSale.php?b_id=<?= $row["Bkid"] ?>&act=add" class="btn btn-success"><i class="fas fa-shopping-cart" style="color: green"></i> ເພີ່ມສິນຄ້າ</a> -->

                                    </div>
                                </div>
                            </div>
                            <?php }

                        ?>
                        </div>
                    </div>
                    <div class="col-md-4" style="background-color: #d2d9d6;">
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
                        if (!empty($_SESSION['cart'])) {
                            foreach($_SESSION['cart'] as $b_id => $qty){
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
                                            <?php echo "<input type='number' name='amount[$b_id]' value='$qty' max='$max' min='1' style='width:50px;'/>" ?>
                                        </td>
                                        <td><?= number_format($sum,2) ?> ກີບ</td>
                                        <td align="center"><a href="frmSale.php?b_id=<?= $b_id ?>&act=remove"
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
                        if (!empty($_SESSION['cart'])) {
                            echo "<input type=\"button\" name=\"btnCancel\" value=\"ຍັກເລີກລາຍການສັ່ງຊື້\" onclick=\"window.location='frmSale.php?act=cancel'\" class=\"btn btn-danger\">";
                            echo ' | ';
                            echo '<input type="submit" name="editCart" id="editCart" value="ຄຳນວນລາຄາໃໝ່" class="btn btn-warning">';
                            echo ' | ';
                            echo '<a href="Sale_confirm.php" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> ສັ່ງຊື້</a>';
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


</body>

</html>