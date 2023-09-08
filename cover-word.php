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
//     'default_font' => 'examplefont', // กำหนดฟอนต์เริ่มต้น
// ]);
//รอบที่เลือก
$id = $_GET['id'];
if(!isset($id)){
    header('location:index.php');
}
function count_degree($degree_name,$id){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.degree_name='$degree_name' AND report_t3_graduate.round_id IN ($id)  GROUP BY report_t3_graduate.degree_name     ";
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}
//ดึงข้อมูลตามระดับ
 $sqlDe = "SELECT * FROM report_t3_degree INNER  JOIN report_t3_graduate ON report_t3_degree.degree_name=report_t3_graduate.degree_name AND report_t3_graduate.round_id IN ($id)  GROUP BY report_t3_degree.degree_name order by degree_id DESC  ";
$rsDe =  $mysqli->query($sqlDe);
foreach($rsDe as $rowDe){
  //  $mpdf->AddPage();

  $numddd = count_degree($rowDe['degree_name'],$id);
//ข้อมูลมีในระบบ
 echo $sql = "SELECT *
FROM report_t3_graduate
INNER JOIN report_t3_registration ON report_t3_graduate.std_id = report_t3_registration.std_id WHERE  report_t3_graduate.degree_name='$rowDe[degree_name]' AND report_t3_graduate.round_id IN ($id) GROUP BY report_t3_graduate.major_name ";
$data = $mysqli->query($sql);
$row_data_1 = $data->fetch_array();
$num_data = $data->num_rows;
$i=1;
   
    //นับจำนวนมากกว่า
    
    // สร้างเนื้อหาของหน้ารายงาน
    
    $content = '';
    // $content .= "<h3>$rowDe[degree_name]</h3>";
    // $content .= "<table class='table table-bordered' width='100%' border='1' style='border-collapse: collapse;'>";
    // $content .= '<thead style="display: table-header-group;"><tr><th style="width: 5%;">ลำดับ</th><th style="width: 10%;">รหัสนิสิต</th><th style="width: 10%;">ชื่อ-นาสกุล</th><th style="width: 15%;">คณะ/วิทยาลัย/
    // สถาบัน</th><th style="width: 15%;">สาขา</th><th style="width: 5%;">ฐานข้อมูล</th><th style="width: 10%;">อนุมัติเล่ม</th><th style="width: 10%;">English
    // Test</th></tr></thead>';
    // foreach ($data as $row) {
    // $content .= '<tr><td style="text-align: center; vertical-align: middle;">' . $i . '</td><td style="text-align: center; vertical-align: middle;">' . $row['std_id'] . '</td><td>' . $row['title'].$row['fname']. ' '.$row['lname']  . '</td><td>' . $row['faculty_name'] . '</td><td>' . $row['major_name'] . '</td><td>' . $row['database'] . '</td><td style="text-align: center; vertical-align: middle;">' . DateThai1($row['approval_date']) . '</td><td style="text-align: center; vertical-align: middle;">' . $row['exam_eng'] . '</td></tr>';
    //  $i++;  

    // }

    // $content .= '</table>';

   //echo $content; 
   $content .= '<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:16.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'.$rowDe['degree_name'].'</span></span></strong></span></span></p>';
   $content .= '<table cellspacing="0" class="Table" style="border-collapse:collapse; width:100.0%">
   <thead style="display: table-header-group;"
       <tr>
           <td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; width:93px">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ลำดับ</span></span></strong></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; width:186px">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">รหัสนิสิต</span></span></strong></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; width:186px">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ชื่อ-นาสกุล</span></span></strong></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; width:279px">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">คณะ/วิทยาลัย/ สถาบัน</span></span></strong></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; width:279px">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">สาขา</span></span></strong></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; width:124px">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ฐานข้อมูล</span></span></strong></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; width:186px">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">อนุมัติเล่ม</span></span></strong></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; width:186px">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">English Test</span></span></strong></span></span></p>
           </td>
       </tr>
   </thead>
   <tbody>';
   foreach ($data as $row) {

     $content.='<tr>
           <td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'. $i .'</span></span></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">' . $row['std_id'] . '</span></span></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">
           <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">' . $row['title'].$row['fname']. ' '.$row['lname']  . '</span></span></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">
           <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">' . $row['faculty_name'] . '</span></span></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">
           <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">' . $row['major_name'] . '</span></span></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">
           <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">' . $row['database'] . '</span></span></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">วันที่ </span></span><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">21 มกราคม 2023</span></span></span></span></p>
           </td>
           <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">
           <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ผ่าน</span></span></span></span></p>
           </td>
       </tr>';
       $i++;  
   }
   $content.='</tbody>
</table>';
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