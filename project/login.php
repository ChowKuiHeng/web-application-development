<?php
session_start();
if (isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        form {
            background-image: url('../project/img/bluebg.jpg');
            background-size: cover;
            background-position: center;
            padding: 20px;
        }
    </style>

</head>

<body>
    <!-- Container -->
    <div class="container">

        <!-- PHP insert code will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        if ($_POST) {
            $username_enter = $_POST['username_enter'];
            $password_enter = $_POST['password_enter'];

            $errors = array();

            if (empty($username_enter)) {
                $errors[] = "Username/Email is required.";
            }
            if (empty($password_enter)) {
                $errors[] = "Password is required.";
            }
            if (!empty($errors)) {
                echo "<div class='alert alert-danger'>";
                foreach ($errors as $error) {
                    echo "<p class='error-message'>$error</p>";
                }
                echo "</div>";
            } else {
                try {
                    $query = "SELECT id, username, password, email,account_status FROM customers WHERE username=:username_enter OR email=:username_enter";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':username_enter', $username_enter);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) {

                        if (password_verify($password_enter, $row['password'])) {
                            if ($row['account_status'] == 'Active') {
                                $_SESSION['customer_id'] = $row['id'];
                                header("Location: index.php");
                                exit();
                            } else {
                                $error = "Inactive account.";
                                echo "<div class='alert alert-danger'>";

                                echo "<p class='error-message'>$error</p>";

                                echo "</div>";
                            }
                        } else {
                            $error = "Incorrect password.";
                            echo "<div class='alert alert-danger'>";

                            echo "<p class='error-message'>$error</p>";

                            echo "</div>";
                        }
                    } else {
                        $error = "Username/Email Not Found.";
                        echo "<div class='alert alert-danger'>";

                        echo "<p class='error-message'>$error</p>";

                        echo "</div>";
                    }
                } catch (PDOException $exception) {
                    $error = $exception->getMessage();
                }
            }
        }

        ?>

        <!-- HTML form here where the product information will be entered -->
        <div class="container">
            <div class="row justify-content-center align-items-center position-absolute top-50 start-50 translate-middle w-75">
                <div class="col-md text-center">
                    <img src="img/88speedmart.jpg" alt="88 Speedmart" class="img-fluid">
                </div>
                <div class="col-md">
                    <form action="" method="POST" class="d-flex flex-column">
                        <h2 class="text-center" style="color: #000000;">Welcome to 88 Speedmart</h2>
                        <div class="form-group">
                            <label for="username_enter" style="color: #000000;">Username/Email</label>
                            <input type="text" name="username_enter" class="form-control border mb-3" id="username_enter">

                            <label for="password_enter" style="color: #000000;">Password</label>
                            <input type="password" name="password_enter" class="form-control border mb-3" id="password_enter">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block w-25">Login</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- end .container -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>