<?php 
    include '../connectdb.php';
    include '../check-login.php';
    
    $content = '';
?>

<?php
        require_once '../vendor/autoload.php';

        $mdpf = new \Mpdf\Mpdf([
            'format'    => "A4",
            'mode'      => "utf-8",
            'default_font_size' => 10,
            'margin_top' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
            'default_font'  => 'phetsarath_ot',
        ]);

        $content = '
        <style>
            .page{
                width: 100%;
                height: 29.7cm;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            .title{
                display: block;
                padding: 5px 0;
            }
            .img-back{
                width: 250px;
                height: 75px;
                background: url("../images/icon.png");
                background-repeat: no-repeat;
                background-size: 250px 100%;
            }
            .img-back p{
                padding-left: 100px;
                padding-top: 25px;
            }
            .title .img-title{
                width: 100px;
                height: auto;
                background: #fff;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 15px;
            }
            table{
                width: 100%;
                border-collapse: collapse;
            }
            table td, table th{
                border: 1px solid #ddd;
                padding: 8px;
            }
            th{
                width: fit-content;
                background: #04AA6D;
                color: #fff;
                text-align: center;
                padding-top: 12px;
                padding-bottom: 12px;
            }
            .source{
                font-size: 12px;
                position: fixed;
                padding-left: 5px;
            }
            .source p {
                padding: -5 0;
            }
            .table-footer{
                background: #f7f4cd;
                border: 1px solid #ddd;
            }
            .table-footer td{
                border: none;
            }
        </style>
        ';

        $content .= '
            <div class="page">

                <div class="title">
                <div class="img-back">
                <p>ຮ້ານສວນໜັງສື<br/>
                The Book Garden</p>
                </div>
                </div>
                <div class="source">
                <p>ສະຖານທີ່: ບ້ານຫ້ວຍຫົງ ເມື່ອງໄຊທານີ ນະຄອນຫຼວງ</p>
                <p>ເບີໂທຕິດຕໍ່: 020 28 216 900</p>
                <p>Facebook: The Book Garden</p>
                </div>
                <h3 style="text-align: center;"><u>ລາຍງານຂໍ້ມູນພະນັກງານ</u></h3>
                    <div style="text-align: right;">
                        <p>ວັນທີ: '.date("d/m/Y").' </p>
                        <p>ຜູ້ໃຊ້ງານ: '. $_SESSION['name'] .'</p>
                    </div>
    <table>
        <thead class="table-primary text-center">
            <tr>
                <th>ລະຫັດ</th>
                <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                <th>ເພດ</th>
                <th>ອາຍຸ</th>
                <th>ຊື່ບັນຊີຜູ້ໃຊ້</th>
                <th>ອີເມວ</th>
            </tr>
        </thead>
        <tbody>
        '; 
        $sum = 0;
        $sql = "SELECT stid, FirstName, lastName,gender,dateOfBirth,year(curdate())-year(dateOfBirth) AS age,address,img,tel,email,username FROM tbstaff";
    $query_emp = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($query_emp)) {
            $sum++;
            $content .='
            <tr>
                <td style="text-align: center">'. $row['stid'] .'</td>
                <td>'. $row['FirstName'] .' '. $row['lastName'] .'</td>
                <td style="text-align: center">'. $row['gender'] .'</td>
                <td style="text-align: right">'. $row['age'] .'</td>
                <td>'. $row['username'] .'</td>
                <td>'. $row['email'] .'</td>
            </tr>';
                            }
        mysqli_free_result($query_emp);
        mysqli_next_result($con);
        $content .='
            <tr class="table-footer">
                <td align="right" colspan="5">ລວມ:</td>
                <td>'.$sum.' ຄົນ</td>
            </tr>
        </tbody>
    </table>

    </div>
    ';

    // echo $content;
    $mdpf->WriteHTML($content);
    $mdpf->Output("employee.pdf","I");
    ?>