<?php
header("Content-Type: application/msword");
header('Content-Disposition: attachment; filename="filename.doc"');
require_once( "inc/db_connect.php" );
$mysqli = connect();
// require_once __DIR__ . '/vendor/autoload.php';

// $mpdf = new \Mpdf\Mpdf([
//     'fontDir' => __DIR__ . '/vendor/fonts/', // ตั้งค่าโฟลเดอร์ที่เก็บไฟล์ฟอนต์
//     'fontdata' => [
//         'examplefont' => [
//             'R' => 'THSarabunNew.ttf',
//             'I' => 'THSarabunNew Italic.ttf',
//             'B' => 'THSarabunNew Bold.ttf',
//             'U' => 'THSarabunNew BoldItalic.ttf'
//         ],
//     ],
//     'format' => 'A4-L', // กำหนดกระดาษแบบ A4 แนวนอน (Landscape)
// ]);
//รอบที่เลือก
$id = $_GET['id'];
if(!isset($id)){
    header('location:index.php');
}
// ดึงข้อมูลแสดงเดือน
$sqlround = "SELECT round_name FROM report_t3_round   WHERE round_id=$id  ";
$rsround =  $mysqli->query($sqlround);
$rowround = $rsround->fetch_array();
$mount  = $rowround['round_name'];
//ดึงข้อมูลตามระดับ
$sqlDe = "SELECT * FROM report_t3_degree order by degree_id ASC  ";
$rsDe =  $mysqli->query($sqlDe);
foreach($rsDe as $rowDe){
   // $mpdf->AddPage();
//ข้อมูลมีในระบบ
$sql = "SELECT *
FROM report_t3_graduate
LEFT JOIN report_t3_registration ON report_t3_graduate.std_id = report_t3_registration.std_id WHERE  report_t3_graduate.degree_name='$rowDe[degree_name]' AND report_t3_graduate.round_id=$id GROUP BY report_t3_graduate.major_name ";
$data = $mysqli->query($sql);
$num_data = $data->num_rows;
$i=1;
$css = '
<style type="text/css">
table {
    font-size: 20px;
}
.orange {
    background-color: orange;
  }
  tr:nth-child(odd) {
    background-color: lightgray;
  }
  tr:nth-child(even) {
    background-color: white; 
  }  

</style>';

$content = $css . 
   
     
    // สร้างเนื้อหาของหน้ารายงาน
    $content = '';
    $content .= "<h2 style='text-align: center; vertical-align: middle;'>รายชื่อนิสิตและบทความวิทยานิพนธ์$rowDe[degree_name]ที่ได้รับการตอบรับหรือตีพิมพ์เผยแพร่ในระดับชาติหรือระดับนานาชาติ ที่สำเร็จการศึกษา ประจำเดือน $mount</h2>";
    $content .= "<table class='table table-bordered' width='100%' border='1' style='border-collapse: collapse;'>";
    $content .= '<thead style="display: table-header-group;"><tr><th style="width: 5%;">ลำดับ</th><th style="width: 10%;">รหัสนิสิต</th><th style="width: 10%;">ชื่อ-นาสกุล</th><th style="width: 15%;">คณะ/วิทยาลัย/
    สถาบัน</th><th style="width: 15%;">สาขา</th><th>ผลงานตีพิมพ์ที่ผ่านเกณฑ์ตามประกาศมหำวิทยาลัยมหาสารคาม</th><th style="width: 5%;">ฐานข้อมูล</th><th style="width: 10%;"> ค่ำน ำหนัก
    ตำมเกณฑ์
    สกอ.</th><th style="width: 10%;">หมายเหตุ
    </th></tr></thead>';
    foreach ($data as $row) {
    $content .= '<tr><td style="text-align: center; vertical-align: middle; height: 150px;"><h4>' . $i . '</h4></td><td style="text-align: center; vertical-align: middle; style="font-size:20pt"">' . $row['std_id'] . '</td><td>' . $row['title'].$row['fname']. ' '.$row['lname']  . '</td><td>' . $row['faculty_name'] . '</td><td>' . $row['major_name'] . '</td><td>' . $row['published_work'] . '</td><td>' . $row['database'] . '</td><td style="text-align: center; vertical-align: middle;">' . $row['weight'] . '</td><td>' . $row['note'] . '</td></tr>';
     $i++;  

    }
    $content .= '</table>';
echo $content;
// แสดงหัวตารางในทุกหน้าที่มีข้อมูล

// $mpdf->SetHTMLHeader('
// <table class="table table-bordered" width="100%" border="1" style="border-collapse: collapse;">
// <tr><th>ลำดับ</th><th>รหัสนิสิต</th><th>ชื่อ-นาสกุล</th><th>คณะ/วิทยาลัย/
// สถาบัน</th><th>สาขา</th><th>ฐานข้อมูล</th><th>อนุมัติเล่ม</th><th>English
// Test</th></tr>
// </table>');
// $mpdf->SetHTMLFooter('<div style="text-align: center;">หน้า '.$page.'/{nb}</div>');
// // วนลูปเพิ่มหน้า PDF ในที่นี้ไม่รวมหน้าแรก

// for ($page = 2; $page <= $mpdf->page; $page++) {
//     $mpdf->AddPage();

//     $mpdf->WriteHTML($content);
//     // แสดงหมายเลขหน้า
//     $current_page = $page; // เก็บค่าหน้าปัจจุบันในตัวแปร $current_page
// }
//$mpdf->WriteHTML($content);

//echo 'จำนวนแถวที่เหลือ: ' . $remainingLines;
} 
//$mpdf->Output();

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>