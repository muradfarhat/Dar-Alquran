<?php
$news_length = 0;
try {
    $conn = new mysqli('localhost', 'root', '', 'dar_quran');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}
catch (Exception $e){
    echo "Connection failed: " . $e->getMessage();
}
$sql = "SELECT news FROM news";
$result = $conn->query($sql);
if ($result->num_rows >= 0) {
    $i = 0;
    while($row = $result->fetch_assoc()) {
        $news[$i] = $row['news'];
        $i++;
    }
    $news_length = $i - 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>دار القرآن الكريم - بيتا</title>
    <link rel="stylesheet" href="cssFile/news.css">
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
for ($s = $news_length;$s>=0;$s--){
    echo "<div style='width: 862px;
height: 200px;
border-radius: 6px;
background-color: white;
box-shadow: 0 1px 10px 1px lightgray;margin-top: 20px;
margin-left: 300px;padding: 10px 20px;
overflow: hidden;
font-family: ourFont;
font-size: 17px;
text-align: center;
line-height: 200px;'>".$news[$s]."</div>";} ?>
</body>
</html>
