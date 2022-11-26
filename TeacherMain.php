<?php
session_start();
$passWrong = '';
$passDone = 0;
$imgWrong = '';

if(isset($_SESSION['login'])){
    if($_SESSION['login'] == 1){

    }
    else header('location:mainPage.php');
}
else header('location:mainPage.php');

$teachName = '';
$teachCircle = '';
$teachMosque = '';
$teachAge = '';
$teachPhone = '';
$imgName = 'userImage.png';

try {
    $conn = new mysqli('localhost', 'root', '','dar_quran');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $teachUser = $_SESSION['userName'];
    $teachPass = $_SESSION['password'];
    $st = "select * from teachers where user = '".$teachUser."'";
    $res = $conn->query($st);
    for ($i = 0; $i < $res->num_rows ; $i++){
        $row = $res->fetch_assoc();

        $teachName = $row['fullname'];
        $teachCircle = $row['circle'];
        $teachMosque = $row['mosque'];
        $teachAge = $row['age'];
        $teachPhone = $row['phone'];
        $imgName = $row['pic'];
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['circleName']) && $_POST['circleName'] != ''){
            $teachCircle = $_POST['circleName'];
            $str = 'update teachers set circle = "'.$teachCircle.'" where user = "'.$teachUser.'"';
            $result = $conn->query($str);
        }
        if(isset($_POST['mosqueName']) && $_POST['mosqueName'] != ''){
            $teachMosque = $_POST['mosqueName'];
            $str = 'update teachers set mosque = "'.$teachMosque.'" where user = "'.$teachUser.'"';
            $result = $conn->query($str);
        }
        if(isset($_POST['phoneNum']) && $_POST['phoneNum'] != ''){
            $teachPhone = $_POST['phoneNum'];
            $str = 'update teachers set phone = "'.$teachPhone.'" where user = "'.$teachUser.'"';
            $result = $conn->query($str);
        }
        if(isset($_POST['age']) && $_POST['age'] != ''){
            $teachAge = $_POST['age'];
            $str = 'update teachers set age = "'.$teachAge.'" where user = "'.$teachUser.'"';
            $result = $conn->query($str);
        }
        if(isset($_POST['oldPass']) && $_POST['oldPass'] != ""){
            if($_POST['oldPass'] != $_SESSION['password']) {
                $passWrong = 'كلمة المرور القديمة خاطئة';
            }
            elseif ($_POST['newPass'] != '' && isset($_POST['newPass']) && $_POST['newPass'] == $_POST['confPass']){
                $teachPass = $_POST['newPass'];
                $str = 'update teachers set pass = SHA1("'.$teachPass.'") where user = "'.$teachUser.'"';
                $result = $conn->query($str);
                $passWrong = 'تم التغيير بنجاح';
                $passDone = 1;
            }
            else $passWrong = "تأكد من البيانات";
        }
        if(isset($_POST['upload']) && isset($_FILES['file'])){
            $img_name = $_FILES['file']['name'];
	        $img_size = $_FILES['file']['size'];
	        $tmp_name = $_FILES['file']['tmp_name'];
	        $error = $_FILES['file']['error'];

	        if ($error === 0) {
		        if ($img_size > 125000) {
                    $imgWrong = "Sorry, your file is too large.";
		        }else {
			        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			        $img_ex_lc = strtolower($img_ex);

			        $allowed_exs = array("jpg", "jpeg", "png");

			        if (in_array($img_ex_lc, $allowed_exs)) {
				        $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				        $img_upload_path = 'uploads/'.$new_img_name;
				        move_uploaded_file($tmp_name, $img_upload_path);
				        $imgName = $new_img_name;
				        $sql = "update teachers set pic = '".$new_img_name."' where user = '".$teachUser."'";
				        mysqli_query($conn, $sql);
			        }else {
                        $imgWrong = "You can't upload files of this type";
			        }
		        }
	        }else {
                $imgWrong = "unknown error occurred!";
	        }

        }
        if(isset($_POST['postTextName']) && $_POST['postTextName'] != ""){
            $setPost = $_POST['postTextName'];
            $sql = "INSERT INTO news (news) VALUES ('".$setPost."')";
            $result = $conn->query($sql);
        }
        if (isset($_POST['postOccasions']) && $_POST['postOccasions'] != ""){
            $setPost = $_POST['postOccasions'];
            $sql = "INSERT INTO event (event_name) VALUES ('".$setPost."')";
            $result = $conn->query($sql);
        }
        if (isset($_POST['submitGrade'])){
            $studentName = $_POST['submitGrade'];
            $str = 'select user from teachers where fullname = "'.$studentName.'"';
            $result = $conn->query($str);
            $gradeUser = '';
            if ($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $gradeUser = $row['user'];
                }
            }
            $sql = 'update grades 
