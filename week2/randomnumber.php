<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="cssfile/randomnumber.css" />
    <title>Random Number</title>
</head>

<?php
$number1 = rand(100, 200);
$number2 = rand(100, 200);
$sum = $number1 + $number2;
$multiple = $number1 * $number2;
?>

<body>
    <p class="italic green"><?php echo $number1; ?></p>
    <p class="italic blue"><?php echo $number2; ?></p>
    <p class="bold red"><?php echo $sum; ?></p>
    <p class="bold italic"><?php echo $multiple; ?></p>
</body>

</html>