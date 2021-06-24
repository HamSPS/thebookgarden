<?php
    include '../connectdb.php';
    
    if (isset($_POST['btnAdd'])) {
        $cateID = $_POST['cateID'];
        $catName = $_POST['catName'];

        $sql = "SELECT * FROM tbCategory";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            $message = '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ລະຫັດ ຫຼື ຊື່ຜູ້ໃຊ້ຖືກນໍາໃຊ້ແລ້ວ", "warning") </script>';\
            header("location: ../Category-manage.php");
        }else{
            $sql = "INSERT INTO tbCategory VALUES('$cateID','$catName')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $message = '<script type="text/javascript"> swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ", "success") </script>';
                $cateID = $catName = "";
                header("location: Category-manage.php");
            } else {
                echo mysqli_error($con);
            }
        }
    }
?>
