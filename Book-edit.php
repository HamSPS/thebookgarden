<?php
 include_once 'connectdb.php';
 $bkID = $_GET['Bkid'];
 $sql = "SELECT * FROM tbbook WHERE Bkid = '$bkID'";
 $result = mysqli_query($con, $sql);
 $row = mysqli_fetch_array($result);
 $bkID = $row[0];
 $bkName = $row[1];
 $price = $row[2];
 $stock = $row[3];
 $author = $row[4];
 $detail = $row[5];
 $img = $row[6];
 $catID = $row[7];
//ຮັບຄ່າຈາກຟອມຖ້າມີການກົດປຸ່ມຊື່ btnAdd
//ຮັບຄ່າຈາກຟອມຖ້າກົດປຸ່ມ btnEdit
if (isset($_POST['btnEdit'])) {
    $bkID = $_POST['bkID'];
    $bkName = $_POST['bkName'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $author = $_POST['author'];
    $detail = $_POST['detail'];
    $catID = $_POST['catID'];
    //ຮັບຟາຍຮູບ
    $file_image = $_FILES['file_image']['name'];
    $file_tmp = $_FILES['file_image']['tmp_name'];


    if (empty($file_image)) { //ຖ້າບໍ່ເລືອກຮູບ
        $sql = "UPDATE tbbook SET bkName='$bkName', price='$price', stock='$stock', author='$author', detail='$detail', catID='$catID'  WHERE bkID='$bkID' ";
        if (mysqli_query($con, $sql)) {
            $message = '<script type="text/javascript"> swal("ສໍາເລັດ", "ແກ້ໄຂຂໍ້ມູນສຳເລັດແລ້ວ", "success") </script>';

            header("refresh:2;url=book-manage.php"); //ໃຫ້ລິ້ງໄປໜ້າemp_manage.php
        } else {
            echo mysqli_error($con);
        }
    } else {
        $old_picture = $_POST['old_picture'];
        //ລືບຮູບ
        unlink("$old_picture");

        //ປ່ຽນຊື່ໄຟລ໌ເພື່ອບໍ່ໃຫ້ໄຟລ໌ຊໍ້າກັນ
        $file_image = round(round(microtime(TRUE))) . $file_image;
        //ຍ້າຍໄຟລ໌ໄປເກັບໄວ້ໃນໂຟນເດີ
        move_uploaded_file($file_tmp, "images/Books/" . $file_image);
        $sql = "UPDATE tbbook SET bkName='$bkName', price='$price', stock='$stock', author='$author', detail='$detail', catID='$catID',img='images/Books/$file_image'  WHERE bkID='$bkID' ";
        if (mysqli_query($con, $sql)) {
            $message = '<script type="text/javascript"> swal("ສໍາເລັດ", "ແກ້ໄຂຂໍ້ມູນສຳເລັດແລ້ວ", "success") </script>';
            header("refresh:2;url=book-manage.php"); //ໃຫ້ລິ້ງໄປໜ້າemp_manage.php
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
                                    <h><b>ຟອມປ້ອນຂໍ້ມູນໜັງສື</b></h>
                                </div>
                                <div class="card-body" style="background-color: #e9ecef">
                                    <form action="" method="post" enctype="multipart/form-data" role="form">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <!-- 1, ລະຫັດພະນັກງານ -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="bkID">ລະຫັດ</label>
                                                            <input class="form-control" type="text" id="bkID" name="bkID" value="<?= @$bkID ?>" placeholder="ກະລຸນາປ້ອນລະຫັດ" readonly>
                                                            <!--ສະແດງຂໍ້ຜິດພາດເມືອລະຫັດຖືກນໍາໃຊ້ແລ້ວ -->
                                                            <span id="availability"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!-- 2, ຊື່ພະນັກງານ -->
                                                        <div class="form-group">
                                                            <label for="bkName">ຊື່ໜັງສື</label>
                                                            <input class="form-control" type="text" id="bkName" name="bkName" value="<?= @$bkName ?>" placeholder="ກະລຸນາປ້ອນຊື່ໜັງສື" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!-- 3, ເພດ -->
                                                        <label for="author">ຊື່ຜູ້ຂຽນ</label>
                                                        <input class="form-control" type="text" id="author" name="author" value="<?= @$author ?>" placeholder="ກະລຸນາປ້ອນຊື່ຜູ້ຂຽນ" required="">
                                                    </div>
                                                    <!--ວັນເດືອນປີເກີດ-->
                                                    <div class="col-md-6">
                                                        <label for="catID">ປະເພດໜັງສື</label>
                                                        <select name="catID" id="caID" class="form-control text-center">
                                                            <option value="">-------ເລືອກປະເພດໜັງສື-------</option>
                                                            <?php 
                                                                $sql = "SELECT * FROM tbCategory";
                                                                $result = mysqli_query($con, $sql);

                                                                while($row = mysqli_fetch_assoc($result)){
                                                                ?>
                                                                <option value="<?= $row['catID'] ?>" <?php if (@$catID == $row['catID']) { echo 'selected'; }?>><?= $row['catName'] ?></option>
                                                            <?php 
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <!--ທີ່ຢູ່-->
                                                    
                                                    <div class="col-md-6">
                                                        <label for="price">ລາຄາ</label>
                                                        <input class="form-control" type="number" id="price" name="price" value="<?= @$price ?>" placeholder="ກະລຸນາປ້ອນລາຄາ " required="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="stock">ຈຳນວນ</label>
                                                        <input class="form-control" type="number" id="stock" name="stock" value="<?= @$stock ?>" placeholder="ກະລຸນາປ້ອນຈຳນວນ " required="">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="detail">ລາຍລະອຽດ:</label>
                                                            <textarea class="form-control" id="detail" name="detail" rows="4"><?= @$detail ?></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!--ໃສຮູບພາບ-->
                                            <div class="col-md-4">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div style="text-align: center">
                                                            <img id="img-upload" height="150px">
                                                            <div id="temp_img">
                                                                <img src="<?= $img ?>" alt="" width="150px" height="180px">
                                                            </div>
                                                            <!--ເລືອກຮູບພາບ-->
                                                            <br>
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <span class="btn btn-info btn-file">
                                                                        ເລືອກຮູບ(4x6)<input type="file" id="imgInp" name="file_image" accept="image/*">
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
                                        <a href="book-manage.php" class="btn btn-warning" style="width: 100px; border-radius: 20px">ຍົກເລີກ</a>

                                        <!--ສົ່ງຊື່ໄຟລ໌ຮູບເກົ່າໄປນໍາແຕ່ບໍ່ໃຫ້ສະແດງ-->
                                        <input type="hidden" name="old_picture" value="<?= $img ?>">
                                        <p></p>
                                                <p></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
        </div>
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