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
            $stt = "update grades set circle = '".$teachCircle."' where user = '".$teachUser."'";
            $res = $conn->query($stt);
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
                $passWrong = '???????? ???????????? ?????????????? ??????????';
            }
            elseif ($_POST['newPass'] != '' && isset($_POST['newPass']) && $_POST['newPass'] == $_POST['confPass']){
                $teachPass = $_POST['newPass'];
                $str = 'update teachers set pass = SHA1("'.$teachPass.'") where user = "'.$teachUser.'"';
                $result = $conn->query($str);
                $passWrong = '???? ?????????????? ??????????';
                $passDone = 1;
            }
            else $passWrong = "???????? ???? ????????????????";
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
                        $sqr = "update grades set pic = '".$new_img_name."' where user = '".$teachUser."'";
                        mysqli_query($conn, $sqr);
                    }else {
                        $imgWrong = "You can't upload files of this type";
                    }
                }
            }else {
                $imgWrong = "unknown error occurred!";
            }

        }
    }
    $sql = "select * from grades where user = '".$teachUser."'";
    $result = $conn->query($sql);
    $part1 = '0'; $part2 = '0'; $part3 = '0'; $part4 = '0'; $part5 = '0';
    $part6 = '0'; $part7 = '0'; $part8 = '0'; $part9 = '0'; $part10 = '0';
    $part11 = '0'; $part12 = '0'; $part13 = '0'; $part14 = '0'; $part15 = '0';
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $part1 = $row['part1']; $part2 = $row['part2']; $part3 = $row['part3'];
            $part4 = $row['part4']; $part5 = $row['part5']; $part6 = $row['part6'];
            $part7 = $row['part7']; $part8 = $row['part8']; $part9 = $row['part9'];
            $part10 = $row['part10']; $part11 = $row['part11']; $part12 = $row['part12'];
            $part13 = $row['part13']; $part14 = $row['part14']; $part15 = $row['part15'];
        }
    }

    $_SESSION['p1'] = $part1; $_SESSION['p2'] = $part2; $_SESSION['p3'] = $part3; $_SESSION['p4'] = $part4; $_SESSION['p5'] = $part5;
    $_SESSION['p6'] = $part6; $_SESSION['p7'] = $part7; $_SESSION['p8'] = $part8; $_SESSION['p9'] = $part9; $_SESSION['p10'] = $part10;
    $_SESSION['p11'] = $part11; $_SESSION['p12'] = $part12; $_SESSION['p13'] = $part13; $_SESSION['p14'] = $part14; $_SESSION['p15'] = $part15;

}
catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>?????? ???????????? ???????????? - ????????????</title>
    <link rel="stylesheet" href="cssFile/TeacherMain.css">
</head>
<body>
<div class="slider">
    <div class="slider-2">
        <h1>?????? ???????????? ????????????</h1>
    </div>
    <hr style="border: 1px solid lavender; width: 85%; margin-left: 22px;" /><br/>
    <div class="slider-menu">
        <ul style="list-style: none;">
            <li onclick="display()" id="li1">
                <span><img class="iconImg" src="images/main.png">
                    <span style="color: black;">???????????? ???????????????? </span></span>
            </li>
            <li onclick="display2()">
                <span><img class="iconImg" src="images/profile.png">
                    <span>?????????? ???????????? </span></span>
            </li>
            <li>
                <a href="chart.php" target="_blank" style="text-decoration: none;"><img class="iconImg" src="images/chart.png">
                    <span>???????? ?????????????? </span></a>
            </li>
            <li onclick="display6()">
                <span><img class="iconImg" src="images/pass.png">
                    <span>???????? ???????????? </span></span>
            </li>
            <li onclick="signOut()">
                <a href="signOut.php" style="text-decoration: none;"><img class="iconImg" src="images/logOut.png">
                    <span>?????????? ???????????? </span></a>
            </li>
        </ul>
    </div>
