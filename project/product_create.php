<!DOCTYPE HTML>
<html>

<head>
    <title>Product Create</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation Menu -->
    <?php
    include 'navigation.php';
    ?>

    <!-- Container -->
    <div class="container mt-5">
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

                $errors = array();

                // $errors = array();

                // if (empty($name)) {
                //   $errors[] = "Name is required.";
                // } if (empty($description)) {
                //     $errors[] = "Description is required.";

                if (empty($name)) {
                    $errors[] = "Name is required.";
                }
                if (empty($description)) {
                    $errors[] = "Description is required.";
                }
                if (empty($price)) {
                    $errors[] = "Price is required.";
                } elseif (!is_numeric($price)) {
                    $errors[] = "Price must be a numeric value.";
                }
                if (empty($promotion_price)) {
                    $errors[] = "Promotion Price is required.";
                } elseif (!is_numeric($promotion_price)) {
                    $errors[] = "Promotion Price must be a numeric value.";
                } else if ($promotion_price >= $price) {
                    $errors[] = "Promotion price must be cheaper than the original price.";
                }
                if (empty($manufacture_date)) {
                    $errors[] = "Manufacture Date is required.";
                } else if ($expired_date <= $manufacture_date) {
                    $errors[] = "Expired date must be later than the manufacture date.";
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
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created,  promotion_price=:promotion_price , manufacture_date=:manufacture_date, expired_date=:expired_date, categories_name=:categories_name";
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
                    <td><input type="text" name="manufacture_date" class="form-control" id="manufacture_date"></td>
                </tr>

                <tr>
                    <td>Expired Date</td>
                    <td><input type="text" name="expired_date" class="form-control" id="expired_date"></td>
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