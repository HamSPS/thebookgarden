<?php

include '../connectdb.php';
if (isset($_POST['stid'])) {
    $stid = $_POST['stid'];
    $output = '';
    // $sql = "SELECT e.stid, e.name, e.gender, e.dateOfBirth, year(curdate())-year(e.dateOfBirth) AS age,"
    //         . " e.address, e.img, d.name AS department, s.sal, e.incentive, s.sal+e.incentive AS total"
    //         . ", e.language FROM emp e JOIN dept d ON e.dno=d.dno JOIN salary s ON e.grade=s.grade"
    //         . " WHERE e.stid='$stid' ";
    $sql = "SELECT stid, FirstName, LastName,gender,dateOfBirth,year(curdate())-year(dateOfBirth) AS age,address,img,tel,email FROM tbstaff WHERE stid = '$stid'";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $img = is_numeric($row['img']) ? "avatar_img.png" : $row['img'];
        $output .= '<p style="text-align: center">';

        if (empty($img)) {
            $output .= '<img src="images/user.jpg" alt="ຮູບພະນັກງານ" width="150px" height="200px"  class="img-thumbnail">';
        }else{
            $output .= '<img src="'.$img.'" alt="ຮູບພະນັກງານ" width="150px" height="200px"  class="img-thumbnail">';
        }
        $output .= ' </p>';
        $output .= "<br>ລະຫັດພະນັກງານ: " . $row['stid'];
        $output .= "<br>ຊື່ ແລະ ນາມສະກຸນ: " . $row['FirstName'] . " ". $row['LastName'];
        $output .= "<br>ເພດ: " . $row['gender'];
        $output .= "<br>ວັນ, ເດືອນ, ປີເກີດ: " . date('d / m / Y', strtotime($row['dateOfBirth']));
        $output .= "<br>ອາຍຸ: " . $row['age'] . " ປີ";
        $output .= "<br>ທີ່ຢູ່: " . $row['address'];
        $output .= "<br>ເບີໂທ: " . $row['tel'];
        $output .= "<br>ອີເມວ: " . $row['email'];
        // $output .= "<br>ເງິນອຸດໜູນ: " . number_format($row['incentive']) . " ກີບ";
        // $output .= "<br>ລາຍຮັບລວມ: " . number_format($row['total']) . " ກີບ";
        // $output .= "<br>ພາສາຕ່າງປະເທດ: " . $row['language'];
    }

    echo $output;
}