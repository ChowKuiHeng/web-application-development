<?php include "session.php" ?>

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
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $image = htmlspecialchars(strip_tags($image));

                $target_file = "";

                $errors = array();

                // now, if image is not empty, try to upload the image
                if ($image) {
                    // upload to file to folder
                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    //pathinfo找是不是.jpg,.png
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    $image_width = $check[0];
                    $image_height = $check[1];
                    if ($image_width != $image_height) {
                        $errors[] = "Only square size image allowed.";
                    }
                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if ($_FILES['image']['size'] > (524288)) {
                        $errors[] = "<div>Image must be less than 512 KB in size.</div>";
                    }
                    if ($check == false) {
                        // make sure that file is a real image
                        $errors[] = "<div>Submitted file is not an image.</div>";
                    }
                    // make sure certain file types are allowed
                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $errors[] = "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                    }
                    // make sure file does not exist
                    if (file_exists($target_file)) {
                        $errors[] = "<div>Image already exists. Try to change file name.</div>";
                    }
                }

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
                    $query = "INSERT INTO customers SET username=:username, password=:password,  firstname=:firstname, lastname=:lastname, email=:email, gender=:gender , date_of_birth=:date_of_birth,  registration_datetime=:registration_datetime, account_status=:account_status, image=:image";
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
                    $stmt->bindParam(':image', $target_file);


                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                        // make sure the 'uploads' folder exists
                        // if not, create it
                        if ($image) {
                            if ($image && file_exists($target_file)) {
                                unlink($target_file);
                            }

                            // make sure the 'uploads' folder exists
                            // if not, create it
                            if (!is_dir($target_directory)) {
                                mkdir($target_directory, 0777, true);
                            }
                            // if $file_upload_error_messages is still empty
                            if (empty($file_upload_error_messages)) {
                                // it means there are no errors, so try to upload the file
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                    // it means photo was uploaded
                                } else {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<div>Unable to upload photo.</div>";
                                    echo "<div>Update the record to upload photo.</div>";
                                    echo "</div>";
                                }
                            }

                            // if $file_upload_error_messages is NOT empty
                            else {
                                // it means there are some errors, so show them to user
                                echo "<div class='alert alert-danger'>";
                                echo "<div>{$file_upload_error_messages}</div>";
                                echo "<div>Update the record to upload photo.</div>";
                                echo "</div>";
                            }
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            } catch (PDOException $exception) {
                //  die('ERROR: ' . $exception->getMessage());
                if ($exception->getCode() == 23000) {
                    echo '<div class= "alert alert-danger role=alert">' . 'Username and Email has been taken. Please provide the new one' . '</div>';
                } else {
                    echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        }
        ?>

        <!-- HTML form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
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
                <tr>
                    <td>Photo</td>
                    <td><input type="file" name="image" /></td>
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