set part1 = "'.$_POST[$gradeUser."1"].'",
part2 = "'.$_POST[$gradeUser."2"].'",
part3 = "'.$_POST[$gradeUser."3"].'", 
part4 = "'.$_POST[$gradeUser."4"].'",
part5 = "'.$_POST[$gradeUser."5"].'",
part6 = "'.$_POST[$gradeUser."6"].'",
part7 = "'.$_POST[$gradeUser."7"].'",
part8 = "'.$_POST[$gradeUser."8"].'",
part9 = "'.$_POST[$gradeUser."9"].'",
part10 = "'.$_POST[$gradeUser."10"].'",
part11 = "'.$_POST[$gradeUser."11"].'",
part12 = "'.$_POST[$gradeUser."12"].'",
part13 = "'.$_POST[$gradeUser."13"].'",
part14 = "'.$_POST[$gradeUser."14"].'",
part15 = "'.$_POST[$gradeUser."15"].'" where user = "'.$gradeUser.'"';
            $result = $conn->query($sql);

        }

    }
    $sql = "SELECT news FROM news";
    $result = $conn->query($sql);
    $news_length = 0;
    if ($result->num_rows >= 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
            $news[$i] = $row['news'];
            $i++;
        }
        $news_length = $i - 1;
    }
    $sql = "SELECT event_name FROM event";
    $result = $conn->query($sql);
    $event_length = 0;
    if ($result->num_rows >= 0) {
        $i = 0;
        while($row = $result->fetch_assoc()) {
            $event[$i] = $row['event_name'];
            $i++;
        }
        $event_length = $i - 1;
    }
    $sql = "select * from grades where circle = '".$teachCircle."'";
    $result = $conn->query($sql);
    $loopNum = 0;
    if ($result->num_rows > 0){
        $i = 0;
        while ($row = $result->fetch_assoc()){
            $names[$i] = $row['fullname'];
            $pics[$i] = $row['pic'];
            $users[$i] = $row['user'];
            $part1[$i] = $row['part1']; $part2[$i] = $row['part2']; $part3[$i] = $row['part3'];
            $part4[$i] = $row['part4']; $part5[$i] = $row['part5']; $part6[$i] = $row['part6'];
            $part7[$i] = $row['part7']; $part8[$i] = $row['part8']; $part9[$i] = $row['part9'];
            $part10[$i] = $row['part10']; $part11[$i] = $row['part11']; $part12[$i] = $row['part12'];
            $part13[$i] = $row['part13']; $part14[$i] = $row['part14']; $part15[$i] = $row['part15'];
            $i++;
        }
        $loopNum = $i;
    }

}
catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>دار القرآن الكريم - المدرسين</title>
    <link rel="stylesheet" href="cssFile/TeacherMain.css">
</head>
<body>
<div class="slider">
    <div class="slider-2">
        <h1>دار القرآن الكريم</h1>
    </div>
    <hr style="border: 1px solid lavender; width: 85%; margin-left: 22px;" /><br/>
    <div class="slider-menu">
        <ul style="list-style: none;">
            <li onclick="display()" id="li1">
                <span><img class="iconImg" src="images/main.png">
                    <span style="color: black;">الصفحة الرئيسية </span></span>
            </li>
            <li onclick="display2()">
                <span><img class="iconImg" src="images/profile.png">
                    <span>الملف الشخصي </span></span>
            </li>
            <li onclick="display3()">
                <span><img class="iconImg" src="images/circule.png">
                    <span>حلقاتي </span></span>
            </li>
            <li onclick="display4()">
                <span><img class="iconImg" src="images/news.png">
                    <span>أخبار الحفاظ </span></span>
            </li>
            <li onclick="display5()">
                <span><img class="iconImg" src="images/Occasions.png">
                    <span>المناسبات </span></span>
            </li>
            <li onclick="display6()">
                <span><img class="iconImg" src="images/pass.png">
                    <span>كلمة المرور </span></span>
            </li>
            <li onclick="signOut()">
                <a href="signOut.php" style="text-decoration: none;"><img class="iconImg" src="images/logOut.png">
                    <span>تسجيل الخروج </span></a>
            </li>
        </ul>
    </div>
