<?php
// คำสั่งเชื่อมต่อฐานข้อมูล
$servername = "localhost"; // เช่น localhost
$username = "root";
$password = "";
$dbname = "grad2023";

$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง report_t3_round
$sql = "SELECT * FROM report_t3_round";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Import Export Page</title>
    <!-- เรียกใช้ไลบรารี Bootstrap ในเอกสาร -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    body {
    /* กำหนดระยะห่างในทุกทิศทาง 10px */
    /* กำหนดสีพื้นหลังให้ body (เพื่อเปรียบเทียบตัวอย่าง) */
    background-color: #f0f0f0;
}

.custom-div {
    /* กำหนดระยะห่างในทุกทิศทาง 20px */
    padding: 20px;
    /* กำหนดสีพื้นหลังให้ div (เพื่อเปรียบเทียบตัวอย่าง) */
    background-color: #fff;
}
</style>
<body>
    <!-- ต่อไปให้เราสร้างเมนูในรูปแบบ Top Navigation ด้วยคลาสของ Bootstrap -->
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- เพิ่มโลโก้หรือชื่อเว็บไซต์ -->
        <a class="navbar-brand" href="#">GS-Report 4.1</a>

        <!-- ปุ่มเมนูหลัก -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- เมนูหลักและเมนูย่อย -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="import_grad.php">Import Graduates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="import_reg.php">Import Registrations</a>
                </li>
            </ul>
        </div>
    </nav>

    <h3>Export Data</h3>

    <body>
    <div class="custom-div">
        <form method="post" action="index.php" >
        <select name="round_id">
        <?php
        // วน loop ในการแสดงตัวเลือก
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["round_id"] . "'>" . $row["round_name"] . "</option>";
            }
        }
        
        ?>
    </select>
       <input type="submit" name="submit" value="submit">
        </form>
        <?php
            if(isset($_POST['submit'])){
                 $id=$_POST['round_id'];
        ?>
    <ul>
        <li><a href="cover.php?id=<?=$id;?>" target="_blank">Export Cover</a></li>
        <li><a href="t3_details.php?id=<?=$id;?>" target="_blank">Export Details</a></li>
        <li><a href="report-master.php?id=<?=$id;?>" target="_blank">Export Report Master</a></li>
        <li><a href="report-phd.php?id=<?=$id;?>" target="_blank">Export Report Doctor</a></li>
    </ul>
        <?php
            }
        ?>
    </div>

    <!-- นำเข้าไฟล์ JavaScript ของ Bootstrap ด้านล่างสุดของเอกสาร -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
