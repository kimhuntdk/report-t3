<!DOCTYPE html>
<html>
<head>
    <title>Import Registrations</title>
</head>
<body>
    <h1>Import Registrations</h1>
    <!-- แทรกฟอร์มนำเข้าข้อมูลที่เกี่ยวข้องกับการ Import Registrations -->
    <form action="import_reg_process.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose file to import:</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="submit" value="Import Registrations">
    </form>
</body>
</html>
