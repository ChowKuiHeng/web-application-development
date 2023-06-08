<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Week 4 Question 2</title>
    </head>

<body>
    <h2>Question 2</h2>
    <form method="POST">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName"><br><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName"><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
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
    ?>

</body>

</html>