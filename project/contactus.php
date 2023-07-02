<!DOCTYPE HTML>
<html>

<head>
    <title>Contact Form</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Container -->
    <div class="container mt-5">
        <div class="page-header">
            <h1>Contact</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        if ($_POST) {
            try {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phonenumber = $_POST['phonenumber'];
                $message = $_POST['message'];

                $errors = array();

                // $errors = array();

                // if (empty($name)) {
                //   $errors[] = "Name is required.";
                // } if (empty($description)) {
                //     $errors[] = "Description is required.";

                if (empty($name)) {
                    $errors[] = "Name is required.";
                }
                if (empty($email)) {
                    $errors[] = 'Email is required.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Invalid email format.';
                }
                if (empty($phonenumber)) {
                    $errors[] = "Phonenumber is required.";
                }
                if (empty($message)) {
                    $errors[] = "Message is required.";
                }
                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo "<p class='error-message'>$error</p>";
                    }
                    echo "</div>";
                } else {
                    $query = "INSERT INTO contact SET name=:name, email=:email, phonenumber=:phonenumber, message=:message";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':phonenumber', $phonenumber);
                    $stmt->bindParam(':message', $message);


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
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name" class="form-control" id="name"></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><input type="text" name="phonenumber" class="form-control" id="phonenumber"></td>

                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" class="form-control" id="email"></td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td><textarea class="form-control" name="message" id="message"></textarea></td>

                </tr>

                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='index.php' class='btn btn-danger'>Back to read products</a>
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