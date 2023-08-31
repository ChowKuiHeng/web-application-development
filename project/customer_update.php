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
        // check if form was submitted
        if ($_POST) {
            try {
                if (isset($_POST['delete_image'])) {
                    $empty = "";
                    $delete_query = "UPDATE customers
                    SET image=:image  WHERE customers.id = :id";
                    $delete_stmt = $con->prepare($delete_query);
                    $delete_stmt->bindParam(":image", $empty);
                    $delete_stmt->bindParam(":id", $id);
                    $delete_stmt->execute();
                    unlink($image);
                    echo "<script>
                    window.location.href = 'customer_update.php?id={$id}';
             </script>";
                } else {
                    $query = "UPDATE customers SET firstname=:firstname, lastname=:lastname, gender=:gender, date_of_birth=:date_of_birth, account_status=:account_status, email=:email, image=:image";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // posted values
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $confirm_password = $_POST['confirm_password'];
                    $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                    $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                    $gender = $_POST['gender'];
                    $date_of_birth = $_POST['date_of_birth'];
                    $account_status = $_POST['account_status'];
                    $email = htmlspecialchars(strip_tags($_POST['email']));
                    // new 'image' field
                    $image = !empty($_FILES["image"]["name"])
                        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                        : "";
                    $image = htmlspecialchars(strip_tags($image));
                    // upload to file to folder
                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    //pathinfo找是不是.jpg,.png
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                    $errors = array();

                    // now, if image is not empty, try to upload the image
                    if ($image) {
                        $check = getimagesize($_FILES["image"]["tmp_name"]);

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
                        }else{
                            $image_width = $check[0];
                            $image_height = $check[1];
                            if ($image_width != $image_height) {
                                $errors[] = "Only square size image allowed.";
                            }
                        }
                        // make sure file does not exist
                        if (file_exists($target_file)) {
                            $errors[] = "<div>Image already exists. Try to change file name.</div>";
                        }
                    }

                    if (!empty($old_password) && !empty($new_password) && !empty($confirm_password)) {
                        // Password format validation
                        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[-+$()%@#]).{6,}$/', $new_password)) {
                            $errors[] = 'Invalid new password format.';
                        } else {
                            if ($new_password == $confirm_password) {
                                if (password_verify($old_password, $password)) {
                                    if ($old_password == $new_password) {
                                        $errors[] = "New password can't be the same as the old password.";
                                    } else {
                                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                                    }
                                } else {
                                    $errors[] = "Wrong password entered in the old password column.";
                                }
                            } else {
                                $errors[] = "The confirm password doesn't match the new password.";
                            }
                        }
                    } else {
                        $hashed_password = $password;
                    }

                    if (preg_match('/\d/', $firstname)) {
                        $errors[] = 'Firstname cannot contain numeric values';
                    }

                    if (preg_match('/\d/', $lastname)) {
                        $errors[] = 'Lastname cannot contain numeric values';
                    }

                    if ($date_of_birth > date('Y-m-d')) {
                        $errors[] = "Date of birth cannot be greater than the current date.";
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
                        if (isset($hashed_password)) {
                            $stmt->bindParam(':password', $hashed_password);
                        }
                        $stmt->bindParam(':firstname', $firstname);
                        $stmt->bindParam(':lastname', $lastname);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':date_of_birth', $date_of_birth);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':account_status', $account_status);
                        if ($image == "") {
                            $stmt->bindParam(":image", $row['image']);
                        } else {
                            $stmt->bindParam(':image', $target_file);
                        }

                        if ($stmt->execute()) {
                            echo "<script>
                            window.location.href = 'customer_read_one.php?id={$id}&action=record_updated';
                          </script>";

                            // make sure the 'uploads' folder exists
                            // if not, create it
                            if ($image) {
                                if ($target_file != $row['image'] && $row['image'] != "") {
                                    unlink($row['image']);
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
            }
            // show errors
            catch (PDOException $exception) {
                //  die('ERROR: ' . $exception->getMessage());
                if ($exception->getCode() == 23000) {
                    echo '<div class= "alert alert-danger role=alert">' . 'Username and Email has been taken. Please provide the new one' . '</div>';
                } else {
                    echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>User Name</td>
                    <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
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
                    <td><input type="radio" id="male" name="gender" value="Male" <?php if ($row['gender'] == "Male") {
                                                                                        echo 'checked';
                                                                                    } ?>>

                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="Female" <?php if ($row['gender'] == "Female") {
                                                                                            echo 'checked';
                                                                                        } ?>>
                        <label for="female">Female</label>
                    </td>
                </tr>
                <tr>
                    <td>Date of birth</td>
                    <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type="radio" id="active" name="account_status" value="Active" <?php if ($row['account_status'] == "Active") {
                                                                                                    echo 'checked';
                                                                                                } ?>>

                        <label for="active">Active</label>
                        <input type="radio" id="inactive" name="account_status" value="Inactive" <?php if ($row['account_status'] == "Inactive") {
                                                                                                        echo 'checked';
                                                                                                    } ?>>
                        <label for="inactive">Inactive</label>
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
                            echo '<img src="' . htmlspecialchars($image, ENT_QUOTES) . '" width="100">';
                        } else {
                            echo '<img src="img/customer_coming_soon.jpg" alt="image" width="100">';
                        }
                        ?>
                        <br>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <?php if ($image != "") { ?>
                            <input type="submit" value="Delete Image" class="btn btn-danger" name="delete_image">
                        <?php } ?>
                        <a href='customer_read.php' class='btn btn-info'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>