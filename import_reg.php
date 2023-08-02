<!DOCTYPE html>
<html>
<head>
    <title>Import Registrations</title>
</head>
    <!-- เรียกใช้ไลบรารี Bootstrap ในเอกสาร -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<body>
        <!-- ต่อไปให้เราสร้างเมนูในรูปแบบ Top Navigation ด้วยคลาสของ Bootstrap -->
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- เพิ่มโลโก้หรือชื่อเว็บไซต์ -->
        <a class="navbar-brand" href="index.php">GS-Report 4.1</a>

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
    <h1>Import Registrations</h1>
    <!-- แทรกฟอร์มนำเข้าข้อมูลที่เกี่ยวข้องกับการ Import Registrations -->
    <form action="import_reg_process.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose file to import:</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="submit" value="Import Registrations">
    </form>
</body>
    <!-- นำเข้าไฟล์ JavaScript ของ Bootstrap ด้านล่างสุดของเอกสาร -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
