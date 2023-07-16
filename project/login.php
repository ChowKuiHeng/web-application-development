<!DOCTYPE HTML>
<html>

<head>
    <title>Login Page</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Container -->
    <div class="container mt-5">
        <div class="page-header">
            <h1>Login Page</h1>
        </div>

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
                    $stmt->bindParam(':username_enter', $username_enter);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) {

                        if (password_verify($password_enter, $row['password'])) {
                            if ($row['account_status'] == 'Active') {
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
        <form action="" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username_enter" class="form-control" id="username_enter"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password_enter" class="form-control" id="password_enter"></td>

                </tr>
                <td></td>
                <td>
                    <input type='submit' value='Login' class='btn btn-primary' />
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