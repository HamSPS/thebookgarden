<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="images/icon.svg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>The Book Garden</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo @$_SESSION['img']; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <?php echo '<a href="#" class="d-block"> '. @$_SESSION['name'] .' </a>'; ?>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column LaoFonts" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="fa fa-home"></i>
                        <p>ໜ້າຫຼັກ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            ຈັດເກັບຂໍ້ມູນ
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="emp-manage.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ຂໍ້ມູນພະນັກງານ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cus-manage.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ຂໍ້ມູນລູກຄ້າ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="supplier-manage.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ຂໍ້ມູນຜູ້ສະໜອງ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="book-manage.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ຂໍ້ມູນໜັງສື</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="Category-manage.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ຂໍ້ມູນປະເພດໜັງສື</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="currency-manage.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ຂໍ້ມູນອັດຕາແລກປ່ຽນ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shopping-bag"></i>
                        <p>ຂາຍສິນຄ້າ <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="frmSale.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ຂາຍສິນຄ້າ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="Reserv-manage.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ຈອງສິນຄ້າ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-tags"></i>
                        <p>ການສັ່ງຊື້ <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="order-add.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ສັ່ງຊື້ສິນຄ້າ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="import.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ນຳເຂົ້າສິນຄ້າ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <p>ພິມລາຍງານ <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="emp-report.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ພິມລາຍງານຂໍ້ມູນພະນັກງານ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="cus-report.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ພິມລາຍງານຂໍ້ມູນລູກຄ້າ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="supplier-report.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ພິມລາຍງານຂໍ້ມູນຜູ້ສະໜອງ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="book-report.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ພິມລາຍງານຂໍ້ມູນໜັງສື</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="category-report.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ພິມລາຍງານຂໍ້ມູນປະເພດໜັງສື</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ພິມລາຍງານຂໍ້ມູນການຂາຍ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ພິມລາຍງານລາຍຮັບ-ຈ່າຍ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ພິມບັດສະມາຊິກ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-door-open"></i>
                        <p>ອອກຈາກລະບົບ</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<form action="logout.php" method="post">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ອອກຈາກລະບົບ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>ທ່ານຕ້ອງການອອກຈາກລະບົບ ຫຼື ບໍ່?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">ອອກຈາກລະບົບ</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1 class="m-0 LaoFonts">ລະບົບຈັດການຂໍ້ມູນຮ້ານ The Book Garden</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>