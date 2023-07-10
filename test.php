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
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100&display=swap" rel="stylesheet">
</head>
<style type="text/css">

body {
    font-family: 'Sarabun', sans-serif;
}

</style>
<body>

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

</body>
</html>