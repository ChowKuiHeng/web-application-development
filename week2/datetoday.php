<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Date today</title>
</head>

<body>

    <form>
        <?php
        // Get today's date
        $today = date('Y-m-d');
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        ?>

        <select name="day">
            <?php
            // Generate options for days
            for ($i = 1; $i <= 31; $i++) {
                $selected = ($i == $day) ? 'selected' : '';
                echo "<option value=\"$i\" $selected>$i</option>";
            }
            ?>
        </select>

        <select name="month">
            <?php
            // Generate options for months
            for ($i = 1; $i <= 12; $i++) {
                $selected = ($i == $month) ? 'selected' : '';
                $monthName = date("F", mktime(0, 0, 0, $i, 1, $year));
                echo "<option value=\"$i\" $selected>$monthName</option>";
            }
            ?>
        </select>

        <select name="year">
            <?php
            // Generate options for years
            for ($i = $year; $i >= 1900; $i--) {
                $selected = ($i == $year) ? 'selected' : '';
                echo "<option value=\"$i\" $selected>$i</option>";
            }
            ?>
        </select>

        </div>



</body>

</html>