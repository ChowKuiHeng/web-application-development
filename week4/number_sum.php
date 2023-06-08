<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Week 4 Question 3</title>
</head>

<body>
    <h2>Question 3</h2>
    <form method="post">
        First Number: <input type="text" name="firstNumber"><br><br>
        Second Number: <input type="text" name="secondNumber"><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstNumber = $_POST["firstNumber"];
        $secondNumber = $_POST["secondNumber"];

        if (!is_numeric($firstNumber) || !is_numeric($secondNumber)) {
            echo '<p style="color: red;">Please fill in a number!</p>';
        } else {
            $sum = $firstNumber + $secondNumber;
            echo $sum;
        }
    }
    ?>

</body>

</html>