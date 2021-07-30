<?php 
    include_once 'check-login.php';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/all.min.lte.css">
    <title>Book Garden</title>
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">
        <?php
        include 'menu.php';
    ?>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 bg-white" style="font-family:NotoSansLao;">
                        <div class="box">
                            <div class="box-body">
                                <div class="col-sm-12">
                                    <div class="mt-3">
                                        <a href="frmSale.php" class="btn btn-primary"><i
                                                class="fas fa-shopping-cart"></i> ຂາຍໜ້າຮ້ານ</a>
                                        <a href="reserv-manage.php" class="btn btn-info"><i
                                                class="fa fa-shopping-basket"></i> ລາຍການຈອງ
                                            <?php 
                                            $sql = "SELECT COUNT(rsid) FROM tbreserv WHERE sts_id != 4";
                                            $result = mysqli_query($con, $sql);
                                            $row = mysqli_fetch_array($result);
                                            
                                            echo '<span class="badge" style="color: white; background-color: red;">'.$row[0].'</span>';
                                            ?>
                                        </a>
                                        <a href="order-add.php" class="btn btn-success"><i class="fa fa-truck"></i>
                                            ລາຍການສັ່ງຊື້
                                            <?php 
                                            $sql = "SELECT * FROM tbpurchase WHERE sts_id != 4";
                                            $result = mysqli_query($con, $sql);
                                            $row = mysqli_num_rows($result);
                                            
                                            echo '<span class="badge" style="color: white; background-color: red;">'.$row.'</span>';
                                            ?>
                                        </a>
                                        <a href="import.php" class="btn btn-warning"><i class="fa fa-upload"></i>
                                            ການນຳເຂົ້າ</a>
                                    </div>
                                    <hr>
                                    <hr>

                                    <h5>ສະຫຼຸບຍອດຂາຍ</h5>
                                    <a href="sale-report.php" class="btn btn-primary">ສະແດງການຂາຍ</a>
                                    <a href="#" class="btn btn-primary">ສະແດງລາຍການຈອງ</a>
                                    <a href="order-report.php" class="btn btn-primary">ສະແດງລາຍສັ່ງຊື້</a>
                                    <a href="import-report.php" class="btn btn-primary">ສະແດງການນຳເຂົ້າ</a>
                                    <div class="d-flex">
                                        <div class="table-responsive m-1">
                                            <table class="table table-bordered">
                                                <caption style="caption-side: top;">ຍອດຂາຍປະຈຳວັນ</caption>
                                                <thead class="table-primary">
                                                    <th>No.</th>
                                                    <th>ວັນເດືອນປີ</th>
                                                    <th>ຍອດຂາຍ</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                                $sql = "SELECT DATE_FORMAT(sl_date, '%d/%M/%Y') AS sdate, sum(total_price) as sl_sum FROM tbsale GROUP BY DATE_FORMAT(sl_date, '%Y-%m-%d') LIMIT 30";
                                                                $result = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
                                                                $total = 0;
                                                                $i = 0;
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    $total += $row[1] ;
                                                                    $i++;
                                                                    
                                                                    ?>
                                                    <tr>
                                                        <td><?= $i ?>.</td>
                                                        <td><?= $row['sdate'] ?></td>
                                                        <td class="text-right"><?= number_format($row['sl_sum'],2) ?>
                                                            ກີບ</td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr class="table-warning">
                                                        <td colspan="2" align="right">ລວມ</td>
                                                        <td><?= number_format($total, 2) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive m-1">
                                            <table class="table table-bordered">
                                                <caption style="caption-side: top;">ຍອດຂາຍປະຈຳເດຶອນ</caption>
                                                <thead class="table-primary">
                                                    <th>No.</th>
                                                    <th>ວັນເດືອນປີ</th>
                                                    <th>ຍອດຂາຍ</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                                $sql = "SELECT DATE_FORMAT(sl_date, '%M/%Y') AS sdate, sum(total_price) as sl_sum FROM tbsale GROUP BY DATE_FORMAT(sl_date, '%Y-%m') LIMIT 30";
                                                                $result = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
                                                                $total = 0;
                                                                $i = 0;
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    $total += $row[1] ;
                                                                    $i++;
                                                                    
                                                                    ?>
                                                    <tr>
                                                        <td><?= $i ?>.</td>
                                                        <td><?= $row['sdate'] ?></td>
                                                        <td class="text-right"><?= number_format($row['sl_sum'],2) ?>
                                                            ກີບ</td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr class="table-warning">
                                                        <td colspan="2" align="right">ລວມ</td>
                                                        <td><?= number_format($total, 2) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive m-1">
                                            <table class="table table-bordered">
                                                <caption style="caption-side: top;">ຍອດຂາຍປະຈຳປີ</caption>
                                                <thead class="table-primary">
                                                    <th>No.</th>
                                                    <th>ວັນເດືອນປີ</th>
                                                    <th>ຍອດຂາຍ</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                                $sql = "SELECT DATE_FORMAT(sl_date, '%Y') as sdate, sum(total_price) as sl_sum FROM tbsale GROUP BY DATE_FORMAT(sl_date, '%Y') LIMIT 30";
                                                                $result = mysqli_query($con, $sql) or die ("Error in query: $sql". mysqli_error($sql));
                                                                $total = 0;
                                                                $i = 0;
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    $total += $row[1] ;
                                                                    $i++;
                                                                    
                                                                    ?>
                                                    <tr>
                                                        <td><?= $i ?>.</td>
                                                        <td><?= $row['sdate'] ?></td>
                                                        <td class="text-right"><?= number_format($row['sl_sum'],2) ?>
                                                            ກີບ</td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr class="table-warning">
                                                        <td colspan="2" align="right">ລວມ</td>
                                                        <td><?= number_format($total, 2) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>
    </div>
    <!-- ./wrapper -->

    <script src="js/script.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/adminlte.min.js"></script>
</body>

</html>