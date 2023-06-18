<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $Day = $_POST['Day'];
        $Month = $_POST['Month'];
        $Year = $_POST['Year'];
        $gender = $_POST['gender'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $email = $_POST['email'];
        $formattedFirstName = ucwords(strtolower($firstName));
        $formattedLastName = ucwords(strtolower($lastName));



        $errors = array();

        if (empty($password)) {
            $errors['password'] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Password must be at least 6 characters long.";
        } else {
        }

        if (empty($confirmPassword)) {
            $errors['confirmPassword'] = "Confirm password is required.";
        } elseif ($password !== $confirmPassword) {
            $errors['confirmPassword'] = "Passwords do not match.";
        }

        if (!empty($errors)) {
            echo '<h2>Error:</h2>';
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li>' . $error . '</li>';
            }
            echo '</ul>';
            echo '<a href="registration_form.php"><button>Go back to the registration form</button>';
            exit;
        } else {

            echo "<h2>Registration Successful!</h2>";
            echo "<p>First Name: $formattedFirstName</p>";
            echo "<p>Last Name: $formattedLastName</p>";
            echo "<p>Date of Birth: $Day/$Month/$Year</p>";
            echo "<p>Gender: $gender</p>";
            echo "<p>Username: $username</p>";
            echo "<p>Email: $email</p>";
        }
    }
    ?>



</body>

</html>