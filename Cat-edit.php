<?php
 include_once 'connectdb.php';

 $catID = $_GET['catID'];
 $sql = "SELECT * FROM tbCategory WHERE catID = '$catID'";

 $result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$catID = $row[0];
$catName = $row[1];
//ຮັບຄ່າຈາກຟອມຖ້າມີການກົດປຸ່ມຊື່ btnAdd
if (isset($_POST['Edit'])) {
    $catID = $_POST['catID'];
    $catName = $_POST['catName'];

    if (empty($catName)) {
        $message = '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຖືກຕ້ອງ", "warning") </script>';
    }else{
        $sql = "UPDATE tbcategory set catName = '$catName' WHERE catID = '$catID'";
        if (mysqli_query($con, $sql)) {
        $message = '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ປັງປຸງຂໍ້ມູນສຳເລັດ", "success") </script>';
            header("refresh:2; url=category-manage.php");
        }else{
            echo mysqli_error($con);
        }
    }
}

include 'head.php';
include 'menu.php';
?>


<div class="content" id="MainCT">
    <?= @$message ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card" style="border-color: blue;max-width: 540px;">
                <div class="card-header bg-info text-white">
                    <h5><b>ຟອມປ້ອນຂໍ້ມູນປະເພດໜັງສື</b></h5>
                </div>
                <div class="card-body" style="background-color: #e9ecef">
                    <form action="" method="post" enctype="multipart/form-data" role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="catID">ລະຫັດປະເພດໜັງສື</label>
                                <input class="form-control" type="text" id="catID" name="catID" value="<?= @$catID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" readonly>
                                </div>
                            <div class="col-md-12">
                                <label for="catName">ຊື່ປະເພດ</label>
                                <input class="form-control" type="text" id="catName" name="catName" value="<?= @$catName ?>" placeholder="ກະລຸນາປ້ອນຊື່ປະເພດໜັງສື" required="">
                            </div>
                            <div class="col-md-12 pt-5" style="text-align: center">
                                <input type="submit" id="Edit" name="Edit" value="ປັງປຸງ" class="btn btn-primary" style="width: 100px; border-radius: 20px">
                                &nbsp;&nbsp;
                                <a href="category-manage.php" class="btn btn-warning" style="width: 100px; border-radius: 20px">ຍົກເລີກ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</div>
                    <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<?php 
    include 'footer.php';
?>


</body>

</html>