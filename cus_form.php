<?php 

    include 'connectdb.php';

    if (isset($_POST['submit'])) {
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];

        $sql = "INSERT INTO customers VALUES(null, '$fname','$lname','$gender','$birthday')";
        if ($result = mysqli_query($con, $sql);) {
            $message = "ສຳເລັດແລ້ວ"ວ
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="" method="post">
        ຊື່ພະນັກງານ
        <input type="text" name="firstName"><br>
        ຊື່ພະນັກງານ
        <input type="text" name="lastName"><br>
        ເພດ
        <input type="text" name="gender"><br>
        ວັນ ເດືອນ ປີເກີດ
        <input type="date" name="birthday">
        <br>
        <br>

        <input type="submit" value="ບັນທຶກ" name="submit">
    </form>
    
</body>
</html>