</div>
<div id="content">
    <div class="head">
        <table>
            <tr>
                <td>
                    <?php echo "<span>مرحبا, ".$teachName."</span>"; ?>
                </td>
                <td>
                    <img src="uploads/<?php echo $imgName; ?>" class="image">
                </td>
            </tr>
        </table>
    </div>
    <table>
        <tr>
            <td>
                <div class="circleNum">
                    <h1 style="font-size: 35px;">عدد الطلاب</h1>
                    <h2 style="font-size: 30px;color: #29a329;"><?php echo $loopNum;?></h2>
                </div>
            </td>
            <td>
                <div class="circleNum">
                    <h1 style="font-size: 35px;">حلقتي</h1>
                    <h2 style="font-size: 30px; color: #29a329;">
                        <?php if($teachCircle == ''){
                            echo "لم يسجل في اي حلقة بعد";
                        }
                        else {
                            echo $teachCircle;
                        }
                        ?>
                    </h2>
                </div>
            </td>
            <td>
                <div class="circleNum">
                    <h1 style="font-size: 35px;">إسم المسجد</h1>
                    <h2 style="font-size: 30px;color: #29a329;">
                        <?php if($teachMosque == ''){
                            echo "لم يسجل في اي مسجد بعد";
                        }
                        else {
                            echo $teachMosque;
                        }
                        ?>
                    </h2>
                </div>
            </td>

        </tr>
    </table>
    <table>
        <tr>
            <td>
                <div class="stuDiv" style="display: block;">
                    <h1 style="width: 575px;text-align: center;font-family: ourFont;font-size: 35px;padding-top: 10px;">طلابي</h1>
                    <?php
                    for ($j = 0; $j < $loopNum; $j++){
                        echo '<div style="height: 60px;width: 400px;margin-top: 10px;text-align: center;">
                            <table>
                                <tr>
                                    <td>
                                        <img src="uploads/'.$pics[$j].'" style="height: 50px;
                                        width: 50px;
                                        border-radius: 50%;
                                        margin-left: 15px;
                                        margin-top: 5px;">
                                    </td>
                                    <td>
                                    <span style="margin-left: 20px;
                                    font-size: 25px;
                                    color: #29a329;
                                    font-family: ourFont;">'.$names[$j].'</span>
                                    </td>
                                </tr>
                            </table>
                        </div>';
                    }?>
                </div>
            </td>
            <td>
                <div class="stuDiv">
                    <img src="images/logo.png" width="450px" height="450px" style="padding-top: 30px;padding-left: 60px">
                </div>
            </td>
        </tr>
    </table>
