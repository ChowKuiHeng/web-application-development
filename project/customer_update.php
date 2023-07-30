<!DOCTYPE HTML>
<html>

<head>
    <title>Customer Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation Menu -->
    <?php
    include 'menu/navigation.php';
    ?>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, username, password, firstname, lastname, email, gender, date_of_birth, account_status FROM customers WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $username = $row['username'];
            $password = $row['password'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $email = $row['email'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $account_status = $row['account_status'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE customers
                SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, gender=:gender, date_of_birth=:date_of_birth, account_status=:account_status, email=:email WHERE id = :id";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                $account_status = htmlspecialchars(strip_tags($_POST['account_status']));

                // bind the parameters
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':date_of_birth', $date_of_birth);
                $stmt->bindParam(':account_status', $account_status);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <!-- HTML form to update record will be here -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td><input type="password" name='old_password' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type="password" name='new_password' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" name='confirm_password' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><input type='text' name='gender' value="<?php echo htmlspecialchars($gender, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Date of birth</td>
                    <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type='text' name='account_status' value="<?php echo htmlspecialchars($account_status, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>