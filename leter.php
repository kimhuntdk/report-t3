<?php
require_once( "inc/db_connect.php" );
$mysqli = connect();
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => __DIR__ . '/vendor/fonts/', // ตั้งค่าโฟลเดอร์ที่เก็บไฟล์ฟอนต์
    'fontdata' => [
        'examplefont' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'U' => 'THSarabunNew BoldItalic.ttf'
        ],
    ],
    'default_font_size' => 12, // กำหนดขนาดฟอนต์เริ่มต้นเป็น 12
    'format' => 'A4-L', // กำหนดกระดาษแบบ A4 แนวนอน (Landscape)
]);


//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท 
function Count_Faculty_Master($faculty){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.faculty_name='$faculty'  AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.faculty_name ";
   //echo $sql_count;
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}

//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท ในเวลา
function Count_Major_Master_In($major){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.major_name='$major'  AND report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ'  ";
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}
//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท นอกเวลา
function Count_Major_Master_Out($major){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.major_name='$major'  AND report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ'  ";
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}


$content = '';
$content .= '<h3 style="text-align: center; vertical-align: middle;">สรุปจำนวนนิสิตและบทความวิทยานิพนธ์ปริญญาโทที่ตีพิมพ์เผยแพร่ในระดับชาติและระดับนานาชาติ ที่สำเร็จการศึกษา ประจำเดือน  กค 2566</h3>';
$content .= '<table class="table table-bordered" style="border-collapse: collapse;" width="100%" border="1">
<thead style="display: table-header-group;">
<tr style="height: 46px;">
<td style="text-align: center; vertical-align: middle;" rowspan="3">
<p><code><strong>ลำดับ</strong></code></p>
</td>
<td style="text-align: center; vertical-align: middle;" rowspan="3">
<p><strong>คณะ</strong></p>
</td>
<td style="text-align: center; vertical-align: middle;" rowspan="3">
<p><strong>สาชาวิชา</strong></p>
</td>
<td style="text-align: center; vertical-align: middle;" colspan="2">
<p style="text-align: center;"><strong>ระบบ</strong></p>
</td>
<td style="text-align: center; vertical-align: middle;" rowspan="3">
<p><strong>รวมสำเร็จการศึกษาทั้งหมด </strong><strong><br>(A)</strong></p>
</td>
<td style="text-align: center; vertical-align: middle;" colspan="3">
<p style="text-align: center;"><strong>วิทยานิพนธ์</strong></p>
</td>
<td style="height: 170px; width: 65.3438px;" rowspan="3">
<p style="text-align: center;"><strong>ค่าน้ำหนักคุณภาพฯ (</strong><strong>B)</strong></p>
</td>
<td style="height: 170px; width: 86.6771px;" rowspan="3">
<p style="text-align: center;"><strong>ร้อยละคุณภาพงานวิจัย</strong></p>
<p style="text-align: center;"><strong>C = (B/A)*100</strong></p>
</td>
<td style="height: 170px; width: 75.4688px;" rowspan="3">
<p><strong>คะแนนตามเกณฑ์ สกอ</strong></p>
<p style="text-align: center;"><strong>(</strong><strong>C*5)/80</strong></p>
</td>
</tr>
<tr style="height: 78px;">
<td style="height: 124px; width: 53.2812px;" rowspan="2">
<p><strong>นอกเวาลา</strong></p>
</td>
<td style="height: 124px; width: 44.2396px;" rowspan="2">
<p><strong>ในเวลา</strong></p>
</td>
<td style="text-align: center; vertical-align: middle;" colspan="2">
<p><strong>ค่าน้ำหนักตามเกณฑ์</strong></p>
<p><strong>สกอ.</strong></p>
</td>
<td style="text-align: center; vertical-align: middle;" rowspan="2">
<p><strong>รวม</strong></p>
</td>
</tr>
<tr style="height: 46px;">
<td style="height: 46px; width: 64.3438px; text-align: center;">
<p>0.8</p>
</td>
<td style="text-align: center; vertical-align: middle;">
  1
</td>
</tr>
</thead>';

