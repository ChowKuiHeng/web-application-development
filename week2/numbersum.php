<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Number Sum</title>
</head>

<body>
    <div class="container">
        <?php
        $sum = 0;
        $numbers = array();

        for ($num = 1; $num <= 100; $num++) {
            if ($num % 2 == 0) {
                $sum += $num;
                $numbers[] = "<b>$num</b>";
            } else {
                $sum += $num;
                $numbers[] = $num;
            }
        }
        echo implode(" + ", $numbers) . " = " . $sum;
        ?>
    </div>
</body>

</html>