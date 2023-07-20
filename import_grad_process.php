<!-- import_grad_process.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];
    $fileType = pathinfo($file["name"], PATHINFO_EXTENSION);

    // ตรวจสอบประเภทของไฟล์ และนำเข้าข้อมูลตามที่คุณต้องการในรูปแบบ CSV
    if ($fileType == "csv") {
        // เพิ่มโค้ดสำหรับการนำเข้าข้อมูล CSV เพื่อบันทึกลงฐานข้อมูลหรือประมวลผลต่อไป
        // ...

        // ตัวอย่าง: แสดงข้อความเมื่อนำเข้าข้อมูลสำเร็จ
        echo "Graduates data imported successfully!";
    } else {
        echo "Invalid file type. Please select a CSV file.";
    }
}
?>

