<?php
$wrongMsg = '';
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['name']) && isset($_POST['user']) && isset($_POST['pass'])){
        if ($_POST['name'] == '' ){
            $wrongMsg = 'ادخل البيانات كاملة';
        }
        elseif ($_POST['user'] == ''){
            $wrongMsg = 'ادخل البيانات كاملة';
        }
        elseif ($_POST['pass'] == ''){
            $wrongMsg = 'ادخل البيانات كاملة';
        }
        else {
            $userName = $_POST['user'];
            $name = $_POST['name'];
            $password = $_POST['pass'];
            $phone = $_POST['phone'];
            $age = $_POST['age'];
            $signLevel = $_POST['signup'];

            try {
                $conn = new mysqli('localhost', 'root', '', 'dar_quran');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                if($signLevel == 'teach'){
                    $str = "INSERT INTO teachers (user,s_t,pic,phone,pass,fullname,circle,age,mosque) 
VALUES ('".$userName."', '1', 'userImage.png', '".$phone."', SHA1('".$password."'), '".$name."', '', '".$age."', '')";
                }
                elseif ($signLevel == 'stu'){
                    $str = "INSERT INTO teachers (user,s_t,pic,phone,pass,fullname,circle,age,mosque)
VALUES ('".$userName."', '0', 'userImage.png', '".$phone."', SHA1('".$password."'), '".$name."', '', '".$age."', '')";

                    $st = 'insert into grades (circle,fullname,user, pic) 
values ("", "'.$name.'", "'.$userName.'", "userImage.png")';
                    $res = $conn->query($st);
                    $conn->commit();
                }
                $result = $conn->query($str);
                $conn->commit();
                $conn->close();

                if ($signLevel == 'stu'){
                    if ($result == 1 && $res == 1){
                        header('location:mainPage.php');
                    }
                    else {
                        $wrongMsg = 'اسم المستخدم موجود بالفعل';
                    }
                }
                else {
                    if ($result == 1){
                        header('location:mainPage.php');
                    }
                    else {
                        $wrongMsg = 'اسم المستخدم موجود بالفعل';
                    }
                }
            }
            catch (Exception $e){
                echo 'اسم المستخدم موجود بالفعل';
            }
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>دار القرآن الكريم - بيتا</title>
    <link rel="stylesheet" href="cssFile/mainPage.css">
</head>
<body>
<div class="box">
    <nav class="navList">
        <ul>
            <li>
                <a id="main" class="link" href="mainPage.php" style="color: #997a00;">الرئيسية</a>
            </li>
            <li>
                <a class="link" href="TeachersPage.php">المدرسين</a>
            </li>
            <li>
                <a class="link" href="#">اخبار الحفاظ</a>
            </li>
            <li>
                <a class="link" href="#">المناسبات</a>
            </li>
        </ul>
    </nav>
    <div class="divBox">
        <form action="signUp.php" method="post" class="box2" >
            <h1>إنشاء حساب</h1>
            <div class="radioButton" style="margin: 10px";>
                <input type="radio" id="student" name="signup" checked="checked" value="stu">
                <label for="student">طالب</label>
                <input type="radio" id="teacher" name="signup" style="margin-left: 10px;" value="teach">
                <label for="teacher">مدرس</label>
            </div>
            <input class="inText" type="text" name="name" placeholder="الاسم الرباعي">
            <input class="inText" type="text" name="phone" placeholder="رقم الهاتف">
            <input class="inText" type="text" name="user" placeholder="اسم المستخدم">
            <input class="inText" type="password" name="pass" placeholder="كلمة المرور">
            <input class="inText" type="date" name="age">
            <input class="inText" type="submit" value="إنشاء" style="font-size: 22px;">
            <?php echo '<span style="color: red;font-family: ourFont;font-size: 16px;">'.$wrongMsg.'</span>'; ?>
        </form>
    </div>
    <img class="img" src="images/logo.png">
</div>
</body>
</html>