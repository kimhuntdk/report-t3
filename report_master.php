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
    'default_font' => 'examplefont', // กำหนดฟอนต์เริ่มต้น
    'format' => 'A4-L', // กำหนดกระดาษแบบ A4 แนวนอน (Landscape)
]);
//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท กลุ่มมนุษศาสตร์
function Count_Faculty_GROUP($faculty,$GROUP){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_faculty.faculty_group='$GROUP' AND  report_t3_graduate.faculty_name='$faculty'  AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.faculty_name ";
   // echo $sql_count;
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}

//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท 
function Count_Faculty_Master($faculty){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.faculty_name='$faculty'  AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.faculty_name ";
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
$content .= '<h3>สรุปจำนวนนิสิตและบทความวิทยานิพนธ์ปริญญาโทที่ตีพิมพ์เผยแพร่ในระดับชาติและระดับนานาชาติ ที่สำเร็จการศึกษา ประจำเดือน  กค 2566</h3>';
$content .= '<table cellspacing="0" class="MsoTableGrid" style="border-collapse:collapse; border:none; margin-left:-18px; width:948px">

<thead style="display: table-header-group;">
    <tr>
        <td rowspan="3" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:40px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ลำดับ</span></span></strong></span></span></p>
        </td>
        <td rowspan="3" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:102px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">คณะ</span></span></strong></span></span></p>
        </td>
        <td rowspan="3" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:147px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">สาชาวิชา</span></span></strong></span></span></p>
        </td>
        <td colspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:93px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ระบบ</span></span></strong></span></span></p>
        </td>
        <td rowspan="3" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:59px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">รวมสำเร็จการศึกษาทั้งหมด </span></span></strong><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(A)</span></span></strong></span></span></p>
        </td>
        <td colspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:126px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ประเภท</span></span></strong></span></span></p>
        </td>
        <td colspan="7" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:204px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ผลงานตีพิมพ์ในวงรอบเดือน </span></span></strong><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">xxx ปีการศึกษา 2566</span></span></strong></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:57px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ค่าน้ำหนักคุณภาพฯ (</span></span></strong><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">B)</span></span></strong></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:71px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ร้อยละคุณภาพงานวิจัย</span></span></strong></span></span></p>

        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">C = (B/A)*100</span></span></strong></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:49px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">คะแนนตามเกณฑ์ สกอ</span></span></strong></span></span></p>

        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(</span></span></strong><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">C*5)/80</span></span></strong></span></span></p>
        </td>
    </tr>
    <tr>
        <td rowspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:57px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">นอกเวาลา</span></span></strong></span></span></p>
        </td>
        <td rowspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:36px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ในเวลา</span></span></strong></span></span></p>
        </td>
        <td rowspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:60px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">การศึกษาค้นคว้าอิสระ</span></span></strong></span></span></p>
        </td>
        <td rowspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:66px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">วิทยานิพนธ์</span></span></strong></span></span></p>
        </td>
        <td colspan="6" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:165px">
        <p style="margin-right:30px; text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ค่าน้ำหนักตามเกณฑ์</span></span></strong></span></span></p>

        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">สกอ.</span></span></strong></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:39px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">รวม</span></span></strong></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; width:57px">&nbsp;</td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">&nbsp;</td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; width:49px">&nbsp;</td>
    </tr>
    <tr>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:30px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.1</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.2</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.4</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.6</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.8</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:21px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">1</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; width:39px">&nbsp;</td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; width:57px">&nbsp;</td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none">&nbsp;</td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; width:49px">&nbsp;</td>
    </tr>
    </thead>
    <tbody>';
//กลุ่ม
$sql_group = "SELECT * FROM report_t3_group ORDER BY group_id  ASC";
$rs_group = $mysqli->query($sql_group);
foreach($rs_group as $row_group){
    $content .='<tr>
        <td colspan="18" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; width:948px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><h3>'.$row_group['group_name'].'</h3></span></span></span></span></p>
        </td>
    </tr>';

//คณะ // สาขา
$sql_data = "SELECT report_t3_graduate.faculty_name FROM report_t3_graduate LEFT JOIN report_t3_faculty  ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th  WHERE report_t3_faculty.faculty_group='$row_group[group_id]' AND report_t3_graduate.round_id=1 AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.faculty_name";
$rs_data = $mysqli->query($sql_data);
$i=1;
foreach ($rs_data  as  $row_data) {
$faculty_name =   $row_data['faculty_name']; 

  $num_group=Count_Faculty_Master($faculty_name);
 if($num_group>0){
    
    $content .='<tr>
        <td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:40px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'.$i.'</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:102px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'.$faculty_name.'</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:147px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:57px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:36px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:59px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:60px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:66px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:30px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:21px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:39px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:57px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:71px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:49px">
        <p>&nbsp;</p>
        </td>
    </tr>';
     $sql_fac = "SELECT * FROM report_t3_graduate WHERE faculty_name='$faculty_name' AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.major_name ";
    $rs_fac  = $mysqli->query($sql_fac);
    $master_in = 0;
    $master_out = 0;
    $tatal_ma_in = 0;
    $tatal_ma_out = 0;
    $sum_in_out = 0;
    $tatal_sum_in_out = 0;
    $j=1;
    foreach ($rs_fac  as  $row_fac) {
        $content .='<tr>
        <td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; width:40px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:102px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:147px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'.$row_fac['major_name'].'</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:57px">
        <p>'.$master_in=intval(Count_Major_Master_In($row_fac['major_name'])).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:36px">
        <p>'.$master_out=intval(Count_Major_Master_Out($row_fac['major_name'])).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:59px">
        <p>'.$sum_in_out=intval(Count_Major_Master_In($row_fac['major_name'])+Count_Major_Master_Out($row_fac['major_name'])).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:60px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:66px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:30px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:21px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:39px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:57px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:71px">
        <p>&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:49px">
        <p>&nbsp;</p>
        </td>
    </tr>';
    $tatal_ma_in = ((int)$tatal_ma_in + (int)$master_in);
    $tatal_ma_out = ((int)$tatal_ma_out + (int)$master_out);
    $tatal_sum_in_out = ((int)$tatal_ma_out + (int)$tatal_ma_in);
    }//สาขา

    $i++;//นับลำดับคณะ
    //รวม
    $content .='<tr>
    <td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; width:40px">
    <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:102px">
    <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:147px">
    <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">รวม</span></span></span></span></p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:57px">
    <p>'.$tatal_ma_in.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:36px">
    <p>'.$tatal_ma_out.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:59px">
    <p>'.$tatal_sum_in_out.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:60px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:66px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:30px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:21px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:39px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:57px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:71px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:49px">
    <p>&nbsp;</p>
    </td>
</tr>';
 } //เฉพาะคณะที่มีข้อมูล
 }//คณะ
} //กลุ่ม
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