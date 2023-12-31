<?php
session_start();
include '../Connect/conn.php';
include "../Connect/session.php";
if (isset($_GET['id_plot_data']) && isset($_GET['plot_name'])) {
    $id_plot_data = $_GET['id_plot_data'];
    $name_plot = $_GET['plot_name'];
}
$sql_plot_plan = "SELECT * FROM `tb_plot` as a 
INNER JOIN tb_greenhouse as b on a.id_greenhouse = b.id_greenhouse 
INNER JOIN tb_farm as c on b.id_farm = c.id_farm 
INNER JOIN tb_user as d on c.id_user = d.id_user 
LEFT JOIN tb_planting as e on a.id_plot = e.id_plot
LEFT JOIN tb_veg_farm as vf on vf.id_veg_farm = e.id_veg_farm   
LEFT JOIN tb_vegetable as f on f.id_vegetable = vf.id_vegetable   
LEFT JOIN tb_fertilizationdate as g on   g.id_plot = e.id_plot
WHERE a.id_plot = '$id_plot_data' GROUP BY e.id_planting";
      $result_plan = mysqli_query($conn, $sql_plot_plan);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>

<body>
    <!-- เมนูด้านข้าง ( Side Menu ) -->
    <div class="d-flex flex-column p-3 text-white bg-dark side-menu" style="width: 250px; height: 100vh; position: fixed; left: -250px">
        <ul class="nav nav-pills flex-column mb-auto pt-4 side_nav_menu">
    </div>
    <div class="pt-5 main-content-div" style=" text-align: center;">
        <div class="container" style="margin-top: 20px;">


            <table class="table table-striped table-bordered">
                <caption class="caption-top">ตารางแสดงข้อมูลแปลง <?php echo "$name_plot" ?> </caption>
                <thead>
                  
                    
                    <th style="border: none;"> </th>
                    <th style="border: none; text-align: right;"> </th>

                   
                </thead>
                <thead class="table-dark">
                    <tr>
                        <th>แปลง</th>
                        <th colspan="2">ชื่อผัก</th>
                        <th>จำนวน</th>
                        <th>วันที่เก็บเกี่ยว</th>
                 
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ( $result_plan as $row) {
                        $thaimonth = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                        $thaiMonth = $thaimonth[date('n', strtotime($row["planting_date"])) - 1];
                    ?>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                        <th style="border: none;"></th>
                      
                        <tr class="text-center">

                            <td class="text-center"><?= $row["plot_name"] ?></td>

                            <td class="text-center">
                                <img src="../img/<?php echo $row['img_name'] ?>" style="width: 50px; border-radius: 50px;">
                            </td>


                            <td class="text-center"><?= $row["vegetable_name"] ?></td>
                            <td><?= $row["vegetable_amount"] ?></td>
                            <td><?= date('d ', strtotime($row["planting_date"])) ?><?= $thaiMonth ?></td>



                        </tr>
                    <?php
                    }
                    // mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>



</body>

</html>