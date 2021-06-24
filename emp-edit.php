<?php 
    include 'connectdb.php';
    $stid = $_GET['stid'];
    $sql = "SELECT * FROM tbstaff WHERE stid = '$stid'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $stid = $row[0];
    $firstName = $row[1];
    $lastName = $row[2];
    $gender = $row[3];
    $date_birth = $row[4];
    $address = $row[5];
    $img = $row[6];
    $tel = $row[7];
    $email = $row[8];
    $user_name = $row[9];
    $password = $row[10];

    if (isset($_POST['btnEdit'])) {
        $stid = $_POST['stid'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $date_birth = $_POST['date_birth'];
        $address = $_POST['address'];
        $file_image =  $_FILES['file_image']['name'];
        $file_tmp = $_FILES['file_image']['tmp_name'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $user_name = $_POST['username'];
        $password = $_POST['pwd'];

        if(empty($file_image)){
            $sql = "UPDATE tbstaff SET firstName = '$firstName', lastName = '$lastName', gender='$gender',dateOfBirth = '$date_birth', address='$address',tel = '$tel',email= '$email', username='$user_name',pwd= md5('$password') WHERE stid = '$stid'";
            // move_uploaded_file($file_tmp, "images/staff/" . $file_image);
            if (mysqli_query($con, $sql)) {
                header("Location: emp-manage.php"); //ໃຫ້ລິ້ງໄປໜ້າemp_manage.php
            } else {
                echo mysqli_error($con);
            }
        }else{
            $old_picture = $_POST['old_picture'];
        //ລືບຮູບ
        unlink("images/staff/$old_picture");

        //ປ່ຽນຊື່ໄຟລ໌ເພື່ອບໍ່ໃຫ້ໄຟລ໌ຊໍ້າກັນ
        $file_image = round(round(microtime(TRUE))) . $file_image;
        //ຍ້າຍໄຟລ໌ໄປເກັບໄວ້ໃນໂຟນເດີ
        move_uploaded_file($file_tmp, "images/staff/" . $file_image);
        $sql = "UPDATE tbstaff SET firstName = '$firstName', lastName = '$lastName', gender='$gender',dateOfBirth = '$date_birth', address='$address',img='images/staff/$file_image',tel = '$tel',email= '$email', username='$user_name',pwd= md5('$password') WHERE stid = '$stid'";
        if (mysqli_query($con, $sql)) {
            header("Location: emp-manage.php"); //ໃຫ້ລິ້ງໄປໜ້າemp_manage.php
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
                                    <h><b>ຟອມແກ້ໄຂຂໍ້ມູນພະນັກງານ</b></h>
                                </div>
                                <div class="card-body" style="background-color: #e9ecef">
                                <form action="" method="post" enctype="multipart/form-data" role="form">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <!-- 1, ລະຫັດພະນັກງານ -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="stid">ລະຫັດພະນັກງານ</label>
                                                            <input class="form-control" type="text" id="stid"
                                                                name="stid" value="<?= @$stid ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ"
                                                                required="" readonly>
                                                            <!--ສະແດງຂໍ້ຜິດພາດເມືອລະຫັດຖືກນໍາໃຊ້ແລ້ວ -->
                                                            <span id="availability"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6">
                                                        <!-- 2, ຊື່ພະນັກງານ -->
                                                        <div class="form-group">
                                                            <label for="firstName">ຊື່ພະນັກງານ</label>
                                                            <input class="form-control" type="text" id="firstName"
                                                                name="firstName" value="<?= @$firstName ?>"
                                                                placeholder="ກະລຸນາປ້ອນຊື່ພະນັກງານ" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <!-- 2, ຊື່ພະນັກງານ -->
                                                    <div class="form-group">
                                                            <label for="lastName">ນາມສະກຸນ</label>
                                                            <input class="form-control" type="text" id="lastName"
                                                                name="lastName" value="<?= @$lastName ?>"
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
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="tel">ເບີໂທຕິດຕໍ່</label>
                                                            <input type="text" id="tel" name="tel" value="<?= @$tel ?>" class="form-control"
                                                                placeholder="ປ້ອນເບີໂທຕິດຕໍ່">
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
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" id="email" name="email" value="<?= @$email ?>" class="form-control"
                                                            placeholder="example@email.com">
                                                        <label for="username">ຊື່ຜູ້ໃຊ້</label>
                                                        <input type="text" id="username" name="username" value="<?= @$user_name ?>" class="form-control" placeholder="Enter Username">
                                                        <label for="pwd">ລະຫັດຜ່ານ</label>
                                                        <input type="password" id="pwd" name="pwd" value="<?= @$password ?>" class="form-control" placeholder="Enter Password">
                                                    </div>
                                                </div>
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
                                                                            name="file_image" accept="images/staff/*">
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
                                        <a href="emp-manage.php" class="btn btn-warning" style="width: 100px; border-radius: 20px">ຍົກເລີກ</a>

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