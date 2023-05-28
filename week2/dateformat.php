<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="cssfile/dateformat.css" />

    <title>Date Format</title>
</head>

<?php
date_default_timezone_set('asia/Kuala_Lumpur');
$month = date("M ");

$date = date("d, Y");

$day = date(" (D) ");

$hour = date("H");

$min = date(":i");

$sec = date(":s");

?>

<body>
    <div class="container">
        <div class="month"><?php echo "<strong> &nbsp$month </strong>"; ?></div>
        <?php echo "<strong> &nbsp$date </strong>"; ?>
        <div class="style1"><?php echo "&nbsp$day"; ?></div>
    </div>
    <div class="container">
        <div class="color1"><?php echo $hour; ?></div>
        <div class="color2"> <?php echo $min; ?></div>
        <?php echo $sec; ?>
    </div>

</body>

</html>