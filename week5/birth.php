<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Week5 Question 1</title>
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
            foreach ($months as $month) {
                echo "<option value='$month'>$month</option>";
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
        echo "<h2>Details:</h2>";
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];

        if (isset($_POST['submit'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];

            if (empty($firstName) || empty($lastName)) {
                echo '<p style="color: red;">Please enter your name!</p>';
            } else {
                $formattedFirstName = ucwords(strtolower($firstName));
                $formattedLastName = ucwords(strtolower($lastName));
                echo "Name: " . $formattedLastName . " " . $formattedFirstName;
            }
        }
        $formattedName = ucwords(strtolower($firstName)) . ' ' . ucwords(strtolower($lastName));


        $birthdate = strtotime("$year-$month-$day");
        $age = date('Y') - date('Y', $birthdate);
        if (date('md') < date('md', $birthdate)) {
            $age--;
        }



        echo "<br>Birthdate: $day $month $year<br>";
        if ($age >= 18) {
            echo "Welcome! You are $age years old.";
        } else {
            echo '<p style="color: red;">Sorry,You are under age of 18!!</p>';
        }
    }
    ?>


</body>

</html>