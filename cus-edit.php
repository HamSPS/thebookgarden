<?php
 include_once 'connectdb.php';
 $cusID = $_GET['cusID'];
 $sql = "SELECT * FROM tbCustomer WHERE cusID = '$cusID'";
 $result = mysqli_query($con, $sql);
 $row = mysqli_fetch_array($result);
 $cusID = $row[0];
 $cusName = $row[1];
 $gender = $row[2];
 $date_birth = $row[3];
 $address = $row[4];
 $img = $row[5];
 $tel = $row[6];
 $email = $row[7];

 if (isset($_POST['btnEdit'])) {
     $cusID = $_POST['cusID'];
     $cusName = $_POST['cusName'];
     $gender = $_POST['gender'];
     $date_birth = $_POST['date_birth'];
     $address = $_POST['address'];
     $file_image =  $_FILES['file_image']['name'];
     $file_tmp = $_FILES['file_image']['tmp_name'];
     $tel = $_POST['tel'];
     $email = $_POST['email'];

     if(empty($file_image)){
         $sql = "UPDATE tbCustomer SET cusName = '$cusName', gender='$gender',dateOfBirth = '$date_birth', address='$address',tel = '$tel',email= '$email' WHERE cusID = '$cusID'";
         // move_uploaded_file($file_tmp, "images/staff/" . $file_image);
         if (mysqli_query($con, $sql)) {
             header("Location: cus-manage.php"); //ໃຫ້ລິ້ງໄປໜ້າemp_manage.php
         } else {
             echo mysqli_error($con);
         }
     }else{
         $old_picture = $_POST['old_picture'];
     //ລືບຮູບ
    unlink("images/Customer/$old_picture");

     //ປ່ຽນຊື່ໄຟລ໌ເພື່ອບໍ່ໃຫ້ໄຟລ໌ຊໍ້າກັນ
     $file_image = round(round(microtime(TRUE))) . $file_image;
     //ຍ້າຍໄຟລ໌ໄປເກັບໄວ້ໃນໂຟນເດີ
     move_uploaded_file($file_tmp, "images/Customer/" . $file_image);
     $sql = "UPDATE tbCustomer SET cusName = '$cusName', gender='$gender',dateOfBirth = '$date_birth', address='$address',img='images/Customer/$file_image',tel = '$tel',email= '$email' WHERE cusID = '$cusID'";
     if (mysqli_query($con, $sql)) {
         header("Location: cus-manage.php"); //ໃຫ້ລິ້ງໄປໜ້າemp_manage.php
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
                            <div class="card" style="border-color: blue">
                                <div class="card-header bg-info text-white">
                                    <h><b>ຟອມປ້ອນຂໍ້ມູນລູກຄ້າ</b></h>
                                </div>
                                <div class="card-body" style="background-color: #e9ecef">
                                <form action="" method="post" enctype="multipart/form-data" role="form">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <!-- 1, ລະຫັດພະນັກງານ -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="cusID">ລະຫັດລູກຄ້າ</label>
                                                            <input class="form-control" type="text" id="cusID"
                                                                name="cusID" value="<?= @$cusID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ"
                                                                required="" readonly>
                                                            <!--ສະແດງຂໍ້ຜິດພາດເມືອລະຫັດຖືກນໍາໃຊ້ແລ້ວ -->
                                                            <span id="availability"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!-- 2, ຊື່ພະນັກງານ -->
                                                        <div class="form-group">
                                                            <label for="cusName">ຊື່ ແລະ ນາມສະກຸນ</label>
                                                            <input class="form-control" type="text" id="cusName"
                                                                name="cusName" value="<?= @$cusName ?>"
                                                                placeholder="ກະລຸນາປ້ອນຊື່ພະນັກງານ" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!-- 3, ເພດ -->
                                                        <fieldset class="form-group">
                                                            <p>ເພດ</p>

                                                            <div class="form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input"
                                                                        name="gender" value="ຊາຍ" checked="" <?php if (@$gender == "" || @$gender == "ຊາຍ") echo 'checked'; ?>> ຊາຍ
                                                                </label>
                                                            </div>
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input"
                                                                        name="gender" value="ຍິງ" <?php if (@$gender == "ຍິງ") echo 'checked'; ?>> ຍິງ
                                                                </label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <!--ວັນເດືອນປີເກີດ-->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="date_birth">ວັນ, ເດືອນ, ປີເກີດ:</label>
                                                            <input type="date" class="form-control" id="date_birth"
                                                                name="date_birth" value="<?= @$date_birth ?>" required="">
                                                        </div>
                                                    </div>
                                                    <!-- ເບີໂທຕິດຕໍ່ -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tel">ເບີໂທຕິດຕໍ່</label>
                                                            <input type="text" id="tel" name="tel" value="<?= @$tel ?>" class="form-control"
                                                                placeholder="ປ້ອນເບີໂທຕິດຕໍ່">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="deparment">ອີເມວ</label>
                                                            <input type="email" id="email" name="email" value="<?= @$email ?>" class="form-control"
                                                            placeholder="example@email.com">
                                                        </div>
                                                    </div>
                                                    <!--ທີ່ຢູ່-->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="address">ທີ່ຢູ່:</label>
                                                            <textarea class="form-control" id="address" name="address"
                                                                rows="4"><?= @$address ?></textarea>
                                                        </div>

                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            <!--ໃສຮູບພາບ-->
                                            <div class="col-md-4">
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div style="text-align: center">
                                                            <img id="img-upload" width="auto" height="180px">
                                                            <div id="temp_img">
                                                                <img src="<?= @$img ?>" alt="" width="150px"
                                                                    height="180px">
                                                            </div>
                                                            <!--ເລືອກຮູບພາບ-->
                                                            <br>
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-info btn-file">
                                                                        ເລືອກຮູບ(4x6)<input type="file" id="imgInp"
                                                                            name="file_image" accept="image/staff/*">
                                                                    </span>
                                                                </span>
                                                                <input type="text" class="form-control" readonly="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- ຊື່ພະແນກ -->
                                                    
                                                </div>
                                            </div>


                                            <!--ພາສາຕ່າງປະເທດ -->

                                            <!--ປຸ່ມຕ່າງ-->
                                            <div class="col-md-12" style="text-align: center">
                                                <br>
                                                <input type="submit"  name="btnEdit" value="ປັບປຸງຂໍ້ມູນ" class="btn btn-primary" style="width: 100px; border-radius: 20px">
                                        <a href="cus-manage.php" class="btn btn-warning" style="width: 100px; border-radius: 20px">ຍົກເລີກ</a>

                                        <!--ສົ່ງຊື່ໄຟລ໌ຮູບເກົ່າໄປນໍາແຕ່ບໍ່ໃຫ້ສະແດງ-->
                                        <input type="hidden" name="old_picture" value="<?= $file_image ?>">
                                        <p></p>
                                                <p></p>
                                            </div>
                                        </div>
        </form>
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
     <script type="text/javascript">
    $(document).ready(function() {
        /*ເລືອກຮູບພາບ*/
        $('#img-upload').hide();
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
            $('#temp_img').hide(); /*ໃຫ້ເຊືອງເມືອເລືອກຮູບ*/
            $('#img-upload').show();
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                    log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log)
                    alert(log);
            }

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
        /*ສິ້ນສຸດເລືອກຮູບ*/
    });


</script>


</body>

</html>