<?php include "session.php" ?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Create</title>
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
            <h1>Create Product</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        if ($_POST) {
            try {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];
                $categories_name = $_POST['categories_name'];
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
                    } else {
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

                if (empty($name)) {
                    $errors[] = "Name is required.";
                } elseif (preg_match('/\d/', $name)) {
                    $errors[] = 'Name cannot contain numeric values';
                }
                if (empty($description)) {
                    $errors[] = "Description is required.";
                }
                if (empty($price)) {
                    $errors[] = "Price is required.";
                } elseif (!is_numeric($price)) {
                    $errors[] = "Price must be a numeric value.";
                } else if ($promotion_price >= $price) {
                    $errors[] = "Promotion price must be cheaper than the original price.";
                }
                if (!empty($promotion_price) && !is_numeric($promotion_price)) {
                    $errors[] = 'Promotion price must be a numeric value.';
                }

                if (empty($manufacture_date)) {
                    $errors[] = "Manufacture Date is required.";
                } else if ($expired_date <= $manufacture_date) {
                    $errors[] = "Expired date must be later than the manufacture date.";
                }
                if ($manufacture_date > date('Y-m-d')) {
                    $errors[] = "Manufacture date cannot be greater than the current date.";
                }

                if (empty($expired_date)) {
                    $errors[] = "Expired Date is required.";
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo "<p class='error-message'>$error</p>";
                    }
                    echo "</div>";
                } else {
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created,  promotion_price=:promotion_price , manufacture_date=:manufacture_date, expired_date=:expired_date, categories_name=:categories_name , image=:image";
                    $stmt = $con->prepare($query);
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':created', $created);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    $stmt->bindParam(':categories_name', $categories_name);
                    $stmt->bindParam(':image', $target_file);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                        // make sure the 'uploads' folder exists
                        // if not, create it
                        if ($image) {
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
                echo "<div class='alert alert-danger'>Error: " . $exception->getMessage() . "</div>";
            }
        }
        ?>

        <!-- HTML form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name" class="form-control" id="name"></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea class="form-control" name="description" id="description"></textarea></td>

                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type="text" name="price" class="form-control" id="price"></td>
                </tr>

                <tr>
                    <td>Promotion Price</td>
                    <td><input type="text" name="promotion_price" class="form-control" id="promotion_price"></td>
                </tr>

                <tr>
                    <td>Manufacture Date</td>
                    <td><input type="date" name="manufacture_date" class="form-control" id="manufacture_date"></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type="date" name="expired_date" class="form-control" id="expired_date"></td>
                </tr>
                <tr>
                    <td>Categories Name</td>
                    <td> <select class="form-select" name="categories_name"><?php
                                                                            // Fetch categories from the database
                                                                            $query = "SELECT categories_name FROM categories";
                                                                            $stmt = $con->prepare($query);
                                                                            $stmt->execute();
                                                                            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

                                                                            // Generate select options
                                                                            foreach ($categories as $category) {
                                                                                echo "<option value='$category'>$category</option>";
                                                                            } ?></select>
                    </td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><input type="file" name="image" /></td>
                </tr>
                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
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