</div>
<div id="profile">
    <form action="TeacherMain.php" method="post" class="proContent" enctype="multipart/form-data">
        <div class="upper">
            <div class="imagePro">
                <img src="uploads/<?php echo $imgName; ?>">
            </div>
        </div>
        <div class="lower">
            <div>
                <table class="proTable1" >
                    <tr>
                        <td "width: 250px;">
                            <br/>
                            <h3><?php echo $teachName; ?></h3></br>

                            <h4>مُحفظ للقرآن الكريم</h4><br/>
                        </td>
                        <td>
                            <p><?php if($teachCircle == ''){
                                    echo "لم يسجل في اي حلقة بعد";
                                }
                                else {
                                    echo "حلقتي : ".$teachCircle;
                                }
                                ?></p>
                            <input type="text" class="hiddenIn" placeholder="تعديل الحلقة" name="circleName" id="circleName">
                            <p><?php if($teachMosque == ''){
                                    echo "لم يسجل في اي مسجد بعد";
                                }
                                else {
                                    echo "المسجد : ".$teachMosque;
                                }
                                ?></p>
                            <input type="text" class="hiddenIn" placeholder="تعديل المسجد" name="mosqueName" id="mosqueName">
                        </td>
                        <td>
                            <p><?php if($teachPhone == ''){
                                    echo "لا يوجد رقم هاتف";
                                }
                                else {
                                    echo "رقم الهاتف : ".$teachPhone;
                                }
                                ?></p>
                            <input type="text" class="hiddenIn" placeholder="تعديل رقم الهاتف" name="phoneNum" id="phoneNum">
                            <p>
                                <?php if($teachAge == ''){
                                    echo "تاريخ الميلاد --";
                                }
                                else {
                                    echo "تاريخ الميلاد ".$teachAge;
                                }
                                ?>
                            </p>
                            <input type="date" class="hiddenIn"  name="age" id="age">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="changeDiv">
                <table class="tab">
                    <tr>
                        <td>
                            <input type="file" name="file" style="font-family: ourFont;font-size: 17px;
                            border-radius: 6px; border: 1px solid #29a329; background-color: white; color: #29a329;">
                            <input type="submit" class="changePhoto" name="upload" value="تغيير الصورة">
                        </td>
                        <td>
                            <input type="submit" class="changePhoto" value="حفظ التغييرات">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <span style="font-family: ourFont;font-size: 20px;color: red;"> <?php echo $imgWrong; ?> </span>
    </form>
</div>
<div id="circles">
    <form class="cirForm" action="TeacherMain.php" method="post">
        <div style="text-align: center; padding: 20px;">
            <span style="font-family: ourFont;
            font-size: 45px;
            font-weight: bold;"><?php if($teachCircle == ''){
                echo "لم يسجل في اي حلقة بعد";
                }
                else {
                    echo $teachCircle;
                }
                ?></span>
        </div>
        <div>
            <table class="cirTable">
                <tr>
                    <td>
                        <span>اسم الطالب</span>
                    </td>
                    <td>
                        <span>جزء 1</span>
                    </td>
                    <td>
                        <span>جزء 2</span>
                    </td>
                    <td>
                        <span>جزء 3</span>
                    </td>
                    <td>
                        <span>جزء 4</span>
                    </td>
                    <td>
                        <span>جزء 5</span>
                    </td>
                    <td>
                        <span>جزء 6</span>
                    </td>
                    <td>
                        <span>جزء 7</span>
                    </td>
                    <td>
                        <span>جزء 8</span>
                    </td>
                    <td>
                        <span>جزء 9</span>
                    </td>
                    <td>
                        <span>جزء 10</span>
                    </td>
                    <td>
                        <span>جزء 11</span>
                    </td>
                    <td>
                        <span>جزء 12</span>
                    </td>
                    <td>
                        <span>جزء 13</span>
                    </td>
                    <td>
                        <span>جزء 14</span>
                    </td>
                    <td>
                        <span>جزء 15</span>
                    </td>
                </tr>
                <?php
                for ($j = 0; $j < $loopNum ; $j++){
                    echo '<tr>
                    <td style="width: 250px;">
                        <input type="submit" name="submitGrade" value="'.$names[$j].'">
                    </td>
                    <td>
                        <input type="text" value="'.$part1[$j].'" name="'.$users[$j].'1" placeholder="علامة 1" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part2[$j].'" name="'.$users[$j].'2" placeholder="علامة 2" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part3[$j].'" name="'.$users[$j].'3" placeholder="علامة3" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part4[$j].'" name="'.$users[$j].'4" placeholder="علامة 4" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part5[$j].'" name="'.$users[$j].'5" placeholder="علامة5" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part6[$j].'" name="'.$users[$j].'6" placeholder="علامة 6" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part7[$j].'" name="'.$users[$j].'7" placeholder="علامة 7" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part8[$j].'" name="'.$users[$j].'8" placeholder="علامة 8" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part9[$j].'" name="'.$users[$j].'9" placeholder="علامة 9" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part10[$j].'" name="'.$users[$j].'10" placeholder="علامة 10" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part11[$j].'" name="'.$users[$j].'11" placeholder="علامة 11" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part12[$j].'" name="'.$users[$j].'12" placeholder="علامة12"  style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part13[$j].'" name="'.$users[$j].'13" placeholder="علامة 13" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part14[$j].'" name="'.$users[$j].'14" placeholder="علامة 14" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                    <td>
                        <input type="text" value="'.$part15[$j].'" name="'.$users[$j].'15" placeholder="علامة 15" style="width: 30px;text-align: center;
                        height: 30px;border-radius: 6px;border-color: #29a329;font-family: ourFont;font-size: 16px">
                    </td>
                </tr>';
                }
                ?>
            </table>
        </div>
    </form>
