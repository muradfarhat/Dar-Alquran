<?php
session_start();
$wrong = '';
$userName = '';
$password = '';
$_SESSION['login'] = 0;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['user']) && isset($_POST['pass'])){
        if ($_POST['user'] == '' || $_POST['pass'] == '') {
            $wrong = 'ادخل اسم المستخدم / كلمة المرور';
        }
        else {
            $userName = $_POST['user'];
            $password = $_POST['pass'];
            try {
                $conn = new mysqli('localhost', 'root', '', 'dar_quran');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $str = 'select * from teachers';
                $result = $conn->query($str);
                for ($i = 0; $i < $result->num_rows ; $i++){
                    $row = $result->fetch_assoc();
                    if($row['user'] == $userName && $row['pass'] == SHA1($password)){
                        if ($row['s_t'] == 1){
                            $_SESSION['login'] = 1;
                            $_SESSION['userName'] = $userName;
                            $_SESSION['password'] = $password;
                            $wrong = '';
                            header('location:TeacherMain.php');
                        }
                        else {
                            $_SESSION['login'] = 1;
                            $_SESSION['userName'] = $userName;
                            $_SESSION['password'] = $password;
                            $wrong = '';
                            header('location:studentPage.php');
                        }

                    }
                    else $wrong = 'اسم المستخدم / كلمة المرور خطأ';
                }
                $result->close();
                $conn->close();
            }
            catch (Exception $e) {
                echo "Connection failed: " . $e->getMessage();
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
                <a class="link" href="news.php">اخبار الحفاظ</a>
            </li>
            <li>
                <a class="link" href="events.php">المناسبات</a>
            </li>
        </ul>
    </nav>
    <div class="divBox">
        <form action="mainPage.php" method="post" id="box2" class="box2">
            <h1>تسجيل الدخول</h1>
            <input class="inText" type="text" name="user" placeholder="اسم المستخدم">
            <input class="inText" type="password" name="pass" placeholder="كلمة المرور">
            <input class="inText" type="submit" value="دخول" style="font-size: 22px;">
            <hr style="border: 1px solid #d9d9d9; width: 85%; margin-left: 22px;" /><br/>
            <a href="signUp.php" class="signUp">قم بإنشاء حساب</a>
            <?php echo "<br/><span style='color: red;font-size: 16px;font-family: ourFont;'>".$wrong."</span>"?>
        </form>
    </div>
    <img class="img" src="images/logo.png">
</div>
<script src="JS_File/signUp.js"></script>
</body>
</html>