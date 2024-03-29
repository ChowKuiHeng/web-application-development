<?php include "session.php" ?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
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
            <h1>Contact</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        $customer_query = "SELECT id, username FROM customers";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_POST) {
            try {
                $customer = $_POST['customer'];
                $email = $_POST['email'];
                $phonenumber = $_POST['phonenumber'];
                $message = $_POST['message'];

                $errors = array();

                if (empty($customer)) {
                    $errors[] = "You need to select a username.";
                } 
                if (empty($email)) {
                    $errors[] = 'Email is required.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Invalid email format.';
                }
                if (empty($phonenumber)) {
                    $errors[] = "Phone number is required.";
                } elseif (!preg_match('/^[0-9]+$/', $phonenumber)) {
                    $errors[] = "Phone number must contain only digits.";
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
                    $query = "INSERT INTO contact SET username = :username, email = :email, phonenumber = :phonenumber, message = :message";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':username', $customer);
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
                    <td>Username</td>
                    <td>
                        <select class="form-select" name="customer">
                            <option value=''>Select a username</option>
                            <?php
                            // Fetch customers from the database
                            $query = "SELECT id, username FROM customers";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Generate select options
                            foreach ($customers as $customer) {
                                $customer_selected = isset($_POST["customer"]) && $customer['id'] == $_POST["customer"] ? "selected" : "";
                                echo "<option value='{$customer['id']}' $customer_selected>{$customer['username']}</option>";
                            }
                            ?>
                        </select>
                    </td>
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
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
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
