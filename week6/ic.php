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
        $pattern = "/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/";

        if (preg_match($pattern, $icNumber)) {
            $birthMonth = substr($icNumber, 2, 2);
            $birthDay = substr($icNumber, 4, 2);
            $birthYear = substr($icNumber, 0, 2);
            $icplace = substr($icNumber, 7, 2);
            if ($birthYear > (date('Y') - 2000)) {
                $year = $birthYear + 1900;
            } else {
                $year = $birthYear + 2000;
            }

            $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $chineseZodiac = array("Monkey", "Rooster", "Dog", "Pig", "Rat", "Ox", "Tiger", "Rabbit", "Dragon", "Snake", "Horse", "Sheep");
            // Check if the date of birth is valid
            if (checkdate($birthMonth, $birthDay, $birthYear)) {
                $formattedDate = date("M d, Y", strtotime("$year-$birthMonth-$birthDay"));

                // Chinese Zodiac
                $chineseYear = $year % 12;
                $chineseName = "";
                $chineseZodiacSign = $chineseZodiac[$chineseYear];
                echo "<br>Date of Birth: $formattedDate";
                echo "<br>Your Chinese Zodiac is " . "$chineseName <br>";
                if ($chineseYear === 0) {
                    $chineseName = "Monkey";
                    echo "<img src = 'img/monkey.jpg' alt = 'Monkey'>";
                } elseif ($chineseYear === 1) {
                    $chineseName = "Rooster";
                    echo "<img src = 'img/rooster.jpg' alt = 'Rooster'>";
                } elseif ($chineseYear === 2) {
                    $chineseName = "Dog";
                    echo "<img src = 'img/dog.jpg' alt = 'Dog'>";
                } elseif ($chineseYear === 3) {
                    $chineseName = "Pig";
                    echo "<img src = 'img/pig.jpg' alt = 'Pig'>";
                } elseif ($chineseYear === 4) {
                    $chineseName = "Rat";
                    echo "<img src = 'img/rat.jpg' alt = 'Rat'>";
                } elseif ($chineseYear === 5) {
                    $chineseName = "Ox";
                    echo "<img src = 'img/ox.jpg' alt = 'Ox'>";
                } elseif ($chineseYear === 6) {
                    $chineseName = "Tiger";
                    echo "<img src = 'img/tiger.jpg' alt = 'Tiger'>";
                } elseif ($chineseYear === 7) {
                    $chineseName = "Rabbit";
                    echo "<img src = 'img/rabbit.jpg' alt = 'Rabbit'>";
                } elseif ($chineseYear === 8) {
                    $chineseName = "Dragon";
                    echo "<img src = 'img/dragon.jpg' alt = 'Dragon'>";
                } elseif ($chineseYear === 9) {
                    $chineseName = "Snake";
                    echo "<img src = 'img/snake.jpg' alt = 'Snake'>";
                } elseif ($chineseYear === 10) {
                    $chineseName = "Horse";
                    echo "<img src = 'img/horse.jpg' alt = 'Horse'>";
                } elseif ($chineseYear === 11) {
                    $chineseName = "Goat";
                    echo "<img src = 'img/goat.jpg' alt = 'Goat'>";
                }


                if ($birthMonth == 1) {
                    if ($birthDay <= 18) {
                        $zodiac = "Capricorn";
                        echo "<br>Your Zodiac is: Capricorn<br>";
                        echo "<img src = 'img/capricorn.jpg' alt = 'Capricorn'>";
                    } else {
                        $zodiac = "Aquarius";
                        echo "<br>Your Zodiac is: Aquarius<br>";
                        echo "<img src = 'img/aquarius.jpg' alt = 'Aquarius'>";
                    }
                } else if ($birthMonth == 2) {
                    if ($birthDay <= 15) {
                        $zodiac = "Aquarius";
                        echo "<br>Your Zodiac is: Aquarius<br>";

                        echo "<img src = 'img/aquarius.jpg' alt = 'Aquarius'>";
                    } else {
                        $zodiac = "Pisces";
                        echo "<br>Your Zodiac is: Pisces<br>";

                        echo "<img src = 'img/pisces.jpg' alt = 'Pisces'>";
                    }
                } else if ($birthMonth == 3) {
                    if ($birthDay <= 11) {
                        $zodiac = "Pisces";
                        echo "<br>Your Zodiac is: Pisces<br>";
                        echo "<img src = 'img/pisces.jpg' alt = 'Pisces'>";
                    } else {
                        $zodiac = "Aries";
                        echo "<br>Your Zodiac is: Aries<br>";
                        echo "<img src = 'img/aries.jpg' alt = 'Aries'>";
                    }
                } else if ($birthMonth == 4) {
                    if ($birthDay <= 18) {
                        $zodiac = "Aries";
                        echo "<br>Your Zodiac is: Aries<br>";
                        echo "<img src = 'img/aries.jpg' alt = 'Aries'>";
                    } else {
                        $zodiac = "Taurus";
                        echo "Your Zodiac is: Taurus<br>";
                        echo "<img src = 'img/taurus.jpg' alt = 'Taurus'>";
                    }
                } else if ($birthMonth == 5) {
                    if ($birthDay <= 13) {
                        $zodiac = "Taurus";
                        echo "<br>Your Zodiac is: Taurus<br>";
                        echo "<img src = 'img/taurus.jpg' alt = 'Taurus'>";
                    } else {
                        $zodiac = "Gemini";
                        echo "<br>Your Zodiac is: Gemini<br>";
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

            if ($icplace == 1 || $icplace == 21 || $icplace == 22 || $icplace == 23 || $icplace == 24) {
                $place = "Johor";
                echo "<br>You are from Johor<br>";
                echo "<img src = 'img/johor.jpg' alt = 'Johor' width=200>";
            } else if ($icplace == 2 || $icplace == 25 || $icplace == 26 || $icplace == 27) {
                $place = "Kedah";
                echo "<br>You are from Kedah<br>";
                echo "<img src = 'img/kedah.jpg' alt = 'Kedah' width=200>";
            } else if ($icplace == 3 || $icplace == 28 || $icplace == 29) {
                $place = "Kelantan";
                echo "<br>You are from Kelantan<br>";
                echo "<img src = 'img/kelantan.jpg' alt = 'Kelantan' width=200>";
            } else if ($icplace == 4 || $icplace == 30) {
                $place = "Malacca";
                echo "<br>You are from Malacca<br>";
                echo "<img src = 'img/kelantan.jpg' alt = 'Malacca' width=200>";
            } else if ($icplace == 5 || $icplace == 31 || $icplace == 59) {
                $place = "Negeri Sembilan";
                echo "<br>You are from Negeri Sembilan<br>";
                echo "<img src = 'img/negerisembilan.jpg' alt = 'Negeri Sembilan' width=200>";
            } else if ($icplace == 6 || $icplace == 32 || $icplace == 33) {
                $place = "Pahang";
                echo "<br>You are from Pahang<br>";
                echo "<img src = 'img/pahang.jpg' alt = 'Pahang' width=200>";
            } else if ($icplace == 7 || $icplace == 34 || $icplace == 35) {
                $place = "Penang";
                echo "<br>You are from Penang<br>";
                echo "<img src = 'img/penang.jpg' alt = 'Penang' width=200>";
            } else if ($icplace == 8 || $icplace == 36 || $icplace == 37 || $icplace == 38 || $icplace == 39) {
                $place = "Perak";
                echo "<br>You are from Perak<br>";
                echo "<img src = 'img/perak.jpg' alt = 'Perak' width=200>";
            } else if ($icplace == 9 || $icplace == 40) {
                $place = "Perlis";
                echo "<br>You are from Perlis<br>";
                echo "<img src = 'img/perlis.jpg' alt = 'Perlis' width=200>";
            } else if ($icplace == 10 || $icplace == 41 || $icplace == 42  || $icplace == 43  || $icplace == 44) {
                $place = "Perlis";
                echo "<br>You are from Perlis<br>";
                echo "<img src = 'img/perlis.jpg' alt = 'Perlis' width=200>";
            } else if ($icplace == 11 || $icplace == 45 || $icplace == 46) {
                $place = "Terrengganu";
                echo "<br>You are from Terrengganu<br>";
                echo "<img src = 'img/terrengganu.jpg' alt = 'Terrengganu' width=200>";
            } else if ($icplace == 12 || $icplace == 47 || $icplace == 48 || $icplace == 49) {
                $place = "Sabah";
                echo "<br>You are from Sabah<br>";
                echo "<img src = 'img/sabah.jpg' alt = 'Sabah' width=200>";
            } else if ($icplace == 13 || $icplace == 50 || $icplace == 51 || $icplace == 52 || $icplace == 53) {
                $place = "Sarawak";
                echo "<br>You are from Sarawak<br>";
                echo "<img src = 'img/sarawak.jpg' alt = 'Sarawak' width=200>";
            } else if ($icplace == 14 || $icplace == 54 || $icplace == 55 || $icplace == 56 || $icplace == 57) {
                $place = "Federal Territory of Kuala Lumpur";
                echo "<br>You are from Federal Territory of Kuala Lumpur<br>";
                echo "<img src = 'img/Federal_Territories_of_Malaysia.jpg' alt = 'Federal Territory of Kuala Lumpur' width=200>";
            } else if ($icplace == 15 || $icplace == 58) {
                $place = "Federal Territory of Labuan";
                echo "<br>You are from 	Federal Territory of Labuan<br>";
                echo "<img src = 'img/labuan.jpg' alt = 'Federal Territory of Labuan' width=200>";
            } else if ($icplace == 16) {
                $place = "Federal Territory of Putrajaya";
                echo "<br>You are from 	Federal Territory of Putrajaya<br>";
                echo "<img src = 'img/putrajaya.jpg' alt = 'Federal Territory of Putrajaya' width=200>";
            } else {
                $place = "Not Found";
            }
        }
    }
    ?>
</body>

</html>