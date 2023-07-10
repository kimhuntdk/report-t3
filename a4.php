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

// สร้างตัวแปรสำหรับเก็บเนื้อหา PDF
$content = '';

// สร้างตาราง
$content .= '<table width="100%" style="border-collapse: collapse;">';
$content .= '<tr><th style="writing-mode: vertical-rl; transform: rotate(90deg);">std_id</th><th>ชื่อ</th><th>registration_date</th></tr>';

// ข้อความแนวตั้ง
$content .= '<tr>';
$content .= '<td style="writing-mode: vertical-rl; transform: rotate(90deg);">ID1</td>';
$content .= '<td style="writing-mode: vertical-rl; transform: rotate(180deg);">Name 1</td>';
$content .= '<td style="writing-mode: vertical-rl; transform: rotate(180deg);">2021-01-01</td>';
$content .= '</tr>';

$content .= '</table>';

// สร้างตัวแปรสำหรับเก็บตัว PDF
$mpdf->WriteHTML($content);
//echo 'จำนวนแถวที่เหลือ: ' . $remainingLines;
$mpdf->Output();
