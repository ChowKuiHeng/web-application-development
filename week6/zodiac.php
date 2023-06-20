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
    if (isset($_POST['submit'])) {
        $day = $_POST["day"];
        $month = $_POST["month"];
        $year = $_POST["year"];

        $chineseZodiac = array("Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Sheep", "Monkey", "Rooster", "Dog", "Pig");

        $zodiacIndex = ($year - 1900) % 12;
        $chineseZodiacSign = $chineseZodiac[$zodiacIndex];

        if ($month == 1) {
            if ($day <= 18) {
                $zodiac = "Capricorn";
            } else {
                $zodiac = "Aquarius";
            }
        } else if ($month == 2) {
            if ($day <= 15) {
                $zodiac = "Aquarius";
            } else {
                $zodiac = "Pisces";
            }
        } else if ($month == 3) {
            if ($day <= 11) {
                $zodiac = "Pisces";
            } else {
                $zodiac = "Aries";
            }
        } else if ($month == 4) {
            if ($day <= 18) {
                $zodiac = "Aries";
            } else {
                $zodiac = "Taurus";
            }
        } else if ($month == 5) {
            if ($day <= 13) {
                $zodiac = "Taurus";
            } else {
                $zodiac = "Gemini";
            }
        } else if ($month == 6) {
            if ($day <= 19) {
                $zodiac = "Gemini";
            } else {
                $zodiac = "Cancer";
            }
        } else if ($month == 7) {
            if ($day <= 20) {
                $zodiac = "Cancer";
            } else {
                $zodiac = "Leo";
            }
        } else if ($month == 8) {
            if ($day <= 9) {
                $zodiac = "Leo";
            } else {
                $zodiac = "Virgo";
            }
        } else if ($month == 9) {
            if ($day <= 15) {
                $zodiac = "Virgo";
            } else {
                $zodiac = "Libra";
            }
        } else if ($month == 10) {
            if ($day <= 30) {
                $zodiac = "Libra";
            } else {
                $zodiac = "Scorpio";
            }
        } else if ($month == 11) {
            if ($day <= 22) {
                $zodiac = "Scorpio";
            } else {
                $zodiac = "Sagittarius";
            }
        } else if ($month == 12) {
            if ($day <= 17) {
                $zodiac = "Sagittarius";
            } else {
                $zodiac = "Capricorn";
            }
        }

        if (checkdate($month, $day, $year)) {
            echo "Your birthday is " . $day . "/" . $months[$month - 1] . "/" . $year . "<br>";
            echo "Your Chinese Zodiac is " . $chineseZodiacSign . ".<br>";
            echo "Your Zodiac is " . $zodiac . ".";
        } else {
            echo "Please select a valid date.";
        }
    }
    ?>
</body>

</html>