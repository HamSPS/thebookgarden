<?php
session_start();
include_once 'connectdb.php';
//ຮັບຄ່າຈາກຟອມເມື່ອກົດປຸ່ມ btnLogin
if (isset($_POST['btnLogin'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $pwd = mysqli_real_escape_string($con, $_POST['pwd']);

    $sql = "SELECT * FROM tbstaff WHERE username ='$username' AND pwd = md5('$pwd')";
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
        header("Location: index.php");
    } else {
        $message = '<script type="text/javascript"> swal("ແຈ້ງເຕືອນ", "ບັນຊີເຂົ້າໃຊ້ ແລະ ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ", "error") </script>';
    }
}
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ລະບົບຈັດການຂໍ້ມູນພະນັກງານ</title>
        <link rel="icon" type="image/jpg" href="images/icon_logo.jpg">
        <link rel="stylesheet" href="css/style.css">
        <link href="fontawesome/css/all.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/popper.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/sweetalert.min.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
        <style>

            body{
                font-family: Phetsarath OT;
            }
        </style>

    </head>
    <body class="log-body">
        
        <?= @$message ?>
        <!--ເນື້ອຫາ-->
        <div class="container-fluid">
            <br>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card" style="border-color: blue">
                        <div class="card-header bg-info text-white">
                            <h5><b>ເຂົ້າໃຊ້ລະບົບ</b></h5>
                        </div>
                        <div class="card-body" style="background: beige">
                            <form action="login-form.php" method="post">
                                <div class="form-group">
                                    <label>ບັນຊີເຂົ້າໃຊ້:</label>
                                    <input class="form-control" type="text" name="username" value="<?= @$username ?>" placeholder="ກະລຸນາໃສ່ບັນຊີເຂົ້າໃຊ້" required autofocus>
                                </div>

                                <div class="form-group">
                                    <label>ລະຫັດຜ່ານ:</label>
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="password" id="password" name="pwd"  placeholder="ກະລຸນາປ້ອນລະຫັດຜ່ານ" required autofocus>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <a id="show_password"  class="btn"><i class="fas fa-eye"></i></a>
                                            </span>
                                        </div>
                                    </div>

                                    <input class="btn btn-primary" type="submit" name="btnLogin" value="ເຂົ້າໃຊ້ລະບົບ">
                                    </form>
                                    <hr>
                                    <p> <span style="color: blue; font-weight: bold"> ລົງທະບຽນເຂົ້າໃຊ້</span> <a href="register-form.php"> Click</a></p>
                                </div>
                        </div>
                    </div>
                    <!--ສິນສຸດໜ້າເຂົ້າໃຊ້ລະບົບ-->
                </div>
            </div>
        </div>
        <!--ສີ້ນສຸດເນື້ອຫາ-->
    </body>
</html>

<script>

    $(document).ready(function() {
        $('#show_password').on('click', function() {
            var passwordField = $('#password');
            var passwordFieldType = passwordField.attr('type');
            if (passwordField.val() != '')
            {
                if (passwordFieldType == 'password')
                {
                    passwordField.attr('type', 'text');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else
                {
                    passwordField.attr('type', 'password');
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            } else
            {
                swal("ແຈ້ງເຕືອນ", "ກະລຸນາປ້ອນລະຫັດຜ່ານ", "warning");
            }
        });
    });
</script>

