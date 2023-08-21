<?php include "session.php" ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Product Update</title>
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
            <h1>Update product</h1>
        </div>

        <!-- PHP insert code will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name, description, price, promotion_price, manufacture_date, expired_date, categories_name, image FROM products WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
            $categories_name = $row['categories_name'];
            $image = $row['image'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
        <?php
        include 'config/database.php';
        // check if form was submitted
        if ($_POST) {
            try {
                $query = "UPDATE products
                          SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date,categories_name=:categories_name,image=:image WHERE id = :id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = (strip_tags($_POST['price']));
                $promotion_price = (strip_tags($_POST['promotion_price']));
                $manufacture_date = (strip_tags($_POST['manufacture_date']));
                $expired_date = (strip_tags($_POST['expired_date']));
                $categories_name = htmlspecialchars(strip_tags($_POST['categories_name']));
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $image = htmlspecialchars(strip_tags($image));

                $errors = array();
                if (empty($name)) {
                    $errors[] = 'Product name is required.';
                }

                if (empty($description)) {
                    $errors[] = 'Description is required.';
                }

                if (empty($price)) {
                    $errors[] = "Price is required.";
                } elseif (!is_numeric($price)) {
                    $errors[] = "Product price must be a numeric value.";
                }

                if (empty($promotion_price)) {
                    $errors[] = 'Promotion price is required.';
                } elseif ($promotion_price >= $price) {
                    $errors[] = 'Promotion price must be cheaper than original price.';
                }

                if (empty($manufacture_date)) {
                    $errors[] = 'Manufacture date is required.';
                } elseif ($expired_date <= $manufacture_date) {
                    $errors[] = 'Expired date must be later than manufacture date.';
                }

                if (empty($expired_date)) {
                    $errors[] = "Expired date is required.";
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $error) {
                        echo $error . "<br>";
                    }
                    echo "</div>";
                } else {
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
                    // bind the parameters
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    $stmt->bindParam(':categories_name', $categories_name);
                    $stmt->bindParam(':image', $image);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                      
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>


        <!-- PHP post to update record will be here -->

        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='text' name='promotion_price' value="<?php echo htmlspecialchars($promotion_price, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' value="<?php echo htmlspecialchars($manufacture_date, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' value="<?php echo htmlspecialchars($expired_date, ENT_QUOTES); ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Categories</td>
                    <td>
                        <select class="form-select" name="categories_name">
                            <?php
                            // Fetch categories from the database
                            $query = "SELECT categories_name FROM categories";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            while ($category_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $all_category = $category_row['categories_name'];
                                $selected = ($all_category == $row['categories_name']) ? "selected" : "";
                                echo "<option value='" . $all_category . "' $selected>" . htmlspecialchars($all_category) . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td>
                        <?php
                        if ($image != "") {
                            echo '<img src="uploads/' . htmlspecialchars($image, ENT_QUOTES) . '">';
                        } else {
                            echo '<img src="img/product_coming_soon.jpg" alt="image">';
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