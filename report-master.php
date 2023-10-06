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
    'format' => 'A4-L', // กำหนดกระดาษแบบ A4 แนวนอน (Landscape)
]);
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
//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท กลุ่มมนุษศาสตร์
function Count_Faculty_GROUP($faculty,$GROUP,$id){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_faculty.faculty_group='$GROUP' AND  report_t3_graduate.faculty_name='$faculty' AND report_t3_graduate.round_id=$id   AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.faculty_name ";
   // echo $sql_count;
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}

//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท 
function Count_Faculty_Master($faculty,$id){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.faculty_name='$faculty' AND report_t3_graduate.round_id=$id   AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.faculty_name ";
    //echo $sql_count;
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}

//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท ในเวลา
function Count_Major_Master_In($major,$id){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.major_name='$major' AND report_t3_graduate.round_id=$id   AND report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ'  ";
    // $sql_count;
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}
//นับจำนวนว่ามีข้อมูลในกลุ่มหรือไม่ ปริญญาโท นอกเวลา
function Count_Major_Master_Out($major,$id){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.major_name='$major' AND report_t3_graduate.round_id=$id   AND report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ'  ";
   // echo $sql_count;
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}
//นับจำนวนค่าน้ำหนักการตีพิมพ์ ปริญญาโท นอกเวลา
function Count_Major_Master_weight($major,$weight,$id){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate LEFT JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.major_name='$major'  AND report_t3_graduate.weight='$weight' AND report_t3_graduate.round_id=$id   AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) ";
   // echo $sql_count;
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}
//นับจำนวนประเภทวิทยานิพนธ์ สารนิพนธ์
function Count_Major_Master_ThesisIS($major,$thesis_is_type,$id){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate INNER JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= " report_t3_graduate.major_name='$major' AND report_t3_graduate.round_id=$id   AND report_t3_graduate.thesis_is_type='$thesis_is_type'  AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) ";
   // echo $sql_count;
    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}
//นับจำนวนทั้งหมด is หรือ thesis 
function Count_SUM_Master_ThesisIS($thesis_is_type,$id){
    $mysqli = connect();
    $sql_count = "SELECT report_t3_graduate.std_id  FROM report_t3_graduate INNER JOIN report_t3_faculty ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  ";
    $sql_count .= "   report_t3_graduate.round_id=$id   AND report_t3_graduate.thesis_is_type='$thesis_is_type'  AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) ";

    $rs_count = $mysqli->query($sql_count);
    $num_count = $rs_count->num_rows;
    return $num_count;
}

$content = '';
$content = '<style>.textAlignVer{
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

.orange {
      background-color: orange;
    }
    tr:nth-child(odd) {
      background-color: lightgray;
    }
    tr:nth-child(even) {
      background-color: white; 
    }   body {
        font-size: 16px; 
      }
      td {
        font-size: 14px; 
      }
</style>';
$content .= '<h3 style="text-align: center; vertical-align: middle;font-size: 22px; ">สรุปจำนวนนิสิตและบทความวิทยานิพนธ์ปริญญาโทที่ตีพิมพ์เผยแพร่ในระดับชาติและระดับนานาชาติ ที่สำเร็จการศึกษา ประจำเดือน  '.$mount.'</h3>';
$content .= '<table cellspacing="0" class="MsoTableGrid table table-striped" style="border-collapse:collapse;  border:none; margin-left:-18px; width:948px">

