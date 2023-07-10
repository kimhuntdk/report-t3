<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Wordfile.doc");
header("Pragma: no-cache");
header("Expires: 0");
require_once( "inc/db_connect.php" );
$mysqli = connect();
 $sql = "SELECT *
 FROM report_t3_graduate
 LEFT JOIN report_t3_registration ON report_t3_graduate.std_id = report_t3_registration.std_id limit 100";
 $data = $mysqli->query($sql);
 $i=1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Word</title>
    <style>
@font-face {
  font-family: 'THSarabunNew';
  src: url('vendor/fonts/THSarabunNew.ttf') format('truetype');
}

body {
  font-family: 'THSarabunNew', sans-serif;
}
table {
        font-family: 'TH SarabunNew', sans-serif;
    }
@page Section1 {size:595.45pt 841.7pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
div.Section1 {page:Section1;}
@page Section2 {size:841.7pt 595.45pt;mso-page-orientation:landscape;margin:1.25in 1.0in 1.25in 1.0in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
div.Section2 {page:Section2;}
</style>
</head>
<body>
<div class=Section2>
    <table width='100%' border='1' style='border-collapse: collapse;'>
        <tr>
        <th>ลำดับ</th>
        <th>รหัสประจำตัวนิสิต</th>
        <th>ชื่อสกุล</th>
        <th>คณะ</th>
        <th>สาขา</th>
        <th>ฐานข้อมูล</th>
        <th>อนุมัติเล่ม</th> 
        <th>English Test</th>
        </tr>
        <?php
        foreach ($data as $row) {
        echo  '<tr><td>' . $i . '</td><td>' . $row['std_id'] . '</td><td>' . $row['title'].$row['fname']. ' '.$row['lname']  . '</td><td>' . $row['faculty_name'] . '</td><td>' . $row['major_name'] . '</td><td>' . $row['database'] . '</td><td>' . $row['approval_date'] . '</td><td>' . $row['exam_eng'] . '</td></tr>';
        $i++;  
        }
?>
    </table>
</div>
</body>
</html>