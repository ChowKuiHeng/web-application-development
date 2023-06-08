<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Week 4 Question 4</title>
</head>

<body>
    <h2>Question 4</h2>
    <form method="post">
        <input type="text" name="number" placeholder="Enter a Number">
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $number = $_POST['number'];
        $sum = 0;

        if (empty($number) || !is_numeric($number)) {
            echo '<p style="color: red;">' . "Please fill in a number!" . '</p>';
        } else if ($number <= 1) {
            echo '<p style ="color: red;">' . "Please fill in a positive number that is larger than 1!" . '</p>';
        } else {
            for ($i = $number; $i >= 1; $i--) {
                $sum += $i;
            }
            $result = implode(' + ', range(1, $number)) . ' = ' . $sum;
            echo $result;
        }
    }
    ?>
</body>

</html>