<thead style="display: table-header-group; background-color: orange;">
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
        <td colspan="2" style="border-bottom:1px solid black; border-left:none; text-align: center; vertical-align: middle;  border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:93px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot; text-align: center; vertical-align: middle;  ">ระบบ</span></span></strong></span></span></p>
        </td>
        <td rowspan="3" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:59px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">รวมสำเร็จการศึกษาทั้งหมด </span></span></strong><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(A)</span></span></strong></span></span></p>
        </td>
        <td colspan="2" style="border-bottom:1px solid black; text-align: center; vertical-align: middle;  border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:126px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ประเภท</span></span></strong></span></span></p>
        </td>
        <td colspan="7" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:204px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ผลงานตีพิมพ์ในวงรอบเดือน </span></span></strong><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'.$mount.'</span></span></strong></span></span></p>
        </td>
        <td rowspan="3" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:57px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ค่าน้ำหนักคุณภาพฯ (</span></span></strong><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">B)</span></span></strong></span></span></p>
        </td>
        <td rowspan="3" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:71px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ร้อยละคุณภาพงานวิจัย</span></span></strong></span></span></p>

        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">C = (B/A)*100</span></span></strong></span></span></p>
        </td>
        <td rowspan="3" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:49px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">คะแนนตามเกณฑ์ สกอ</span></span></strong></span></span></p>

        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(</span></span></strong><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">C*5)/40</span></span></strong></span></span></p>
        </td>
    </tr>
    <tr style="background-color: lightgray;">
        <td rowspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:57px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">นอกเวาลา</span></span></strong></span></span></p>
        </td>
        <td rowspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:36px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ในเวลา</span></span></strong></span></span></p>
        </td>
        <td rowspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:60px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">การศึกษาค้นคว้าอิสระ</span></span></strong></span></span></p>
        </td>
        <td rowspan="2" class="textAlignVer" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:66px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">วิทยานิพนธ์</span></span></strong></span></span></p>
        </td>
        <td colspan="6" style="border-bottom:1px solid black; text-align: center; vertical-align: middle;  border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:165px">
        <p style="margin-right:30px; text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ค่าน้ำหนักตามเกณฑ์</span></span></strong></span></span></p>

        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">สกอ.</span></span></strong></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:39px">
        <p style="text-align:center"><b>รวม</b></p>
        </td>
        
    </tr>
    <tr>
        <td style="border-bottom:1px solid black; border-left:none; text-align: center; vertical-align: middle;  border-right:1px solid black; border-top:none; vertical-align:top; width:30px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.1</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; text-align: center; vertical-align: middle;  border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.2</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; text-align: center; vertical-align: middle;  border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.4</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; text-align: center; vertical-align: middle;  border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.6</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; text-align: center; vertical-align: middle;  border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">0.8</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; text-align: center; vertical-align: middle;  border-right:1px solid black; border-top:none; vertical-align:top; width:21px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">1</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; width:39px">&nbsp;</td>
        
    </tr>
    </thead>
    <tbody>';
    $sum_all = 0;
    $sum_all_in = 0;
    $sum_all_out = 0;
                //ค่าน้ำหนัก
                $weight_01=0;
                $weight_02=0;
                $weight_04=0;
                $weight_06=0;
                $weight_08=0;
                $weight_1=0;
                $sum_weight_01=0;
                $sum_weight_02=0;
                $sum_weight_04=0;
                $sum_weight_06=0;
                $sum_weight_08=0;
                $sum_weight_1=0;
                $sum_master_in=0;
//กลุ่ม
 $sql_group = "SELECT * FROM report_t3_group INNER JOIN report_t3_faculty ON report_t3_group.group_id =report_t3_faculty.faculty_group  INNER JOIN report_t3_graduate  ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th WHERE  (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) AND report_t3_graduate.round_id=$id  GROUP BY  report_t3_group.group_id ORDER BY report_t3_group.group_id  ASC";
$rs_group = $mysqli->query($sql_group);
foreach($rs_group as $row_group){
    $content .='<tr>
        <td colspan="18" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; width:948px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><h3>'.$row_group['group_name'].'</h3></span></span></span></span></p>
        </td>
    </tr>';

        // Thesis/is
        $thesis = 0;
        $is = 0;
        $sum_thesis=0;
        $sum_is=0;

//คณะ // สาขา
 $sql_data = "SELECT report_t3_graduate.faculty_name FROM report_t3_graduate INNER JOIN report_t3_faculty  ON report_t3_graduate.faculty_name=report_t3_faculty.faculty_name_th  WHERE report_t3_faculty.faculty_group='$row_group[group_id]' AND report_t3_graduate.round_id=$id   AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) GROUP BY report_t3_graduate.faculty_name";
$rs_data = $mysqli->query($sql_data);
$i=1;
//echo "<br>";
foreach ($rs_data  as  $row_data) {
$faculty_name =   $row_data['faculty_name']; 

  $num_group=Count_Faculty_Master($faculty_name,$id);
 if($num_group>0){
    
    $content .='<tr>
        <td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:40px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'.$i.'</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:102px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:14.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'.$faculty_name.'</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:147px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:14.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
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
        <p>&nbsp;&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:29px">
        <p>&nbsp;&nbsp;</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:21px">
        <p>&nbsp;&nbsp;</p>
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
      $sql_fac = "SELECT * FROM report_t3_graduate WHERE faculty_name='$faculty_name' AND (report_t3_graduate.degree_name='ปริญญาโท ระบบในเวลาราชการ' OR report_t3_graduate.degree_name='ปริญญาโท ระบบนอกเวลาราชการ' ) AND round_id=$id  GROUP BY report_t3_graduate.major_name ";
    $rs_fac  = $mysqli->query($sql_fac);
    $master_in = 0;
    $master_out = 0;
    $tatal_ma_in = 0;
    $tatal_ma_out = 0;
    $sum_in_out = 0;
    
    $tatal_sum_in_out = 0;
    $sum_weight_tatal  = 0;

     $tatal_sum_wigth=0;
    $j=1;
    foreach ($rs_fac  as  $row_fac) {
        $major = $row_fac['major_name'];
        $content .='<tr>
        <td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; width:40px">
        <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:102px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:14.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:147px">
        <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:14.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">'.$row_fac['major_name'].'</span></span></span></span></p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
        <p>'.$master_in=intval(Count_Major_Master_Out($row_fac['major_name'],$id)).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
        <p>'.$master_out=intval(Count_Major_Master_In($row_fac['major_name'],$id)).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
        <p>'.$sum_in_out=intval(Count_Major_Master_In($row_fac['major_name'],$id)+Count_Major_Master_Out($row_fac['major_name'],$id)).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:30px">';
              $is   = Count_Major_Master_ThesisIS($row_fac['major_name'],'การศึกษาค้นคว้าอิสระ',$id);
       $content .='<p>'.$is.'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:30px">';
                $thesis = Count_Major_Master_ThesisIS($row_fac['major_name'],'วิทยานิพนธ์',$id);
       $content .='<p>'.$thesis.'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:30px">
        <p>&nbsp;'.$weight_01=intval(Count_Major_Master_weight($major,'0.1',$id)).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
        <p>&nbsp;&nbsp;'.$weight_02=intval(Count_Major_Master_weight($major,'0.2',$id)).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
        <p>&nbsp;&nbsp;'.$weight_04=Count_Major_Master_weight($major,'0.4',$id).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
        <p>&nbsp;&nbsp;'.$weight_06=Count_Major_Master_weight($major,'0.6',$id).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
        <p>&nbsp;&nbsp;'.$weight_08=Count_Major_Master_weight($major,'0.8',$id).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:21px">
        <p>&nbsp;&nbsp;'.$weight_1=Count_Major_Master_weight($major,'1',$id).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:39px">
        <p>&nbsp;'.intval($weight_06=Count_Major_Master_weight($major,'0.1',$id)+$weight_06=Count_Major_Master_weight($major,'0.2',$id)+$weight_06=Count_Major_Master_weight($major,'0.4',$id)+$weight_06=Count_Major_Master_weight($major,'0.6',$id)+$weight_08=Count_Major_Master_weight($major,'0.8',$id)+$weight_1=Count_Major_Master_weight($major,'1',$id)).'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:57px">';
        $tatal_sum_wigth=number_format(((int)$weight_01*0.1)+((int)$weight_02*0.2)+((int)$weight_04*0.4)+((int)$weight_06*0.6)+((int)$weight_08*0.8)+((int)$weight_1*1),2);
       $content .='<p>'.$tatal_sum_wigth.'</p>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:71px">';
        $tt_ = intval(Count_Major_Master_In($row_fac['major_name'],$id)+Count_Major_Master_Out($row_fac['major_name'],$id));
        $BC=number_format(($tatal_sum_wigth/$tt_)*100,2);
       $content .='<p>'.$BC.'</p>
        </td>';
        $num_40 = ($BC*5)/40;
        if($num_40>=5){
            $num_40 = 5;  
        }else{
            $num_40;
        }
       $content .='<td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:49px">
        <p>'.number_format($num_40,2).'</p>
        </td>
    </tr>';
    $tatal_ma_in = ((int)$tatal_ma_in + (int)$master_in);
    $tatal_ma_out = ((int)$tatal_ma_out + (int)$master_out);
    $tatal_sum_in_out = ((int)$tatal_ma_out + (int)$tatal_ma_in);
    $sum_is = ((int)$sum_is + (int)$is);
    $sum_thesis = ((int)$sum_thesis + (int)$thesis);
 //   echo "<br>";
    //ค่าน้ำหนัก
    $sum_weight_01 = ((int)$sum_weight_01 + (int)$weight_01);
    $sum_weight_02 = ((int)$sum_weight_02 + (int)$weight_02);
    $sum_weight_04 = ((int)$sum_weight_04 + (int)$weight_04);
    $sum_weight_06 = ((int)$sum_weight_06 + (int)$weight_06);
    $sum_weight_08 = ((int)$sum_weight_08 + (int)$weight_08);
    $sum_weight_1 = ((int)$sum_weight_1 + (int)$weight_1);
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
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
    <p>'.$tatal_ma_in.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
    <p>'.$tatal_ma_out.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
    <p>'.$tatal_sum_in_out.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:60px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:66px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:30px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:21px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:39px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:57px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:71px">
    <p>&nbsp;</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:49px">
    <p>&nbsp;</p>
    </td>
</tr>';
$sum_all = ($sum_all + $tatal_sum_in_out);
$sum_all_in = ($sum_all_in + $tatal_ma_in);
$sum_all_out = ($sum_all_out + $tatal_ma_out);
$sum_master_in= ($sum_all_out + $tatal_ma_out);
//echo 'รวม'.$sum_master_in.'  '.$sum_master_in;
 } //เฉพาะคณะที่มีข้อมูล
 
 }//คณะ
} //กลุ่ม
$sum_thesis_all_butom =Count_SUM_Master_ThesisIS('วิทยานิพนธ์',$id);
$sum_is_all_butom =Count_SUM_Master_ThesisIS('การศึกษาค้นคว้าอิสระ',$id);
$content .='<tr>
    <td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; width:40px">
    <p style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:102px">
    <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:12.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span></span></span></span></p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:147px">
    <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:16.0pt"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><b>รวมระดับสถาบัน</b></span></span></span></span></p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
    <p>'.$sum_all_in.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
    <p>'.$sum_all_out.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:20px">
    <p>'.$sum_all.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:60px">
    <p>'.$sum_is_all_butom.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:66px">
    <p>'.$sum_thesis_all_butom.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:30px">
    <p>'.$sum_weight_01.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
    <p>'.$sum_weight_02.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:29px">
    <p>'.$sum_weight_04.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top;  text-align: center; vertical-align: middle; width:29px">
    <p>'.$sum_weight_06.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top;  text-align: center; vertical-align: middle; width:29px">
    <p>'.$sum_weight_08.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top;  text-align: center; vertical-align: middle; width:21px">
    <p>'.$sum_weight_1.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:39px">
    <p>&nbsp;'.$sum_all.'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:57px">';
     $sum_weight_tatal =($sum_weight_01*0.1)+($sum_weight_02*0.2)+($sum_weight_04*0.4)+($sum_weight_06*0.6)+($sum_weight_08*0.8)+($sum_weight_1*1);
   $content .='<p>'.number_format($sum_weight_tatal,2).'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:71px">';
   $c_100 =($sum_weight_tatal/$sum_all)*100;
    $content .= '<p>'.number_format($c_100,2).'</p>
    </td>
    <td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; text-align: center; vertical-align: middle; width:49px">';
    $C5num_40 = ($c_100*5)/40;
    if($C5num_40>=5){
        $C5num_40 = 5;  
    }else{
        $C5num_40;
    }
    $content .='<p>'.number_format($C5num_40,2).'</p>
    </td>
</tr>';
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

.orange {
      background-color: orange;
    }
    tr:nth-child(odd) {
      background-color: lightgray; /* แถวคี่ สีเทา */
    }
    tr:nth-child(even) {
      background-color: white; /* แถวคู่ สีขาว */
    }
</style>

