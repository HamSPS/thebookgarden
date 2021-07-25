<?php 
    include '../connectdb.php';
    include '../check-login.php';

    $getid = $_GET['cusid'];
    $sql = "SELECT * FROM tbcustomer WHERE cusID = '$getid'";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    
    $content = '';
?>

<?php
        require_once '../vendor/autoload.php';

        $mdpf = new \Mpdf\Mpdf([
            'format'    => [59,127],
            'orientation' => 'L',
            'mode'      => "utf-8",
            'default_font_size' => 10,
            'margin_top' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'default_font'  => 'phetsarath_ot',
        ]);
        $content = '
            <style>
            body{
                background: url("../images/card-background.png");
                background-attachment: fixed;
                background-position: top;
            }
                table {
                    width: 100%;
                    height: 100%;
                    vertical-align: top;
                }
                table .header {
                    font-size: 14pt;
                    font-weight: bold;
                    padding: 5px 10px;
                    background: #d1ecf1;
                    color: #0c5460;
                    vertical-align: middle;
                    height: 53.2px;
                }

               
                .td-img{
                    width: 100px;
                }

                img {
                    width: 100px;
                    height: 135px;
                    margin: 0;
                    padding: 0;
                }
                .tb-detail{
                    width: 120px;
                    padding-left: 5px;
                    text-align: right;
                    padding: 0px;
                }
                .content{
                    text-align: left;
                    padding-left: 5px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;

                }
                .footer{
                    color: #0c5460;
                    background: #d1ecf1;
                    padding: 5px 15px;

                }

                .header .logo{
                    font-weight: bold;
                    width: 45px;
                    height: 45px;
                    background: #fff;
                    border-radius: 50px;
                    background: url("../images/icon.png");
                background-repeat: no-repeat;
                background-size: 250px 100%;
                }
            </style>
        ';

        $content .= '
        <table>
        <tr>
            <td colspan="3" class="header">
            <p class="logo"> ຮ້ານສວນໜັງສື</p>
            </td>
        </tr>
        <tr>
            <td class="td-img" rowspan="5">
                <img src="../'.$row["img"].'" style="object-fit: cover;" alt="ຮູບ" />
            </td>
            <td class="tb-detail">ລະຫັດ:</td>
            <td class="content">'.$row["cusID"].'</td>
        </tr>
        <tr>
            <td class="tb-detail">ຊື່ ແລະ ນາມສະກຸນ:</td>
            <td class="content">'.$row["cusName"].'</td>
        </tr>
        <tr>
            <td class="tb-detail">ເພດ:</td>
            <td class="content">'.$row["gender"].'</td>
        </tr>
        <tr>
            <td class="tb-detail">ທີ່ຢູ່:</td>
            <td class="content">'.$row["address"].'</td>
        </tr>
        <tr>
            <td class="tb-detail">ເບີໂທ:</td>
            <td class="content">'.$row["tel"].'</td>
        </tr>
        <tr>
            <td class="footer" colspan="3">
            ເບີໂທ: 020 28 216 900
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            Facebook: ຮ້ານສວນໜັງສື
            </td>
        </tr>
    </table>
        ';

    // echo $content;
    $mdpf->WriteHTML($content);
    $mdpf->Output("employee.pdf","I");
    ?>