<!DOCTYPE HTML>
<html>

<head>
    <title>Customers</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Container -->
    <div class="container mt-5">
        <div class="page-header">
            <h1>Customers</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        if ($_POST) {
            try {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $registration_datetime = $_POST['registration_datetime'];
                $account_status = $_POST['account_status'];

                $errors = array();

                // $errors = array();

                // if (empty($name)) {
                //   $errors[] = "Name is required.";
                // } if (empty($description)) {
                //     $errors[] = "Description is required.";

                if (empty($username)) {
                    $errors[] = "Username is required.";
                }
                if (empty($password)) {
                    $errors[] = "Password is required.";
                }
                if (empty($firstname)) {
                    $errors[] = "Firstname is required.";
                }
                if (empty($lastname)) {
                    $errors[] = "Lastname is required.";
                }
                if (empty($gender)) {
                    $errors[] = "Gender is required.";
                }
                if (empty($date_of_birth)) {
                    $errors[] = "Date of birth is required.";
                }
                if (empty($registration_datetime)) {
                    $errors[] = "Registration date time is required.";
                }
                if (empty($account_status)) {
                    $errors[] = "Account Status is required.";
                }
                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo "<p class='error-message'>$error</p>";
                    }
                    echo "</div>";
                } else {
                    $query = "INSERT INTO cutomers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname,  gender=:gender , date_of_birth=:date_of_birth,  registration_datetime=:registration_datetime, account_status=:account_status";
                    $stmt = $con->prepare($query);
                    $registration_datetime = date('Y-m-d H:i:s');
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
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
            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>Error: " . $exception->getMessage() . "</div>";
            }
        }
        ?>

        <!-- HTML form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div class="row mb-3">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" name="username" class="form-control" id="username">
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input class="form-control" name="password" id="password"></input>
                </div>
            </div>
            <div class="row mb-3">
                <label for="firstname" class="col-sm-2 col-form-label">Firstname</label>
                <div class="col-sm-10">
                    <input type="text" name="firstname" class="form-control" id="firstname">
                </div>
            </div>
            <div class="row mb-3">
                <label for="lastname" class="col-sm-2 col-form-label">Lastname</label>
                <div class="col-sm-10">
                    <input type="text" name="lastname" class="form-control" id="lastname">
                </div>
            </div>
            <div class="row mb-3">
                <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                    <input type="text" name="gender" class="form-control" id="gender">
                </div>
            </div>
            <div class="row mb-3">
                <label for="date_of_birth" class="col-sm-2 col-form-label">Date of birth</label>
                <div class="col-sm-10">
                    <input type="text" name="date_of_birth" class="form-control" id="date_of_birth">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <input type="submit" value="Save" class="btn btn-primary" />
                    <a href="index.php" class="btn btn-danger">Back to read products</a>
                </div>
            </div>
        </form>

    </div>
    <!-- end .container -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>