$sql_group = "SELECT * FROM report_t3_group ORDER BY group_id  ASC";
$rs_group = $mysqli->query($sql_group);
foreach($rs_group as $row_group){
 $sql_data = "SELECT report_t3_graduate.faculty_name FROM report_t3_graduate LEFT JOIN report_t3_faculty  ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th  WHERE report_t3_faculty.faculty_group='$row_group[group_id]' AND report_t3_graduate.round_id=1 AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.faculty_name";
$rs_data = $mysqli->query($sql_data);
$content.= '<tr><td  colspan="12"><h3>'.$row_group['group_name'].'</h3></td>';
foreach ($rs_data  as  $row_data) {

$faculty_name =   $row_data['faculty_name']; 
  $num_group=Count_Faculty_Master($faculty_name);
 if($num_group>0){
$sql_fac = "SELECT * FROM report_t3_graduate WHERE faculty_name='$faculty_name' AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.major_name ";
$rs_fac  = $mysqli->query($sql_fac);
$i=1;
$content.= '<tr><td  colspan="12"><h4>'.$faculty_name.'</h4></td>';
$tatal_ma_in = 0;
$tatal_ma_out = 0;
$sum_in_out = 0;
foreach ($rs_fac  as  $row_fac) {
$content.= '<tr style="height: 46px;">
<td style="height: 46px; width: 38.2083px; text-align: center; vertical-align: middle;">'.$i;
$content.= '</td>
<td style="height: 46px; width: 136.719px;" colspan="2">
<p>'.$row_fac['major_name'].'</p>
</td>
<td style="height: 46px; width: 53.2812px; text-align: center; vertical-align: middle;">
<p>'.$master_in=intval(Count_Major_Master_In($row_fac['major_name'])).'</p>
</td>
<td style="height: 46px; width: 44.2396px; text-align: center; vertical-align: middle;">
<p>'.$master_out=intval(Count_Major_Master_Out($row_fac['major_name'])).'</p>
</td>
<td style="height: 46px; width: 67.3542px; text-align: center; vertical-align: middle;">
<p>'.$sum_in_out=intval(Count_Major_Master_In($row_fac['major_name'])+Count_Major_Master_Out($row_fac['major_name'])).'</p>
</td>
<td style="height: 46px; width: 64.3438px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 60.3229px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 37.2083px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 65.3438px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 86.6771px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 75.4688px;">
<p>&nbsp;</p>
</td>
</tr>';
$tatal_ma_in = ((int)$tatal_ma_in + (int)$master_in);
$tatal_ma_out = ((int)$tatal_ma_out + (int)$master_out);
$sum_in_out = ((int)$tatal_ma_out + (int)$tatal_ma_in);
$i++;
}

$content.= '<tr style="height: 46px;">
<td style="height: 46px; width: 38.2083px; text-align: center; vertical-align: middle;">';
$content.= '</td>
<td style="height: 46px; width: 136.719px;" colspan="2">
<h3>รวม</h3>
</td>
<td style="height: 46px; width: 53.2812px; text-align: center; vertical-align: middle;">
'.$tatal_ma_in.'
</td>
<td style="height: 46px; width: 44.2396px; text-align: center; vertical-align: middle;">
'.$tatal_ma_out.'
</td>
<td style="height: 46px; width: 67.3542px; text-align: center; vertical-align: middle;">
'.$sum_in_out.'
</td>
<td style="height: 46px; width: 64.3438px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 60.3229px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 37.2083px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 65.3438px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 86.6771px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 75.4688px;">
<p>&nbsp;</p>
</td>
</tr>';
$content.= '</tr>';
 }
 $content.= '</tr>';
//  }
}
}
$content .='</tbody>
</table>';
$mpdf->WriteHTML($content);
//echo 'จำนวนแถวที่เหลือ: ' . $remainingLines;
$mpdf->Output();

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<style type="text/css">
.textAlignVer{
    display:block;
    filter: flipv fliph;
    -webkit-transform: rotate(-90deg); 
    -moz-transform: rotate(-90deg); 
    transform: rotate(-90deg); 
    position:relative;
    width:20px;
    white-space:nowrap;
    font-size:12px;
    margin-bottom:10px;
}
</style>