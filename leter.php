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

$content = '<table class="table table-bordered" style="border-collapse: collapse;" width="100%" border="1">
<thead style="display: table-header-group;">
<tr style="height: 46px;">
<td style="height: 170px; width: 38.2083px;" rowspan="3">
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
<td style="height: 46px; width: 60.3229px; text-align: center;">
<p>1</p>
</td>
</tr>
</thead>
<tr style="height: 46px;">
<td style="height: 46px; width: 38.2083px;">
<p>&nbsp;1</p>
</td>
<td style="height: 46px; width: 95.5px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 136.719px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 53.2812px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 44.2396px;">
<p>&nbsp;</p>
</td>
<td style="height: 46px; width: 67.3542px;">
<p>&nbsp;</p>
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
</tr>
</tbody>
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