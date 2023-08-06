<!DOCTYPE HTML>
<html>

<head>
    <title>Customers</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
  

    <!-- Container -->
    <div class="container"> 
    <!-- Navigation Menu -->
        <?php
        include 'menu/navigation.php';
        ?>
        <div class="page-header">
            <h1>Customers</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        date_default_timezone_set('asia/Kuala_Lumpur');
        // include database connection
        include 'config/database.php';

        if ($_POST) {
            try {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $account_status = $_POST['account_status'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $errors = array();

                // $errors = array();

                // if (empty($name)) {
                //   $errors[] = "Name is required.";
                // } if (empty($description)) {
                //     $errors[] = "Description is required.";

                if (empty($username)) {
                    $errors[] = "Username is required.";
                } elseif (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_-]{5,}$/', $username)) {
                    $errors[] = 'Invalid username format.';
                }
                if (empty($password)) {
                    $errors[] = "Password is required.";
                    if ($password !== $confirm_password) {
                        $errors[] = "Passwords do not match.";
                    }
                } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[-+$()%@#]).{6,}$/', $password)) {
                    $errors[] = 'Invalid password format.';
                }

                if (empty($firstname)) {
                    $errors[] = "Firstname is required.";
                }
                if (empty($lastname)) {
                    $errors[] = "Lastname is required.";
                }
                if (empty($email)) {
                    $errors[] = "Email is required.";
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Invalid email format.';
                }
                if (empty($gender)) {
                    $errors[] = "Gender is required.";
                }
                if (empty($date_of_birth)) {
                    $errors[] = "Date of birth is required.";
                }
                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo "<p class='error-message'>$error</p>";
                    }
                    echo "</div>";
                } else {
                    $query = "INSERT INTO customers SET username=:username, password=:password,  firstname=:firstname, lastname=:lastname, email=:email, gender=:gender , date_of_birth=:date_of_birth,  registration_datetime=:registration_datetime, account_status=:account_status";
                    $stmt = $con->prepare($query);
                    $registration_datetime = date('Y-m-d H:i:s');
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $hashed_password);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':registration_datetime', $registration_datetime);
                    $stmt->bindParam(':account_status', $account_status);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
                // } catch (PDOException $exception) {
                //     echo "<div class='alert alert-danger'>Error: " . $exception->getMessage() . "</div>";
                // }
            } catch (PDOException $exception) {
                //  die('ERROR: ' . $exception->getMessage());
                if ($exception->getCode() == 23000) {
                    echo '<div class= "alert alert-danger role=alert">' . 'Username has been taken' . '</div>';
                } else {
                    echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        }
        ?>

        <!-- HTML form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" class="form-control" id="username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" class="form-control" id="password"></td>

                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" name="confirm_password" class="form-control" id="confirm_password"></td>

                </tr>
                <tr>
                    <td>Firstname</td>
                    <td><input type="text" name="firstname" class="form-control" id="firstname"></td>
                </tr>

                <tr>
                    <td>Lastname</td>
                    <td><input type="text" name="lastname" class="form-control" id="lastname"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" class="form-control" id="email"></td>
                </tr>

                <tr>
                    <td>Gender</td>
                    <td><input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" required>
                        <label class="form-check-label" for="genderMale">
                            Male
                        </label>
                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" required>
                        <label class="form-check-label" for="genderFemale">
                            Female
                        </label>
                    </td>
                </tr>

                <tr>
                    <td>Date of birth</td>
                    <td><input type="date" name="date_of_birth" class="form-control" id="date_of_birth"></td>
                </tr>
                <tr>
                    <td>Account status</td>
                    <td><input class="form-check-input" type="radio" name="account_status" id="active" value="Active" required>
                        <label class="form-check-label" for="active">
                            Active
                        </label>
                        <input class="form-check-input" type="radio" name="account_status" id="inactive" value="Inactive" required>
                        <label class="form-check-label" for="inactive">
                            Inactive
                        </label>
                    </td>
                </tr>

                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='customer_read.php' class='btn btn-danger'>Back to read customer</a>
                </td>
                </tr>


            </table>
        </form>

    </div>
    <!-- end .container -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>