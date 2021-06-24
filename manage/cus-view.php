<?php

include '../connectdb.php';
if (isset($_POST['cusID'])) {
    $cusID = $_POST['cusID'];
    $output = '';
    $sql = "SELECT cusID, cusName, gender,dateOfBirth,year(curdate())-year(dateOfBirth) AS age,address,img,tel,email FROM tbCustomer WHERE cusID = '$cusID'";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $img = is_numeric($row['img']) ? "avatar_img.png" : $row['img'];
        $output .= '<p style="text-align: center">';

        if (empty($img)) {
            $output .= '<img src="images/user.jpg" alt="ຮູບລູກຄ້າ" width="150px" height="200px"  class="img-thumbnail">';
        }else{
            $output .= '<img src="'.$img.'" alt="ຮູບລູກຄ້າ" width="150px" height="200px"  class="img-thumbnail">';
        }
        $output .= ' </p>';
        $output .= "<br>ລະຫັດລູກຄ້າ: " . $row['cusID'];
        $output .= "<br>ຊື່ ແລະ ນາມສະກຸນ: " . $row['cusName'];
        $output .= "<br>ເພດ: " . $row['gender'];
        $output .= "<br>ວັນ, ເດືອນ, ປີເກີດ: " . date('d / m / Y', strtotime($row['dateOfBirth']));
        $output .= "<br>ອາຍຸ: " . $row['age'] . " ປີ";
        $output .= "<br>ທີ່ຢູ່: " . $row['address'];
        $output .= "<br>ເບີໂທ: " . $row['tel'];
        $output .= "<br>ອີເມວ: " . $row['email'];
    }

    echo $output;
}