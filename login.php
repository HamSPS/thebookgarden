<?php
session_start();
include_once 'connectdb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/sweetalert.min.js" type="text/javascript"></script>
    <style>
    body {
        font-family: NotoSansLao;
    }
    </style>
</head>

<body>
    <?php
    
    //ຮັບຄ່າຈາກຟອມເມື່ອກົດປຸ່ມ btnLogin
    if (isset($_POST['btnLogin'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $pwd = mysqli_real_escape_string($con, $_POST['pwd']);
    
        $sql = "SELECT * FROM tbstaff WHERE (username ='$username' or email='$username') AND pwd = md5('$pwd')";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        if (mysqli_num_rows($result) > 0) {
            //ສ້າງ session
            $name = $row["FirstName"]." ". $row["LastName"];
            $src_img = $row['img'];
            $_SESSION['empID'] = $row['stid'];
            $_SESSION['username'] = $username;
            $_SESSION['pwd'] = $pwd;
            $_SESSION["name"] = $name;
            $_SESSION['img'] = $src_img;
            //ໄປໜ້າ index.php
            // header("Location: index.php");
            echo '<script type="text/javascript"> 
            swal("ແຈ້ງເຕືອນ", "ຍິນດີຕ້ອນຮັບ '.$name.'", "success")
            .then((value) => {
                window.location.href="index.php";
            })
             </script>';

        } else {
            echo '<script type="text/javascript"> 
                swal("ແຈ້ງເຕືອນ", "ບັນຊີເຂົ້າໃຊ້ ແລະ ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ", "error")
                .then((value) => {
                    window.history.back()
                })
                </script>';
        }
    }
    
            // echo '<script>window.history.back()</script>';
    ?>

</body>

</html>