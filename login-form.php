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
        <link href="fontawesome/css/all.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/popper.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/sweetalert.min.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
        <style>

            body{
                font-family: NotoSansLao;
                background: url('images/03-Stationary-3.jpg') no-repeat fixed;
                opacity: .9;
            }
            .popup-img{
            margin-top: -60px !important;
        }
        </style>

    </head>
    <body>
        
        <?= @$message ?>
        <!--ເນື້ອຫາ-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 m-auto">
            <div class="card px-4 bg-dark" style="margin-top: 150px;">
                <div class="card-title text-center mt-3 popup-img">
                    <img src="images/icon.svg" width="150px" height="150px" alt="">
                    <h1 class="text-light">The Book Garden</h1>
                </div>
                <div class="card-body">
                    <form action="login-form.php" method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user fa-2x"></i>
                                </span>
                            </div>
                            <input type="text" name="username" id="username" class="form-control py-4" placeholder="ຊື່ຜູ້ໃຊ້"
                                required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock fa-2x"></i>
                                </span>
                            </div>
                            <input type="password" name="pwd" id="pwd" class="form-control py-4" placeholder="ລະຫັດຜ່ານ"
                                required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <a id="show_password"><i class="fas fa-eye"></i></a>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <!-- <button type="submit" class="btn btn-success" name="btnLogin" style="width:40%;"><i class="fas fa-sign-in-alt"></i> ເຂົ້າໃຊ້ລະບົບ</button> -->
                            <input type="submit" value="ເຂົ້າໃຊ້ລະບົບ" name="btnLogin" class="btn btn-success" style="width:200px;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        <!--ສີ້ນສຸດເນື້ອຫາ-->
    </body>
</html>

<script>

    $(document).ready(function() {
        $('#show_password').on('click', function() {
            var passwordField = $('#pwd');
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

