<?php
$loop = 0;

try {
    $conn = new mysqli('localhost', 'root', '', 'dar_quran');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $st = "select * from teachers where s_t = 1";
    $res = $conn->query($st);
    for ($i = 0; $i < $res->num_rows ; $i++){
        $row = $res->fetch_assoc();

        $teachName[$i] = $row['fullname'];
        $teachCircle[$i] = $row['circle'];
        $teachMosque[$i] = $row['mosque'];
        $teachPhone[$i] = $row['phone'];
        $imgName[$i] = $row['pic'];
        $loop = $i + 1;
    }
}
catch (Exception $e){
    echo "Connection failed: " . $e->getMessage();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>دار القرآن الكريم - بيتا</title>
    <link rel="stylesheet" href="cssFile/TeachersCSS.css">
</head>
<body>
<header class="box">
    <nav class="navList">
        <ul>
            <li>
                <a id="main" class="link" href="mainPage.php" style="color: #997a00;">الرئيسية</a>
            </li>
            <li>
                <a class="link" href="TeachersPage.php">المدرسين</a>
            </li>
            <li>
                <a class="link" href="news.php">اخبار الحفاظ</a>
            </li>
            <li>
                <a class="link" href="events.php">المناسبات</a>
            </li>
        </ul>
    </nav>
</header>

<?php
for($j = 0; $j < $loop; $j++){?>
    <div class="proContent">
        <div class="upper">
            <div class="imagePro">
                <img src="uploads/<?php echo $imgName[$j]; ?>">
            </div>
        </div>
        <div class="lower">
            <div>
                <br/>
                <br/>
                <h3 style="font-size: 25px;"><?php echo $teachName[$j]; ?></h3><br/>

                <h4>مُحفظ للقرآن الكريم</h4><br/>
                <p><?php if($teachCircle[$j] == ''){
                        echo "لم يسجل في اي حلقة بعد";
                    }
                    else {
                        echo "الحلقة : ".$teachCircle[$j];
                    }
                    ?></p>
                <p><?php if($teachMosque[$j] == ''){
                        echo "لم يسجل في اي مسجد بعد";
                    }
                    else {
                        echo "المسجد : ".$teachMosque[$j];
                    }
                    ?></p>
                <p><?php if($teachPhone[$j] == ''){
                        echo "لا يوجد رقم هاتف";
                    }
                    else {
                        echo "رقم الهاتف : ".$teachPhone[$j];
                    }
                    ?></p>
            </div>
        </div>
    </div>
<?php } ?>
</body>
</html>