<?php include "session.php" ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Customer Update</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php include 'menu/navigation.php'; ?>
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <?php
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        include 'config/database.php';

        try {
            $query = "SELECT id, username, password, firstname, lastname, email, gender, date_of_birth, account_status, image FROM customers WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            $stmt->bindParam(1, $id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $username = $row['username'];
            $password = $row['password'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $email = $row['email'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $account_status = $row['account_status'];
            $image = $row['image'];
        }

        // show errors
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        if ($_POST) {
            try {
                $query = "UPDATE customers
                SET username=:username, firstname=:firstname, lastname=:lastname, gender=:gender, date_of_birth=:date_of_birth, email=:email, account_status=:account_status, image=:image";
                // prepare query for excecution

                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $email = htmlspecialchars(strip_tags($_POST['email']));
                $account_status = $_POST['account_status'];
                $image = !empty($_FILES["image"]["name"])
                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                : "";
                $image = htmlspecialchars(strip_tags($image));

                $errors = array();
                // check !empty, check format, compare new and confirm, then old compare db, old compare new.(password)
                if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
                    if ($new_password == $confirm_password) {
                        if (password_verify($old_password, $password)) {

                            if ($old_password == $new_password) {
                                $errors[] = "New password can't be same with old password";
                            } else {
                                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                            }
                        } else {
                            $errors[] = "Wrong password entered in old password column";
                        }
                    } else {
                        $errors[] = "The confirm password doesn't match with new password.";
                    }
                } else {
                    $hashed_password = $password;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid Email format.";
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $errorMessage) {
                        echo $errorMessage . "<br>";
                    }
                    echo "</div>";
                } else {
                    if (isset($hashed_password)) {
                        $query .= ", password=:password";
                    }

                    $query .= " WHERE id=:id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(':username', $username);
                    if (isset($hashed_password)) {
                        $stmt->bindParam(':password', $hashed_password);
                    }
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':account_status', $account_status);
                    $stmt->bindParam(':image', $image);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                         // now, if image is not empty, try to upload the image
                         if ($image) {
                            // upload to file to folder
                            $target_directory = "uploads/";
                            $target_file = $target_directory . $image;
                            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                            // error message is empty
                            $file_upload_error_messages = "";
                            // make sure that file is a real image
                            $check = getimagesize($_FILES["image"]["tmp_name"]);
                            if ($check !== false) {
                                // submitted file is an image
                            } else {
                                $file_upload_error_messages .= "<div>Submitted file is not an image.</div>";
                            }
                            // make sure certain file types are allowed
                            $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                            if (!in_array($file_type, $allowed_file_types)) {
                                $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                            }
                            // make sure file does not exist
                            if (file_exists($target_file)) {
                                $file_upload_error_messages = "<div>Image already exists. Try to change file name.</div>";
                            }
                            // make sure submitted file is not too large, can't be larger than 1 MB
                            if ($_FILES['image']['size'] > (1024000)) {
                                $file_upload_error_messages .= "<div>Image must be less than 1 MB in size.</div>";
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
            }
            // show errors
            catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>ERROR: " . $exception->getMessage() . "</div>";
            }
        } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>User Name</td>
                    <td><input type='text' name='username' value="<?php echo htmlspecialchars($username, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td><input type="password" name='old_password' class='form-control'></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type="password" name='new_password' class='form-control'></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" name='confirm_password' class='form-control'></td>
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
                    <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
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
                    <td>Email</td>
                    <td><input type='email' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td>
                        <?php
                        if ($image != "") {
                            echo '<img src="uploads/' . htmlspecialchars($image, ENT_QUOTES) . '">';
                        } else {
                            echo '<img src="img/customer_coming_soon.jpg" alt="image">';
                        }
                        ?>
                        <br>
                        <input type="file" name="image" class="form-control-file">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customer</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>