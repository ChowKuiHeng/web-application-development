<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Format</title>

    <style>
        .container {
            display: flex;
            font-size: 50px;
        }

        .month {
            text-transform: uppercase;
            color: #b86a34;

        }

        .style1 {
            color: #0000FF;

        }

        .color1 {
            color: rgb(91, 15, 0);

        }
    </style>
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
        <div class="month"><?php echo "<strong>$month </strong>"; ?></div>
        <?php echo "<strong> &nbsp$date </strong>"; ?>
        <div class="style1"><?php echo "&nbsp$day"; ?></div>
    </div>
    <div class="container">
        <div class="color1"><?php echo $hour; ?></div>
        <div class="color1"> <?php echo $min; ?></div>
        <?php echo $sec; ?>
    </div>

</body>

</html>