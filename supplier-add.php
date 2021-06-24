<?php
    include_once 'connectdb.php';
    
    if(isset($_POST['btnAdd'])){
        $sup_id = $_POST['sup_id'];
        $sup_name = $_POST['sup_name'];
        $contact = $_POST['contact'];
        $sup_tel = $_POST['sup_tel'];
        $sup_email = $_POST['sup_email'];
        $sup_address = $_POST['sup_address'];

        $sql = "SELECT * FROM tbsuppliers WHERE sup_id = '$sup_id'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            $message = '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ລະຫັດ ຫຼື ຊື່ຜູ້ໃຊ້ຖືກນໍາໃຊ້ແລ້ວ", "warning") </script>';
        } else {
            $sql = "INSERT INTO tbsuppliers VALUES('$sup_id','$sup_name','$contact','$sup_address','$sup_tel','$sup_email')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $message = '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
                $sup_id = $sup_name  = $contact = $sup_tel = $sup_email = $sup_address = "";
                header("Location: supplier-manage.php");
            } else {
                echo mysqli_error($con);
            }
        }
    }

    include 'head.php';


    include 'menu.php';
?>

<div class="container-fluid">
    <?= @$message ?>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card" style="border-color: blue">
                <div class="card-header bg-info text-white">
                    <h><b>ຟອມປ້ອນຂໍ້ມູນຜູ້ສະໜອງ</b></h>
                 </div>
                <div class="card-body" style="background-color: #e9ecef">
                    <form action="" method="post" enctype="multipart/form-data" role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <!-- 1, ລະຫັດພະນັກງານ -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sup_id">ລະຫັດຜູ້ສະໜອງ</label>
                                            <input class="form-control" type="text" id="sup_id" name="sup_id" value="<?= @$sup_id ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" required="">
                                            <!--ສະແດງຂໍ້ຜິດພາດເມືອລະຫັດຖືກນໍາໃຊ້ແລ້ວ -->
                                            <span id="availability"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- 2, ຊື່ພະນັກງານ -->
                                        <div class="form-group">
                                            <label for="sup_name">ຊື່ຜູ້ສະໜອງ</label>
                                            <input class="form-control" type="text" id="sup_name" name="sup_name" value="<?= @$sup_name ?>" placeholder="ກະລຸນາປ້ອນຊື່ຜູ້ສະໜອງ" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- 3, ເພດ -->
                                        <label for="contact">ຊື່ຜູ້ຕິດຕໍ່</label>
                                        <input class="form-control" type="text" id="contact" name="contact" value="<?= @$contact ?>" placeholder="ກະລຸນາປ້ອນຊື່ຜູ້ຕິດຕໍ່" required="">
                                    </div>
                                    <!--ວັນເດືອນປີເກີດ-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sup_tel">ເບີໂທຕິດຕໍ່</label>
                                            <input class="form-control" type="text" id="sup_tel" name="sup_tel" value="<?= @$sup_tel ?>" placeholder="ປ້ອນເບີໂທ" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sup_email">Email</label>
                                            <input class="form-control" type="email" id="sup_email" name="sup_email" value="<?= @$sup_email ?>" placeholder="example@email.com" required="">
                                        </div>
                                    </div>
                                                    
                                    <!--ທີ່ຢູ່-->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sup_address">ທີ່ຢູ່:</label>
                                            <textarea class="form-control" id="sup_address" name="sup_address" rows="4"><?= @$sup_address ?></textarea>
                                        </div>

                                    </div>
                                    
                                                    
                                </div>
                            </div>

                                            <!--ໃສຮູບພາບ-->
                                            


                                            <!--ພາສາຕ່າງປະເທດ -->

                                            <!--ປຸ່ມຕ່າງ-->
                            <div class="col-md-12" style="text-align: center">
                                <br>
                                <input type="submit" id="btnAdd" name="btnAdd" value="ເພີ້ມຂໍ້ມູນ" class="btn btn-primary" style="width: 100px; border-radius: 20px">
                                                &nbsp;&nbsp;
                                <input type="reset" value="ຍົກເລີກ" onclick="window.history.back()" class="btn btn-warning" style="width: 100px; border-radius: 20px">
                                                &nbsp;&nbsp;
                                <button onclick="window.location.reload(true)" class="btn btn-success" style="width: 100px; border-radius: 20px;">ໂຫຼດຄືນໃໝ່</button>
                                <p></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br><br>
        </div>
    </div>
</div>

<?php
    include 'footer.php';
?>

</body>
</html>