</div>
<div id="content">
    <div class="head">
        <table>
            <tr>
                <td>
                    <?php echo "<span>??????????, ".$teachName."</span>"; ?>
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
                <div class="circleNumS">
                    <h1 style="font-size: 35px;">??????????</h1>
                    <h2 style="font-size: 30px; color: #29a329;">
                        <?php if($teachCircle == ''){
                            echo "???? ???????? ???? ???? ???????? ??????";
                        }
                        else {
                            echo $teachCircle;
                        }
                        ?>
                    </h2>
                </div>
            </td>
            <td>
                <div class="circleNumS">
                    <h1 style="font-size: 35px;">?????? ????????????</h1>
                    <h2 style="font-size: 30px;color: #29a329;">
                        <?php if($teachMosque == ''){
                            echo "???? ???????? ???? ???? ???????? ??????";
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
                <div class="stuDiv">
                    <h1 style="width: 575px;text-align: center;font-family: ourFont;font-size: 35px;padding-top: 10px;">??????????????</h1>
                    <table class="cirTable" style="width: 400px; margin-top: 20px;margin-left: 90px;">
                        <tr>
                            <td>?????????? ??????????</td>
                            <td><?php echo $part1; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part2; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part3; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part4; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part5; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part6; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part7; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part8; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part9; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ????????????</td>
                            <td><?php echo $part10; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ???????????? ??????</td>
                            <td><?php echo $part11; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ???????????? ??????</td>
                            <td><?php echo $part12; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ???????????? ??????</td>
                            <td><?php echo $part13; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ???????????? ??????</td>
                            <td><?php echo $part14; ?></td>
                        </tr>
                        <tr>
                            <td>?????????? ???????????? ??????</td>
                            <td><?php echo $part15; ?></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td>
                <div class="stuDiv">
                    <h1 style="width: 575px;text-align: center;font-family: ourFont;font-size: 35px;padding-top: 10px;">????????????</h1>
                    <table class="cirTable" style="width: 400px; margin-top: 20px;margin-left: 90px;">
                        <tr>
                            <td>?????? (??????)</td>
                            <td><?php
                                if ($part1 != "0" && $part1 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (??????????)</td>
                            <td><?php
                                if ($part2 != "0" && $part2 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (???? ??????)</td>
                            <td><?php
                                if ($part3 != "0" && $part3 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (?????? ?????? ??????????)</td>
                            <td><?php
                                if ($part4 != "0" && $part4 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (??????)</td>
                            <td><?php
                                if ($part5 != "0" && $part5 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (???????? ??????)</td>
                            <td><?php
                                if ($part6 != "0" && $part6 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (?????? ????????)</td>
                            <td><?php
                                if ($part7 != "0" && $part7 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (?????? ????????????)</td>
                            <td><?php
                                if ($part8 != "0" && $part8 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (?????? ????????)</td>
                            <td><?php
                                if ($part9 != "0" && $part9 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (?????? ??????????????)</td>
                            <td><?php
                                if ($part10 != "0" && $part10 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (?????? ?????? ???????? ????????)</td>
                            <td><?php
                                if ($part11 != "0" && $part11 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (???????? ?????????? ???? ??????????)</td>
                            <td><?php
                                if ($part12 != "0" && $part12 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (???? ????????)</td>
                            <td><?php
                                if ($part13 != "0" && $part13 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (?????????? ??????????)</td>
                            <td><?php
                                if ($part14 != "0" && $part14 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                        <tr>
                            <td>?????? (?????? ??????)</td>
                            <td><?php
                                if ($part15 != "0" && $part15 != null)
                                    echo "<span style='color: #29a329;'>???? ????????????????</span>";
                                else echo "<span style='color: red;'>???? ?????? ??????</span>";
                                ?></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>
<div id="profile">
    <form action="studentPage.php" method="post" class="proContent" enctype="multipart/form-data">
        <div class="upper">
            <div class="imagePro">
                <img src="uploads/<?php echo $imgName; ?>">
            </div>
        </div>
        <div class="lower">
            <div>
                <table class="proTable1" >
                    <tr>
                        <td style="width: 250px;">
                            <br/>
                            <h3><?php echo $teachName; ?></h3></br>

                            <h4>???????? ???????????? ????????????</h4><br/>
                        </td>
                        <td>
                            <p><?php if($teachCircle == ''){
                                    echo "???? ???????? ???? ???? ???????? ??????";
                                }
                                else {
                                    echo "?????????? : ".$teachCircle;
                                }
                                ?></p>
                            <input type="text" class="hiddenIn" placeholder="?????????? ????????????" name="circleName" id="circleName">
                            <p><?php if($teachMosque == ''){
                                    echo "???? ???????? ???? ???? ???????? ??????";
                                }
                                else {
                                    echo "???????????? : ".$teachMosque;
                                }
                                ?></p>
                            <input type="text" class="hiddenIn" placeholder="?????????? ????????????" name="mosqueName" id="mosqueName">
                        </td>
                        <td>
                            <p><?php if($teachPhone == ''){
                                    echo "???? ???????? ?????? ????????";
                                }
                                else {
                                    echo "?????? ???????????? : ".$teachPhone;
                                }
                                ?></p>
                            <input type="text" class="hiddenIn" placeholder="?????????? ?????? ????????????" name="phoneNum" id="phoneNum">
                            <p>
                                <?php if($teachAge == ''){
                                    echo "?????????? ?????????????? --";
                                }
                                else {
                                    echo "?????????? ?????????????? ".$teachAge;
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
                            <input type="submit" class="changePhoto" name="upload" value="?????????? ????????????">
                        </td>
                        <td>
                            <input type="submit" class="changePhoto" value="?????? ??????????????????">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
</div>
<div id="pass">
    <form action="studentPage.php" method="post" class="passForm">
        <table class="passTab" style="margin-top: 150px;">
            <tr>
                <td>
                    ?????????? ???????? ????????????
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="oldPass" placeholder="???????? ???????????? ??????????????">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="newPass" placeholder="???????? ???????????? ??????????????">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="password" name="confPass" placeholder="?????????? ???????? ????????????">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="?????? ??????????????????">
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
<script src="JS_File/studentJs.js"></script>
</body>
</html>