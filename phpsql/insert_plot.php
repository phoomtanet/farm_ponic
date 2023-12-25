<?php
session_start();
include '../Connect/conn.php';
include '../Connect/session.php';

$nameplot = $_POST['nameplot'];
$rowplot  = $_POST['row'];
$columneplot  = $_POST['columne'];


// Check if $nameplot already exists in the database
$sql_check_duplicate = "SELECT COUNT(*) AS count FROM `tb_plot` WHERE `id_greenhouse` = (
    SELECT `id_greenhouse` FROM `tb_greenhouse` WHERE `name_greenhouse` = '$greenhouse_name'
) AND `plot_name` = '$nameplot'";

$result = mysqli_query($conn, $sql_check_duplicate);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    if ($count > 0) {
        echo "<script>alert('ชื่อแปลง $nameplot มีอยู่แล้ว กรุณากรอกชื่อแปลงที่ไม่ซ้ำ');</script>";
        echo "<script>window.location='../php/index.php'</script>";
    } else {
        // Insert the record since it doesn't exist in the database
        $sql_insert = "INSERT INTO `tb_plot`(`id_plot`, `id_greenhouse`, `plot_name`, `row`, `column`, `status`)
                       VALUES ('', (SELECT `id_greenhouse` FROM `tb_greenhouse` WHERE `name_greenhouse` = '$greenhouse_name'), '$nameplot', '$rowplot ', '$columneplot ', 0)";

        if (mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('*เพิ่มแปลงสำเร็จ*');</script>";
            echo "<script>window.location='../php/index.php'</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
