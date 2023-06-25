<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ic Check</title>
</head>

<body>
    <form method="POST" action="">
        <label for="ic_number">Enter Malaysian IC Number:</label><br>
        <input type="text" id="ic_number" name="ic_number" required pattern="\d{6}-\d{2}-\d{4}">
        <small>(Format: YYMMDD-PB-XXXX)</small><br><br>
        <input type="submit" value="Submit">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $icNumber = $_POST["ic_number"];

        // Remove any non-digit characters from the IC number
        $icNumber = preg_replace("/[^0-9]/", "", $icNumber);

        // Check if the IC number is valid
        if (strlen($icNumber) === 12) {
            $birthYear = substr($icNumber, 0, 2) + 2000;
            if ($birthYear >= date("Y")) {
                $birhtYear -= 100;
            }
            $birthMonth = substr($icNumber, 2, 2);
            $birthDay = substr($icNumber, 4, 2);

            $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $chineseZodiac = array("Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Sheep", "Monkey", "Rooster", "Dog", "Pig");
            // Check if the date of birth is valid
            if (checkdate($birthMonth, $birthDay, $birthYear)) {
                $formattedDate = date("M d, Y", strtotime("$birthYear-$birthMonth-$birthDay"));

                // Chinese Zodiac
                $chineseYear = ($birthYear - 1900) % 12;
                $chineseName = "";
                $chineseZodiacSign = $chineseZodiac[$chineseYear];
                echo "<br>Date of Birth: $formattedDate";
                echo "<br>Your Chinese Zodiac is " . "$chineseName <br>";
                if ($chineseYear === 0) {
                    $chineseName = "Rat";
                    echo "<img src = 'img/rat.jpg' alt = 'Rat'>";
                } elseif ($chineseYear === 1) {
                    $chineseName = "Ox";
                    echo "<img src = 'img/ox.jpg' alt = 'Ox'>";
                } elseif ($chineseYear === 2) {
                    $chineseName = "Tiger";
                    echo "<img src = 'img/tiger.jpg' alt = 'Tiger'>";
                } elseif ($chineseYear === 3) {
                    $chineseName = "Rabbit";
                    echo "<img src = 'img/rabbit.jpg' alt = 'Rabbit'>";
                } elseif ($chineseYear === 4) {
                    $chineseName = "Dragon";
                    echo "<img src = 'img/dragon.jpg' alt = 'Dragon'>";
                } elseif ($chineseYear === 5) {
                    $chineseName = "Snake";
                    echo "<img src = 'img/snake.jpg' alt = 'Snake'>";
                } elseif ($chineseYear === 6) {
                    $chineseName = "Horse";
                    echo "<img src = 'img/horse.jpg' alt = 'Horse'>";
                } elseif ($chineseYear === 7) {
                    $chineseName = "Goat";
                    echo "<img src = 'img/goat.jpg' alt = 'Goat'>";
                } elseif ($chineseYear === 8) {
                    $chineseName = "Monkey";
                    echo "<img src = 'img/monkey.jpg' alt = 'Monkey'>";
                } elseif ($chineseYear === 9) {
                    $chineseName = "Rooster";
                    echo "<img src = 'img/rooster.jpg' alt = 'Rooster'>";
                } elseif ($chineseYear === 10) {
                    $chineseName = "Dog";
                    echo "<img src = 'img/dog.jpg' alt = 'Dog'>";
                } elseif ($chineseYear === 11) {
                    $chineseName = "Pig";
                    echo "<img src = 'img/pig.jpg' alt = 'Pig'>";
                }




                if ($birthMonth == 1) {
                    if ($birthDay <= 18) {
                        $zodiac = "Capricorn";
                        echo "Your Zodiac is: Capricorn<br>";
                        echo "<img src = 'img/capricorn.jpg' alt = 'Capricorn'>";
                    } else {
                        $zodiac = "Aquarius";
                        echo "Your Zodiac is: Aquarius<br>";
                        echo "<img src = 'img/aquarius.jpg' alt = 'Aquarius'>";
                    }
                } else if ($birthMonth == 2) {
                    if ($birthDay <= 15) {
                        $zodiac = "Aquarius";
                        echo "Your Zodiac is: Aquarius<br>";

                        echo "<img src = 'img/aquarius.jpg' alt = 'Aquarius'>";
                    } else {
                        $zodiac = "Pisces";
                        echo "Your Zodiac is: Pisces<br>";

                        echo "<img src = 'img/pisces.jpg' alt = 'Pisces'>";
                    }
                } else if ($birthMonth == 3) {
                    if ($birthDay <= 11) {
                        $zodiac = "Pisces";
                        echo "Your Zodiac is: Pisces<br>";
                        echo "<img src = 'img/pisces.jpg' alt = 'Pisces'>";
                    } else {
                        $zodiac = "Aries";
                        echo "Your Zodiac is: Aries<br>";
                        echo "<img src = 'img/aries.jpg' alt = 'Aries'>";
                    }
                } else if ($birthMonth == 4) {
                    if ($birthDay <= 18) {
                        $zodiac = "Aries";
                        echo "Your Zodiac is: Aries<br>";
                        echo "<img src = 'img/aries.jpg' alt = 'Aries'>";
                    } else {
                        $zodiac = "Taurus";
                        echo "Your Zodiac is: Taurus<br>";
                        echo "<img src = 'img/taurus.jpg' alt = 'Taurus'>";
                    }
                } else if ($birthMonth == 5) {
                    if ($birthDay <= 13) {
                        $zodiac = "Taurus";
                        echo "Your Zodiac is: Taurus<br>";
                        echo "<img src = 'img/taurus.jpg' alt = 'Taurus'>";
                    } else {
                        $zodiac = "Gemini";
                        echo "Your Zodiac is: Gemini<br>";
                        echo "<img src = 'img/gemini.jpg' alt = 'Gemini'>";
                    }
                } else if ($birthMonth == 6) {
                    if ($birthDay <= 19) {
                        $zodiac = "Gemini";
                        echo "<br>Your Zodiac is: Gemini<br>";
                        echo "<img src = 'img/gemini.jpg' alt = 'Gemini'>";
                    } else {
                        $zodiac = "Cancer";
                        echo "<br>Your Zodiac is: Cancer<br>";
                        echo "<img src = 'img/cancer.jpg' alt = 'Cancer'>";
                    }
                } else if ($birthMonth == 7) {
                    if ($birthDay <= 20) {
                        $zodiac = "Cancer";
                        echo "<br>Your Zodiac is: Cancer<br>";
                        echo "<img src = 'img/cancer.jpg' alt = 'Cancer'>";
                    } else {
                        $zodiac = "Leo";
                        echo "<br>Your Zodiac is: Leo<br>";
                        echo "<img src = 'img/leo.jpg' alt = 'Leo'>";
                    }
                } else if ($birthMonth == 8) {
                    if ($birthDay <= 9) {
                        $zodiac = "Leo";
                        echo "<br>Your Zodiac is: Leo<br>";
                        echo "<img src = 'img/leo.jpg' alt = 'Leo'>";
                    } else {
                        $zodiac = "Virgo";
                        echo "<br>Your Zodiac is: Virgo<br>";

                        echo "<img src = 'img/virgo.jpg' alt = 'Virgo'>";
                    }
                } else if ($birthMonth == 9) {
                    if ($birthDay <= 15) {
                        $zodiac = "Virgo";
                        echo "<br>Your Zodiac is: Virgo<br>";

                        echo "<img src = 'img/virgo.jpg' alt = 'Virgo'>";
                    } else {
                        $zodiac = "Libra";
                        echo "<br>Your Zodiac is: Libra<br>";

                        echo "<img src = 'img/libra.jpg' alt = 'Libra'>";
                    }
                } else if ($birthMonth == 10) {
                    if ($birthDay <= 30) {
                        $zodiac = "Libra";
                        echo "<br>Your Zodiac is: Libra<br>";

                        echo "<img src = 'img/libra.jpg' alt = 'Libra'>";
                    } else {
                        $zodiac = "Scorpio";
                        echo "<br>Your Zodiac is: Scorpio<br>";

                        echo "<img src = 'img/scorpio.jpg' alt = 'Scorpio'>";
                    }
                } else if ($birthMonth == 11) {
                    if ($birthDay <= 22) {
                        $zodiac = "Scorpio";
                        echo "<br>Your Zodiac is: Scorpio<br>";

                        echo "<img src = 'img/scorpio.jpg' alt = 'Scorpio'>";
                    } else {
                        $zodiac = "Sagittarius";
                        echo "<br>Your Zodiac is: Sagittarius<br>";
                        echo "<img src = 'img/sagittarius.jpg' alt = 'Sagittarius'>";
                    }
                } else if ($birthMonth == 12) {
                    if ($birthDay <= 17) {
                        $zodiac = "Sagittarius";
                        echo "<br>Your Zodiac is: Sagittarius<br>";
                        echo "<img src = 'img/sagittarius.jpg' alt = 'Sagittarius'>";
                    } else {
                        $zodiac = "Capricorn";
                        echo "<br>Your Zodiac is: Capricorn<br>";
                        echo "<img src = 'img/capricorn.jpg' alt = 'Capricorn'>";
                    }
                }
            }
        }
    }
    ?>
</body>

</html>