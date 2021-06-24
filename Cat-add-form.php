<?php
 include_once 'connectdb.php';
//ຮັບຄ່າຈາກຟອມຖ້າມີການກົດປຸ່ມຊື່ btnAdd
if (isset($_POST['btnAdd'])) {
    $catID = $_POST['catID'];
    $catName = $_POST['catName'];

    //ກວດສອບລະຫັດ
    $sql = "SELECT catID FROM tbCategory WHERE catID = '$catID'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $message = '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ລະຫັດຖືກນໍາໃຊ້ແລ້ວ", "warning") </script>';
    } else {

        $sql = "INSERT INTO tbCategory VALUES('$catID', '$catName')";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $message = '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
             $catID = $catName = "";
             header("refresh:2; url=category-manage.php");
        } else {
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
                                <input class="form-control" type="text" id="catID" name="catID" value="<?= @$catID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" required="">
                                </div>
                            <div class="col-md-12">
                                <label for="catName">ຊື່ປະເພດ</label>
                                <input class="form-control" type="text" id="catName" name="catName" value="<?= @$catName ?>" placeholder="ກະລຸນາປ້ອນຊື່ປະເພດໜັງສື" required="">
                            </div>
                            <div class="col-md-12 pt-5" style="text-align: center">
                                <input type="submit" id="btnAdd" name="btnAdd" value="ເພີ້ມຂໍ້ມູນ" class="btn btn-primary" style="width: 100px; border-radius: 20px">
                                &nbsp;&nbsp;
                                <a href="category-manage.php" class="btn btn-warning" style="width: 100px; border-radius: 20px">ຍົກເລີກ</a>
                                &nbsp;&nbsp;
                                <button onclick="window.location.reload(true)" class="btn btn-success" style="width: 100px; border-radius: 20px;">ໂຫຼດຄືນໃໝ່</button>
                                <p></p>
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

