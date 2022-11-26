<?php
session_start();

if(isset($_SESSION['login'])){
    if($_SESSION['login'] == 1){

    }
    else header('location:mainPage.php');
}
else header('location:mainPage.php');

if($_SESSION['p1'] == null || $_SESSION['p1'] == '')
    $_SESSION['p1'] = 0;
if($_SESSION['p2'] == null || $_SESSION['p2'] == '')
    $_SESSION['p2'] = 0;
if($_SESSION['p3'] == null || $_SESSION['p3'] == '')
    $_SESSION['p3'] = 0;
if($_SESSION['p4'] == null || $_SESSION['p4'] == '')
    $_SESSION['p4'] = 0;
if($_SESSION['p5'] == null || $_SESSION['p5'] == '')
    $_SESSION['p5'] = 0;
if($_SESSION['p6'] == null || $_SESSION['p6'] == '')
    $_SESSION['p6'] = 0;
if($_SESSION['p7'] == null || $_SESSION['p7'] == '')
    $_SESSION['p7'] = 0;
if($_SESSION['p8'] == null || $_SESSION['p8'] == '')
    $_SESSION['p8'] = 0;
if($_SESSION['p9'] == null || $_SESSION['p9'] == '')
    $_SESSION['p9'] = 0;
if($_SESSION['p10'] == null || $_SESSION['p10'] == '')
    $_SESSION['p10'] = 0;
if($_SESSION['p11'] == null || $_SESSION['p11'] == '')
    $_SESSION['p11'] = 0;
if($_SESSION['p12'] == null || $_SESSION['p12'] == '')
    $_SESSION['p12'] = 0;
if($_SESSION['p13'] == null || $_SESSION['p13'] == '')
    $_SESSION['p13'] = 0;
if($_SESSION['p14'] == null || $_SESSION['p14'] == '')
    $_SESSION['p14'] = 0;
if($_SESSION['p15'] == null || $_SESSION['p15'] == '')
    $_SESSION['p15'] = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Chart</title>
</head>
<body>
<div>
    <canvas id="myChart" width="400" height="100"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let ctx = document.getElementById('myChart').getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['الجزء الاول', 'الجزء الثاني', 'الجزء الثالث',
                    'الجزء الرابع', 'الجزء الخامس', 'الجزء السادس',
                    'الجزء السابع', 'الجزء الثامن', 'الجزء التاسع',
                    'الجزء العاشر', 'الجزء الحادي عشر', 'الجزء الثاني عشر',
                    'الجزء الثالث عشر', 'الجزء الرابع عشر', 'الجزء الخامس عشر'],
                datasets: [{
                    label: '# مجموع علامات الجزء',
                    data: [<?php echo $_SESSION['p1']; ?>, <?php echo $_SESSION['p2']; ?>, <?php echo $_SESSION['p3']; ?>
                        , <?php echo $_SESSION['p4']; ?>, <?php echo $_SESSION['p5']; ?>, <?php echo $_SESSION['p6']; ?>
                        , <?php echo $_SESSION['p7']; ?>, <?php echo $_SESSION['p8']; ?>, <?php echo $_SESSION['p9']; ?>
                        , <?php echo $_SESSION['p10']; ?>, <?php echo $_SESSION['p11']; ?>, <?php echo $_SESSION['p12']; ?>
                        , <?php echo $_SESSION['p13']; ?>, <?php echo $_SESSION['p14']; ?>, <?php echo $_SESSION['p15']; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</div>
</body>
</html>