</div>
<div id="news">
    <form action="TeacherMain.php" method="post">
        <table class="postTable">
            <tr>
                <td class="postTd">
                    <input type="text" name="postTextName" placeholder="اخبار الحفاظ ..." style="font-family: ourFont; font-size: 18px;padding-left: 15px;">
                </td>
                <td class="postTd">
                    <table style="width: 140px;">
                        <tr style="text-align: center; line-height: 85px;">
                            <td style="width: 70px; text-align: center;" id="submitPost">
                                <label for="sub"><img src="images/post.png" style="width: 30px;height: 30px;"></label>
                                <input type="submit" id="sub" value="" style="background: none; border: none;">
                            </td>
                            <td style="width: 70px; text-align: center;">
                                انشر
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php
        for ($s = $news_length;$s>=0;$s--){
            echo "<div style='width: 862px;
height: 200px;
border-radius: 6px;
background-color: white;
box-shadow: 0 1px 10px 1px lightgray;margin-top: 20px;
margin-left: 160px;padding: 10px 20px;
overflow: hidden;
font-family: ourFont;
font-size: 17px;
text-align: center;
line-height: 200px;'>".$news[$s]."</div>";} ?>
    </form>
</div>
<div id="Occasions">
    <form action="TeacherMain.php" method="post">
        <table class="postTable">
            <tr>
                <td class="postTd">
                    <input type="text" placeholder="مناسبة ..." style="font-family: ourFont; font-size: 18px;padding-left: 15px;" name="postOccasions">
                </td>
                <td class="postTd">
                    <table style="width: 140px;">
                        <tr style="text-align: center; line-height: 85px;">
                            <td style="width: 70px; text-align: center;" id="submitPost">
                                <label for="sub"><img src="images/post.png" style="width: 30px;height: 30px;"></label>
                                <input type="submit" id="sub" value="" style="background: none; border: none;">
                            </td>
                            <td style="width: 70px; text-align: center;">
                                انشر
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php
        for ($s = $event_length;$s>=0;$s--){
            echo "<div style='width: 862px;
height: 200px;
border-radius: 6px;
background-color: white;
box-shadow: 0 1px 10px 1px lightgray;margin-top: 20px;
margin-left: 160px;padding: 10px 20px;
overflow: hidden;
font-family: ourFont;
font-size: 17px;
text-align: center;
line-height: 200px;'>".$event[$s]."</div>";} ?>
    </form>
</div>
<div id="pass">
    <form action="TeacherMain.php" method="post" class="passForm">
        <table class="passTab" style="margin-top: 150px;">
            <tr>
                <td>
                    تغيير كلمة المرور
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="oldPass" placeholder="كلمة المرور القديمة">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="newPass" placeholder="كلمة المرور الجديدة">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="confPass" placeholder="تأكيد كلمة المرور">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="حفظ التغييرات">
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <?php
                    if($passDone == 1){
                        echo "<span style='color: #29a329;font-family: ourFont;font-size: 16px;'>".$passWrong."</span>";
                    }
                    else {
                        echo "<span style='color: red;font-family: ourFont;font-size: 16px;'>".$passWrong."</span>";
                    }
                    ?>
                </td>
            </tr>
        </table>
    </form>
</div>
<script src="JS_File/teacherMain.js"></script>
</body>
</html>