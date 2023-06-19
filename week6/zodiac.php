<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zodiac Signs</title>
</head>

<body>

    <form method="post">
        First Name: <input type="text" name="firstName"><br><br>
        Last Name: <input type="text" name="lastName"><br><br>
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
            foreach ($months as $x => $val) {
                $arraymonth = $x + 1;
                echo "<option value='$arraymonth'>$val</option>";
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
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $day = $_POST["day"];
        $month = $_POST["month"];
        $year = $_POST["year"];

        $chineseZodiac = array(
            0 => "Rat",
            1 => "Ox",
            2 => "Tiger",
            3 => "Rabbit",
            4 => "Dragon",
            5 => "Snake",
            6 => "Horse",
            7 => "Sheep",
            8 => "Monkey",
            9 => "Rooster",
            10 => "Dog",
            11 => "Pig"
        );

        $zodiacIndex = ($year - 1900) % 12;
        $chineseZodiacSign = $chineseZodiac[$zodiacIndex];

        $westernZodiacSign = "";


        if (checkdate(date_parse($month)["month"], $day, $year)) {
            $birthdate = date_parse($month)["month"] * 100 + $day;

            if (($birthdate >= 321 && $birthdate <= 419)) {
                $westernZodiacSign = "Aries";
            } elseif (($birthdate >= 420 && $birthdate <= 520)) {
                $westernZodiacSign = "Taurus";
            } elseif (($birthdate >= 521 && $birthdate <= 620)) {
                $westernZodiacSign = "Gemini";
            } elseif (($birthdate >= 621 && $birthdate <= 722)) {
                $westernZodiacSign = "Cancer";
            } elseif (($birthdate >= 723 && $birthdate <= 822)) {
                $westernZodiacSign = "Leo";
            } elseif (($birthdate >= 823 && $birthdate <= 922)) {
                $westernZodiacSign = "Virgo";
            } elseif (($birthdate >= 923 && $birthdate <= 1022)) {
                $westernZodiacSign = "Libra";
            } elseif (($birthdate >= 1023 && $birthdate <= 1121)) {
                $westernZodiacSign = "Scorpio";
            } elseif (($birthdate >= 1122 && $birthdate <= 1221)) {
                $westernZodiacSign = "Sagittarius";
            } elseif (($birthdate >= 1222 && $birthdate <= 119) || ($birthdate >= 101 && $birthdate <= 119)) {
                $westernZodiacSign = "Capricorn";
            } elseif (($birthdate >= 120 && $birthdate <= 218)) {
                $westernZodiacSign = "Aquarius";
            } else {
                $westernZodiacSign = "Pisces";
            }
        } else {

            $westernZodiacSign = "Invalid Date";
        }

        echo "<h2>Results:</h2>";
        echo "Name: $firstName $lastName<br>";
        echo "Birthday: $day $month $year<br>";
        echo "Chinese Zodiac Sign: $chineseZodiacSign<br>";
        echo "Western Zodiac Sign: $westernZodiacSign";
    }
    ?>

</body>

</html>