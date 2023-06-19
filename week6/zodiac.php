<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zodiac Signs</title>
</head>

<body>
    <form method="post">
        Birthday:
        <select name="day">
            <?php
            for ($day = 1; $day <= 31; $day++) {
                echo "<option value='$day'>$day</option>";
            }
            ?>
        </select>
        <select name="month">
            <?php
            $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            foreach ($months as $x => $month) {
                $arraymonth = $x + 1;
                echo "<option value='$arraymonth'>$month</option>";
            }
            ?>

        </select>
        <select name="year">
            <?php
            $currentYear = date("Y");
            for ($year = 1900; $year <= $currentYear; $year++) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>

        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $day = $_POST["day"];
        $months = $_POST["month"];
        $year = $_POST["year"];

        $chineseZodiac = array("Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Sheep", "Monkey", "Rooster", "Dog", "Pig");

        $zodiacIndex = ($year - 1900) % 12;
        $chineseZodiacSign = $chineseZodiac[$zodiacIndex];

        echo "<h2>Results:</h2>";
        echo "Birthday: $day $month $year<br>";
        echo "Chinese Zodiac Sign: $chineseZodiacSign<br>";
    }
    ?>

</body>

</html>